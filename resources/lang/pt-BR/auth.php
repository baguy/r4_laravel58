<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Authentication Language Lines
  |--------------------------------------------------------------------------
  |
  | The following language lines are used during authentication for various
  | messages that we need to display to the user. You are free to modify
  | these language lines according to your application's requirements.
  |
  */

  'failed'   => 'Credenciais informadas não correspondem com nossos registros.',
  'throttle' => 'Você realizou muitas tentativas de login. Por favor, tente novamente em :seconds segundos.',

  'lbl.forgot-my-password' => 'Esqueci minha senha',
  'lbl.remember'           => 'Permanecer Conectado',
  'lbl.new-user'           => 'Cadastrar novo usuário',

  'mail.remind.subject.password-reset' => 'Redefinição de Senha',
  'mail.remind.msg.password-reset'     => 'Para alterar sua senha preencha este formulário: :link',
  'mail.remind.msg.expire-in'          => 'Este link expira em :expire minutos',

  'msg.error.invalid-user'   => 'E-mail e/ou senha inválidos!',
  'msg.error.user-suspended' => 'Usuário suspenso :minutes minutos por excesso de tentativas!',

  'page.login.info.text'  => 'Efetuar login para iniciar sessão',
  'page.remind.info.text' => 'Informe o email para recuperar sua senha',
  'page.reset.info.text'  => 'Informe os dados para alterar sua senha',

  'page.title.login'  => 'Login',
  'page.title.remind' => 'Restaurar Senha',
  'page.title.reset'  => 'Resetar Senha',

  'log.password.remind' => 'Solicitou resete da senha do usuário com email: :email',
  'log.password.reset'  => 'Resetou senha do usuário com ID: :id e email: :email',
];
