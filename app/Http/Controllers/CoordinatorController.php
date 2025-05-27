<?php

namespace App\Http\Controllers;

use App\Models\Coordinator;
use App\Models\User;
use Illuminate\Http\Request;

class CoordinatorController extends Controller
{
    public function index()
    {
        $coordinators = Coordinator::with('user')->get();
        return view('coordinators.index', compact('coordinators'));
    }

    public function create()
    {
        return view('coordinators.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'document' => 'required|unique:users,document',
            'password' => 'required|min:6|confirmed',
            'departamento' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'document' => $request->document,
            'password' => bcrypt($request->password),
            'role' => 'coordenador',
        ]);

        Coordinator::create([
            'user_id' => $user->id,
            'departamento' => $request->departamento,
        ]);

        return redirect()->route('coordinators.index')->with('success', 'Coordenador cadastrado!');
    }

    public function edit(Coordinator $coordinator)
    {
        return view('coordinators.edit', compact('coordinator'));
    }

    public function update(Request $request, Coordinator $coordinator)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $coordinator->user_id,
            'document' => 'required|unique:users,document,' . $coordinator->user_id,
            'departamento' => 'required',
        ]);

        $coordinator->update($request->only('departamento'));

        $coordinator->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'document' => $request->document,
        ]);

        return redirect()->route('coordinators.index')->with('success', 'Coordenador atualizado!');
    }

    public function destroy(Coordinator $coordinator)
    {
        $coordinator->user->delete();
        return redirect()->route('coordinators.index')->with('success', 'Coordenador excluído!');
    }
}

