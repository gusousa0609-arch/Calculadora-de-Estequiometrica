<?php
/**
 * Backend de Autenticação - Login
 * Validação segura de credenciais com PDO e password_verify (Bcrypt)
 * Registro de logs de auditoria
 */

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/bd.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
    exit;
}

$email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$senha = $_POST['senha'] ?? '';

if (!$email || empty($senha)) {
    echo json_encode(['success' => false, 'message' => 'Por favor, informe um e-mail válido e a senha.']);
    exit;
}

$pdo = getDbConnection();

if (!$pdo) {
    echo json_encode(['success' => false, 'message' => 'Não foi possível conectar ao banco de dados no momento.']);
    exit;
}

try {
    // Busca usuário pelo e-mail (Prepared Statement seguro contra SQL Injection)
    $stmt = $pdo->prepare("SELECT id, nome, email, senha FROM usuarios WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($senha, $user['senha'])) {
        // Autenticação bem-sucedida: inicia sessão nativa
        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['user_nome'] = $user['nome'];
        $_SESSION['user_email'] = $user['email'];

        // Registra log de auditoria
        registrarAuditoria($pdo, 'LOGIN_SUCESSO', "Login efetuado por {$user['email']}", (int)$user['id']);

        echo json_encode([
            'success' => true,
            'message' => 'Login realizado com sucesso! Bem-vindo(a), ' . htmlspecialchars($user['nome']) . '.',
            'redirect' => 'index.php'
        ]);
        exit;
    } else {
        // Falha de credenciais: registra log de auditoria de tentativa inválida
        registrarAuditoria($pdo, 'LOGIN_FALHA', "Tentativa de login inválida para o e-mail: {$email}", null);

        echo json_encode([
            'success' => false,
            'message' => 'E-mail ou senha incorretos. Por favor, tente novamente.'
        ]);
        exit;
    }
} catch (PDOException $e) {
    error_log("Erro no login: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Ocorreu um erro no servidor ao processar o login.']);
    exit;
}
