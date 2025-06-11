<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Adicione este import
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * ATUALIZADO: Agora exibe uma lista de turmas para os perfis de gerenciamento.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Para o perfil 'aluno', a lógica permanece a mesma, mostrando seu próprio perfil.
        // Se desejar, pode-se criar uma view específica para isso.
        if ($user && $user->role === 'aluno') {
            $students = Student::with('user')->where('user_id', $user->id)->get();
            // Mantendo a view 'students.index' para o aluno, pois ela tem uma lógica condicional.
            return view('students.index', compact('students'));
        }

        // Nova lógica para Admin, Coordenador e Professor: Agrupar por turma.
        $turmasQuery = DB::table('students')
            ->select('turma', 'ano_letivo', DB::raw('count(*) as student_count'))
            ->groupBy('turma', 'ano_letivo')
            ->orderBy('ano_letivo', 'desc')
            ->orderBy('turma', 'asc');

        $turmas = $turmasQuery->get();

        return view('students.index', compact('turmas'));
    }

    /**
     * NOVO MÉTODO: Exibe a lista de alunos de uma turma específica.
     */
    public function showByClass($turma, $ano_letivo)
    {
        $this->authorize('manage-students'); // Garante que apenas perfis autorizados acessem

        $students = Student::with('user')
            ->where('turma', $turma)
            ->where('ano_letivo', $ano_letivo)
            ->get();

        return view('students.list', compact('students', 'turma', 'ano_letivo'));
    }


    /**
     * ATUALIZADO: Agora aceita turma e ano_letivo para pré-preencher o formulário.
     */
    public function create(Request $request)
    {
        $this->authorize('manage-students');

        $turma = $request->query('turma');
        $ano_letivo = $request->query('ano_letivo');

        return view('students.create', compact('turma', 'ano_letivo'));
    }

    /**
     * Sem alterações aqui, a lógica de armazenamento permanece a mesma.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'document' => 'required|string|unique:users,document',
            'password' => 'required|string|min:6|confirmed',
            'turma' => 'required|string|max:255',
            'ano_letivo' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'document' => $request->document,
            'password' => Hash::make($request->password),
            'role' => 'aluno',
        ]);

        Student::create([
            'user_id' => $user->id,
            'turma' => $request->turma,
            'ano_letivo' => $request->ano_letivo,
        ]);

        // Redireciona para a lista da turma recém-criada, se aplicável.
        if ($request->turma && $request->ano_letivo) {
            return redirect()->route('students.by_class', ['turma' => $request->turma, 'ano_letivo' => $request->ano_letivo])
                ->with('success', 'Aluno cadastrado com sucesso!');
        }

        return redirect()->route('students.index')->with('success', 'Aluno cadastrado com sucesso!');
    }


    public function edit(Student $student)
    {
        $this->authorize('manage-students', $student->user);
        return view('students.edit', compact('student'));
    }


    public function update(Request $request, Student $student)
    {
        $this->authorize('manage-students', $student->user);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->user_id,
            'document' => 'required|string|unique:users,document,' . $student->user_id,
            'turma' => 'required|string|max:255',
            'ano_letivo' => 'required|string|max:255',
        ]);

        $student->update($request->only('turma', 'ano_letivo'));

        $student->user->update($request->only('name', 'email', 'document'));

        return redirect()->route('students.by_class', ['turma' => $student->turma, 'ano_letivo' => $student->ano_letivo])
            ->with('success', 'Dados do aluno atualizados!');
    }


    public function destroy(Student $student)
    {
        $this->authorize('manage-students');
        $turma = $student->turma;
        $ano_letivo = $student->ano_letivo;
        $student->user->delete(); // Isso deve deletar o aluno também devido ao onDelete('cascade')

        return redirect()->route('students.by_class', ['turma' => $turma, 'ano_letivo' => $ano_letivo])
            ->with('success', 'Aluno excluído com sucesso!');
    }

    public function miniReport(Student $student)
    {
        $this->authorize('manage-students', $student->user);
        $answers = $student->answers()->with(['question.form.creator'])->latest()->get();
        return view('students.mini-report', compact('student', 'answers'));
    }

    public function showHistory()
    {
        $student = Auth::user()->student;

        if (!$student) {
            abort(404, 'Perfil de aluno não encontrado.');
        }

        // Busca as respostas e agrupa pelo formulário
        $answersByForm = $student->answers()
            ->with(['question.form']) // Carrega as relações para evitar N+1 queries
            ->get()
            ->groupBy('question.form.title');

        return view('students.history', compact('answersByForm'));
    }
}
