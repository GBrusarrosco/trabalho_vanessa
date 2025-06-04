<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;     // Adicione esta linha
use App\Models\Teacher;     // Adicione esta linha
use App\Models\Coordinator; // Adicione esta linha
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered; // Adicione para o evento de registro

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
        // Esta view agora deve conter os campos condicionais
        return view('auth.custom-register');
    }

    public function register(Request $request)
    {
        // Validação dos dados recebidos do formulário
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'document' => 'required|string|max:255|unique:users,document',
            'password' => 'required|string|min:6|confirmed',
            'type' => 'required|in:aluno,professor,coordenador', // Campo para determinar o tipo de usuário

            // Campos condicionais baseados no 'type'
            'turma' => 'required_if:type,aluno|nullable|string|max:255',
            'ano_letivo' => 'required_if:type,aluno|nullable|string|max:255',

            'area' => 'required_if:type,professor|nullable|string|max:255',
            'observacoes' => 'nullable|string', // Observações para professor são opcionais

            'departamento' => 'required_if:type,coordenador|nullable|string|max:255',
        ]);

        // Criação do Usuário (User)
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'document' => $validatedData['document'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['type'], // Define o papel do usuário
            'email_verified_at' => now(), // Opcional: marcar como verificado no cadastro
        ]);

        // Criação do perfil específico (Aluno, Professor ou Coordenador)
        switch ($validatedData['type']) {
            case 'aluno':
                Student::create([
                    'user_id' => $user->id,
                    'turma' => $validatedData['turma'],
                    'ano_letivo' => $validatedData['ano_letivo'],
                ]);
                break;
            case 'professor':
                Teacher::create([
                    'user_id' => $user->id,
                    'area' => $validatedData['area'],
                    'observacoes' => $request->observacoes, // Vem do request, pois é nullable e pode não estar em $validatedData se vazio
                ]);
                break;
            case 'coordenador':
                Coordinator::create([
                    'user_id' => $user->id,
                    'departamento' => $validatedData['departamento'],
                ]);
                break;
        }

        event(new Registered($user)); // Dispara o evento de usuário registrado

        Auth::login($user); // Loga o usuário automaticamente após o registro

        // Redireciona para o dashboard com uma mensagem de sucesso
        return redirect()->route('dashboard')->with('success', 'Cadastro realizado com sucesso! Bem-vindo(a)!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
