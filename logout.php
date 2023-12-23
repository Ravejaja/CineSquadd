<?php
// Inicialize a sessão
session_start();

// Destrua todas as variáveis de sessão
session_unset();

// Encerre a sessão
session_destroy();

// Redirecione o usuário para a página de login ou outra página de destino
header("Location: index.php");
exit();
?>