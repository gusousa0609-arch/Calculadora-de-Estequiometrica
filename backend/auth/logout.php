<?php
/**
 * Backend de Autenticação - Logout
 * Encerra a sessão nativa e gera log de auditoria
 */

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/bd.php';

if (isUserLoggedIn()) {
    $pdo = getDbConnection();
    if ($pdo) {
        registrarAuditoria($pdo, 'LOGOUT', "Usuário encerrou a sessão", (int)$_SESSION['user_id']);
    }
}

// Limpa e destrói os dados da sessão
$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

// Redireciona para a página inicial ou de login
header('Location: ../../views/login.php?logout=1');
exit;
