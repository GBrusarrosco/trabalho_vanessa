<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->get();
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
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
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
        $student->user->delete();
        return redirect()->route('students.index')->with('success', 'Aluno excluído!');
    }
}
