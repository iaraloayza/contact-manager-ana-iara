<p>Você solicitou a redefinição de senha.</p>

<p>Clique no link abaixo para criar uma nova senha:</p>

<p>
  <a href="{{ url('/reset-password/' . $token . '?email=' . urlencode($email)) }}">
    Redefinir Senha
  </a>
</p>

<p>Se você não solicitou, ignore este email.</p>