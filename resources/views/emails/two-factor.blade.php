<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de Email - Cadastro</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
            color: #374151;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }
        .card {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .title {
            font-size: 20px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 20px;
            text-align: center;
        }
        .welcome-message {
            background: #ecfdf5;
            border: 1px solid #10b981;
            color: #065f46;
            padding: 15px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
        }
        .code-container {
            background: #f3f4f6;
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .code {
            font-size: 32px;
            font-weight: bold;
            color: #2563eb;
            letter-spacing: 4px;
            font-family: 'Courier New', monospace;
        }
        .instructions {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .steps {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }
        .step {
            margin-bottom: 8px;
            font-size: 14px;
        }
        .warning {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            color: #92400e;
            padding: 15px;
            border-radius: 6px;
            font-size: 14px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            color: #9ca3af;
            font-size: 12px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Contact Manager</div>
            <p>Verificação de Email para Cadastro</p>
        </div>
        
        <div class="card">
            <h2 class="title">Confirme seu Email para Finalizar o Cadastro</h2>
            
            <div class="welcome-message">
                <strong>🎉 Bem-vindo(a) ao Contact Manager!</strong><br>
                Você está a um passo de completar seu cadastro.
            </div>
            
            <p class="instructions">
                Para <strong>finalizar seu cadastro</strong> e ativar sua conta no sistema, 
                confirme que este é realmente seu email usando o código abaixo:
            </p>
            
            <div class="code-container">
                <div class="code">{{ $code }}</div>
            </div>
            
            <div class="steps">
                <div class="step"><strong>1.</strong> Copie o código acima</div>
                <div class="step"><strong>2.</strong> Cole na tela de verificação</div>
                <div class="step"><strong>3.</strong> Sua conta será criada automaticamente</div>
                <div class="step"><strong>4.</strong> Você será redirecionado para o sistema</div>
            </div>
            
            <p class="instructions">
                <strong>Informações importantes:</strong><br>
                • Este código é válido por <strong>15 minutos</strong><br>
                • Seu cadastro só será finalizado após a verificação<br>
                • Sem a confirmação, sua conta não será criada<br>
                • Não compartilhe este código com ninguém
            </p>
            
            <div class="warning">
                <strong>⚠️ Importante:</strong> Se você não tentou se cadastrar no Contact Manager, 
                ignore este email. Nenhuma conta será criada sem a confirmação do código.
            </div>
        </div>
        
        <div class="footer">
            <p>Este é um email automático. Por favor, não responda.</p>
            <p>Contact Manager - Sistema de Contatos - {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>