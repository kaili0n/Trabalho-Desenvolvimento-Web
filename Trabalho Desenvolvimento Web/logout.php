<?php
// Iniciar a sessão
session_start();

// Limpar todos os dados da sessão
$_SESSION = array();

// Destruir a sessão
session_destroy();

// Redirecione o usuário para a página de login ou qualquer outra página desejada
header("Location: index.php");
exit();