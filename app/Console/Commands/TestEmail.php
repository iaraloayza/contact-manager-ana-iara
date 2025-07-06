<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature = 'test:email {email}';
    protected $description = 'Testar envio de email';

    public function handle()
    {
        $email = $this->argument('email');
        $code = '123456';
        
        try {
            Mail::send('emails.two-factor', ['code' => $code], function ($message) use ($email) {
                $message->to($email)
                    ->subject('Teste - Código de Verificação')
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            $this->info('Email enviado com sucesso!');
            
        } catch (\Exception $e) {
            $this->error('Erro ao enviar email: ' . $e->getMessage());
        }
    }
}