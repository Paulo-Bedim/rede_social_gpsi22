<?php // header.php
session_start();

echo <<<_INIT
<!DOCTYPE html> 
<html>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'> 
    <link rel='stylesheet' href='jquery.mobile-1.4.5.min.css'>
    <link rel='stylesheet' href='base.css' type='text/css'>
    <link rel='stylesheet' href='header.css' type='text/css'>
    <link rel='stylesheet' href='styles.css' type='text/css'>
    <script src='javascript.js'></script>
    <script src='jquery-2.2.4.min.js'></script>
    <script src='jquery.mobile-1.4.5.min.js'></script>
_INIT;

require_once 'funcoes.php';
$userstr = 'Bem-vindo';
if (isset($_SESSION['utilizador'])) {
    $utilizador = $_SESSION['utilizador'];
    $loggedin = TRUE;
    $userstr = "Ativo como: $utilizador";
} else {
    $loggedin = FALSE;
}

echo <<<_MAIN
    <title>gpsi22: $userstr</title>
  </head>
  <body>
    <div data-role='page' class='page-container'>
      <div data-role='header' class='header'>
        <div class='header-container'>
          <div id='logo' class='logo'><img id='gpsi22' src='gpsi22.gif' alt='GPSI22 Logo'>GPSI22</div>
          <div class='user-info'>$userstr</div>
          <button id='dark-mode-toggle' class='dark-mode-btn' onclick='toggleDarkMode()'>
            <span class='icon'>☀️</span> Modo Escuro
          </button>
        </div>
        <nav class='nav-menu'>
_MAIN;

if ($loggedin) {
    echo <<<_REGISTADO
          <div class='nav-links'>
            <a data-role='button' data-inline='true' data-icon='home' data-transition="slide" href='index.php?view=$utilizador'>Home</a>
            <a data-role='button' data-inline='true' data-icon='user' data-transition="slide" href='membros.php'>Membros</a>
            <a data-role='button' data-inline='true' data-icon='heart' data-transition="slide" href='amigos.php'>Amigos</a>
            <a data-role='button' data-inline='true' data-icon='mail' data-transition="slide" href='mensagens.php'>Mensagens</a>
            <a data-role='button' data-inline='true' data-icon='grid' data-transition="slide" href='feed.php'>Feed</a>
            <a data-role='button' data-inline='true' data-icon='edit' data-transition="slide" href='perfil.php'>Editar Perfil</a>
            <a data-role='button' data-inline='true' data-icon='action' data-transition="slide" href='logout.php'>Sair</a>
          </div>
_REGISTADO;
} else {
    echo <<<_VISITA
          <div class='nav-links'>
            <a data-role='button' data-inline='true' data-icon='home' data-transition="slide" href='index.php'>Home</a>
            <a data-role='button' data-inline='true' data-icon='plus' data-transition="slide" href='signup.php'>Registar</a>
            <a data-role='button' data-inline='true' data-icon='check' data-transition="slide" href='login.php'>Entrar</a>
          </div>
          <p class='info'>(Tem de estar registado para entrar no site.)</p>
_VISITA;
}

echo <<<_END
        </nav>
      </div>
      <div data-role='content' class='main-content'>
_END;
?>