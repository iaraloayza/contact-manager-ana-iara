<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\TwoFactorRequest;
use App\Models\User;
use App\Models\Contact;
use App\Models\TwoFactorCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Carbon\Carbon;

class UserController extends Controller
{
    public function showLogin()
    {
        return Inertia::render('Auth/Login');
    }

    public function showRegister()
    {
        return Inertia::render('Auth/Register');
    }

    public function show2FA()
    {
        \Log::info('=== INICIO SHOW 2FA ===');
        \Log::info('Session ID: ' . session()->getId());
        \Log::info('Todas as sessões: ', session()->all());
        
        $tempUserData = session('temp_user_data');
        \Log::info('Dados temp_user_data: ', $tempUserData ? $tempUserData : ['VAZIO']);
        
        if (!$tempUserData) {
            \Log::error('ERRO: Dados temp_user_data não encontrados na sessão!');
            return redirect()->route('register')
                ->with('error', 'Sessão expirada. Faça o cadastro novamente.');
        }
        
        \Log::info('Email para 2FA: ' . $tempUserData['email']);
        \Log::info('=== FIM SHOW 2FA ===');
        
        return Inertia::render('Auth/TwoFactor', [
            'email' => $tempUserData['email']
        ]);
    }

    public function register(RegisterRequest $request)
    {
        try {
            // Debug - ID da sessão
            \Log::info('=== INICIO REGISTER ===');
            \Log::info('Session ID: ' . session()->getId());
            \Log::info('Dados recebidos: ', $request->all());
            
            // Verificar se o email já existe
            if (User::where('email', $request->email)->exists()) {
                \Log::info('Email já existe: ' . $request->email);
                return redirect()->back()
                    ->with('error', 'Este email já está em uso.')
                    ->withInput();
            }

            // Preparar dados para a sessão
            $tempUserData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'created_at' => now()->toDateTimeString(),
                'session_id' => session()->getId() // Para debug
            ];

            \Log::info('Dados preparados para sessão: ', $tempUserData);

            // Salvar na sessão
            session(['temp_user_data' => $tempUserData]);
            
            // Forçar gravação da sessão
            session()->save();
            
            \Log::info('Dados salvos na sessão');
            
            // Verificar se os dados foram salvos
            $savedData = session('temp_user_data');
            \Log::info('Dados recuperados da sessão: ', $savedData ? $savedData : ['VAZIO']);
            
            if (!$savedData) {
                \Log::error('ERRO: Dados não foram salvos na sessão!');
                return redirect()->back()
                    ->with('error', 'Erro interno. Tente novamente.')
                    ->withInput();
            }

            // Enviar código 2FA
            $this->sendTwoFactorCode($request->email);
            
            \Log::info('Código 2FA enviado para: ' . $request->email);
            \Log::info('=== FIM REGISTER ===');

            return redirect()->route('2fa.show')
                ->with('success', 'Verifique seu email para o código de verificação e complete o cadastro.');
                
        } catch (\Exception $e) {
            \Log::error('Erro no registro: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->with('error', 'Erro ao processar cadastro: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $errors = [];

            // Verificar se o usuário existe
            $user = User::where('email', $credentials['email'])->first();
            
            if (!$user) {
                $errors['email'] = 'Este email não está cadastrado em nosso sistema.';
            } else {
                // Verificar se a senha está correta
                if (!Hash::check($credentials['password'], $user->password)) {
                    $errors['password'] = 'A senha está incorreta.';
                }
            }

            // Se há erros, retornar com as mensagens específicas
            if (!empty($errors)) {
                return redirect()->back()
                    ->withErrors($errors)
                    ->withInput($request->only('email'));
            }

            // Se chegou até aqui, as credenciais estão corretas
            // Fazer login
            Auth::login($user);

            // Regenerar ID da sessão para segurança
            $request->session()->regenerate();

            // Login bem-sucedido
            return redirect()->route('contacts.index')
                ->with('success', 'Login realizado com sucesso!');
                
        } catch (\Exception $e) {
            \Log::error('Erro no login: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            \Log::error('Email tentativa: ' . $request->email);
            
            return redirect()->back()
                ->withErrors(['email' => 'Erro interno do sistema. Tente novamente em alguns instantes.'])
                ->withInput($request->only('email'));
        }
    }

    public function verifyTwoFactor(TwoFactorRequest $request)
    {
        $tempUserData = session('temp_user_data');
        
        if (!$tempUserData) {
            return redirect()->route('register')
                ->with('error', 'Sessão expirada. Faça o cadastro novamente.');
        }

        // Verificar se os dados da sessão não são muito antigos (30 minutos)
        if (isset($tempUserData['created_at'])) {
            $createdAt = Carbon::parse($tempUserData['created_at']);
            if ($createdAt->diffInMinutes(now()) > 30) {
                session()->forget('temp_user_data');
                return redirect()->route('register')
                    ->with('error', 'Sessão expirada. Faça o cadastro novamente.');
            }
        }

        $email = $tempUserData['email'];

        $code = TwoFactorCode::where('email', $email)
            ->where('code', $request->code)
            ->where('used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$code) {
            return redirect()->back()
                ->with('error', 'Código inválido ou expirado.');
        }

        try {
            // Verificar novamente se o email não foi usado durante o processo
            if (User::where('email', $email)->exists()) {
                session()->forget('temp_user_data');
                return redirect()->route('register')
                    ->with('error', 'Este email já está em uso. Tente com outro email.');
            }

            // Criar o usuário no banco de dados
            $user = User::create([
                'name' => $tempUserData['name'],
                'email' => $tempUserData['email'],
                'password' => $tempUserData['password'],
            ]);

            // Marcar código como usado
            $code->update(['used' => true]);

            // Fazer login do usuário
            Auth::login($user);

            // Limpar dados temporários da sessão
            session()->forget('temp_user_data');

            return redirect()->route('contacts.index')
                ->with('success', 'Cadastro realizado com sucesso! Bem-vindo(a)!');

        } catch (\Exception $e) {
            \Log::error('Erro ao finalizar cadastro: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao finalizar cadastro: ' . $e->getMessage());
        }
    }

    public function resendCode(Request $request)
    {
        $tempUserData = session('temp_user_data');
        
        if (!$tempUserData) {
            return redirect()->route('register')
                ->with('error', 'Sessão expirada. Faça o cadastro novamente.');
        }

        try {
            $this->sendTwoFactorCode($tempUserData['email']);
            
            return redirect()->back()
                ->with('success', 'Novo código enviado para seu email.');
                
        } catch (\Exception $e) {
            \Log::error('Erro ao reenviar código: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao reenviar código. Tente novamente.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Logout realizado com sucesso!');
    }

    private function sendTwoFactorCode($email)
    {
        // Invalidar códigos anteriores
        TwoFactorCode::where('email', $email)
            ->where('used', false)
            ->update(['used' => true]);

        // Gerar novo código
        $code = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        
        TwoFactorCode::create([
            'email' => $email,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(15),
        ]);

        // Enviar email usando a sintaxe moderna
        try {
            Mail::send('emails.two-factor', ['code' => $code], function ($message) use ($email) {
                $message->to($email)
                    ->subject('Código de Verificação - Sistema de Contatos')
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            \Log::info('Email enviado com sucesso para: ' . $email);
            
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar email: ' . $e->getMessage());
            throw $e;
        }
    }

    public function showProfile()
    {
        return Inertia::render('Auth/Profile', [
            'user' => Auth::user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        try {
            $user->update($validated);
            
            return redirect()->back()
                ->with('success', 'Perfil atualizado com sucesso!');
                
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar perfil: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao atualizar perfil. Tente novamente.');
        }
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'A senha atual está incorreta.']);
        }

        try {
            $user->update([
                'password' => Hash::make($validated['password'])
            ]);
            
            return redirect()->back()
                ->with('success', 'Senha atualizada com sucesso!');
                
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar senha: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao atualizar senha. Tente novamente.');
        }
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['delete_current_password' => 'Senha incorreta.']);
        }

        Auth::logout();

        // Remover relações antes da exclusão
        Contact::where('created_by', $user->id)->update(['created_by' => null]);
        Contact::where('updated_by', $user->id)->update(['updated_by' => null]);

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Conta excluída com sucesso.');
    }
}