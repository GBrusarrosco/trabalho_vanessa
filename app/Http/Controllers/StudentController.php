<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        // Se for aluno, só mostra ele mesmo
        if ($user && $user->role === 'aluno') {
            $students = Student::with('user')->where('user_id', $user->id)->get();
        } else {
            $students = Student::with('user')
                ->when($request->filtro_nome, function($query, $nome) {
                    $query->whereHas('user', function($q) use ($nome) {
                        $q->where('name', 'like', "%$nome%");
                    });
                })
                ->when($request->filtro_turma, function($query, $turma) {
                    $query->where('turma', 'like', "%$turma%");
                })
                ->when($request->filtro_ano, function($query, $ano) {
                    $query->where('ano_letivo', 'like', "%$ano%");
                })
                ->get();
        }
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'document' => 'required|unique:users,document',
            'password' => 'required|min:6|confirmed',
            'turma' => 'required',
            'ano_letivo' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'document' => $request->document,
            'password' => bcrypt($request->password),
            'role' => 'aluno',
        ]);

        Student::create([
            'user_id' => $user->id,
            'turma' => $request->turma,
            'ano_letivo' => $request->ano_letivo,
        ]);

        return redirect()->route('students.index')->with('success', 'Aluno cadastrado com sucesso!');
    }

    public function edit(Student $student)
    {
        $user = Auth::user();
        // Só permite editar se for admin/coordenador ou o próprio aluno
        if ($user && ($user->role === 'admin' || $user->role === 'coordenador' || $student->user_id == $user->id)) {
            return view('students.edit', compact('student'));
        }
        abort(403);
    }

    public function update(Request $request, Student $student)
    {
        $user = Auth::user();
        if (!$user || (!in_array($user->role, ['admin', 'coordenador']) && $student->user_id != $user->id)) {
            abort(403);
        }
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'document' => 'required|unique:users,document,' . $student->user_id,
            'turma' => 'required',
            'ano_letivo' => 'required',
        ]);

        $student->update($request->only('turma', 'ano_letivo'));

        $student->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'document' => $request->document,
        ]);

        return redirect()->route('students.index')->with('success', 'Aluno atualizado!');
    }

    public function destroy(Student $student)
    {
        $user = Auth::user();
        if (!$user || (!in_array($user->role, ['admin', 'coordenador']) && $student->user_id != $user->id)) {
            abort(403);
        }
        $student->user->delete();
        return redirect()->route('students.index')->with('success', 'Aluno excluído!');
    }

    public function miniReport(Student $student)
    {
        $user = Auth::user();
        if (!$user || (!in_array($user->role, ['admin', 'coordenador']) && $student->user_id != $user->id)) {
            abort(403);
        }
        $answers = $student->answers()->with(['question.form.creator'])->latest()->get();
        return view('students.mini-report', compact('student', 'answers'));
    }
}
