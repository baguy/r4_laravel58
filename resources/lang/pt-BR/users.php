<?php

return array(

  //--------------------------------------------------------------------------
  // User Repositiory Messages
  //--------------------------------------------------------------------------

  'user'     => 'Usuário',
  'users'    => 'Usuários',
  'user(s)'  => 'Usuário(s)',

  'unidade'  => 'Unidade',

  'page.title.create'          => 'Adicionar Usuário',
  'page.title.edit'            => 'Editar Usuário',
  'page.title.index'           => 'Lista de Usuários',
  'page.title.show'            => 'Perfil',
  'page.title.change-password' => 'Alterar Senha',
  'page.title.avatar'          => 'Adicionar imagem para avatar',

  'help.actual.password' => 'Senha atual do usuário logado no sistema',
  'help.password'        => 'Preencha somente se deseja alterar a senha',

  'help.reset.password'  => "Senha padrão é redefinida para 'password1!' ",

  'help.roles.ol_li-1'   => 'Os níveis são hierárquicos e automaticamente encadeados;',
  'help.roles.ol_li-2'   => 'A opção selecionada será propagada para as posteriores;',
  'help.roles.ol_li-3'   => 'As seleções propagadas ficarão bloqueadas para interação (Remoção da Seleção);',
  'help.roles.ol_li-4'   => 'Restando somente a opção originalmente clicada e as demais eventualmente acima desbloqueada(s) para interação (Seleção / Remoção da Seleção).',

  //'btn.ban'   => 'Banir',
  //'btn.unban' => 'Remover Banimento',

  'btn.suspend'   => 'Suspender',
  'btn.unsuspend' => 'Remover Suspensão',

  //'lbl.banned'     => 'Banido',
  'lbl.suspended'    => 'Suspenso',
  'lbl.suspended-at' => 'Data da Suspensão',
  'lbl.last-access'  => 'Último Acesso',
  'lbl.attempts'     => 'Tentativa(s)',
  'lbl.last-attempt' => 'Última Tentativa',
  'lbl.resetar'      => 'Redefinir senha do usuário',

  //'msg.banned'                        => 'Usuário Banido',
  'msg.suspended'                       => 'Usuário suspenso por :minutes minutos',
  'msg.suspension-time-ended'           => 'Tempo de suspensão terminado',
  'msg.not-suspended'                   => 'Usuário não suspenso no momento',
  'msg.last-access'                     => 'Acessou o sistema pela última vez em :datetime',
  'msg.no-access'                       => 'Usuário nunca acessou o sistema',
  'msg.no-last-attempt'                 => 'Sem registro da última tentativa',
  'msg.attempts'                        => 'Total de :attempts tentativa(s) sem êxito',
  'msg.last-attempt'                    => 'Última tentativa de acesso em :datetime',
  'msg.is-default-password'             => 'Sua senha precisa ser alterada!',
  'msg.password-redefined-successfully' => 'Senha do usuário redefinida (Senha Padrão) com sucesso!',

  'lbl.name'                      => 'Nome',
  'lbl.email'                     => 'Email',
  'lbl.password'                  => 'Senha',
  'lbl.password-confirmation'     => 'Confirmar Senha',
  'lbl.actual-password'           => 'Senha Atual',
  'lbl.roles'                     => 'Nível(is)',
  'lbl.new-password'              => 'Nova Senha',
  'lbl.new-password-confirmation' => 'Confirmar Nova Senha',
  'lbl.responsavel'               => 'Responsável por aprovar resultados',
  'lbl.nickname'                  => 'Apelido',

  'plh.name'                      => 'Nome que aparecerá no sistema',
  'plh.email'                     => 'Email do Usuário',
  'plh.password'                  => 'Senha de Acesso',
  'plh.password-confirmation'     => 'Confirmar Senha',
  'plh.actual-password'           => 'Informe a Senha Atual',
  'plh.roles'                     => 'Nível(is)',
  'plh.new-password'              => 'Nova Senha',
  'plh.new-password-confirmation' => 'Confirmar Nova Senha',
  'plh.nickname'                  => 'Apelido',

  'filter.plh.name-&-email'                => 'Procurar por nome ou email',
  'filter.attempts.opt.successful'         => 'Com Êxito',
  'filter.attempts.opt.unsuccessful'       => 'Sem Êxito',
  'filter.is_default_password.opt.default' => 'Padrão',
  'filter.is_default_password.opt.changed' => 'Alterada',

  'tab.activity' => 'Atividades',
  'tab.logs'     => 'Últimos Logs',

  'ask.default-password-has-been-changed' => 'Senha padrão foi alterada?',

  'log.password.change'    => 'Modificou senha do usuário com ID: :id e email: :email',
  'log.password.redefined' => 'Redefiniu senha do usuário com ID: :id e email: :email',
  'log.edit.roles'         => 'Alterou o nível de acesso do usuário com ID: :id e email: :email de: :original para: :value',
);
