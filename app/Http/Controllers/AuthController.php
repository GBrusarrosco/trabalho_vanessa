<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.custom-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Credenciais inválidas.']);
    }

    public function showRegisterForm()
    {
        return view('auth.custom-register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'document' => 'required|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'type' => 'required|in:aluno,professor,coordenador',
            'turma' => 'required_if:type,aluno',
            'ano_letivo' => 'required_if:type,aluno',
            'area' => 'required_if:type,professor',
            'departamento' => 'required_if:type,coordenador',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'document' => $request->document,
            'password' => Hash::make($request->password),
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'document' => $request->document,
            'password' => Hash::make($request->password),
        ]);

        switch ($request->type) {
            case 'aluno':
                $user->assignRole('aluno');
                $user->student()->create([
                    'turma' => $request->turma,
                    'ano_letivo' => $request->ano_letivo,
                ]);
                break;

            case 'professor':
                $user->assignRole('professor');
                $user->teacher()->create([
                    'area' => $request->area,
                    'observacoes' => $request->observacoes ?? null,
                ]);
                break;

            case 'coordenador':
                $user->assignRole('coordenador');
                $user->coordinator()->create([
                    'departamento' => $request->departamento,
                ]);
                break;
        }

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

