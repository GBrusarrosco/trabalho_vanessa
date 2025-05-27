<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->get();
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'document' => 'required|unique:users,document',
            'password' => 'required|min:6|confirmed',
            'area' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'document' => $request->document,
            'password' => bcrypt($request->password),
            'role' => 'professor',
        ]);

        Teacher::create([
            'user_id' => $user->id,
            'area' => $request->area,
            'observacoes' => $request->observacoes,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Professor cadastrado!');
    }

    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $teacher->user_id,
            'document' => 'required|unique:users,document,' . $teacher->user_id,
            'area' => 'required',
        ]);

        $teacher->update($request->only('area', 'observacoes'));

        $teacher->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'document' => $request->document,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Professor atualizado!');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->user->delete();
        return redirect()->route('teachers.index')->with('success', 'Professor excluído!');
    }
}

