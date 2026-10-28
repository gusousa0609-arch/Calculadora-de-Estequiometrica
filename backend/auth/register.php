<?php
/**
 * Backend de Autenticação - Registro de Usuários
 * Regra: "o mesmo email não pode ter mais de uma conta"
 * Regra: "Tratar senhas de usuários com hash bcrypt"
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

$nome = trim($_POST['nome'] ?? '');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$senha = $_POST['senha'] ?? '';
$confirmSenha = $_POST['confirmar_senha'] ?? '';

// Validações básicas
if (empty($nome) || mb_strlen($nome) < 3) {
    echo json_encode(['success' => false, 'message' => 'Por favor, informe seu nome completo (mínimo 3 caracteres).']);
    exit;
}

if (!$email) {
    echo json_encode(['success' => false, 'message' => 'Por favor, forneça um endereço de e-mail válido.']);
    exit;
}

if (strlen($senha) < 6) {
    echo json_encode(['success' => false, 'message' => 'A senha deve conter no mínimo 6 caracteres para sua segurança.']);
    exit;
}

if ($senha !== $confirmSenha) {
    echo json_encode(['success' => false, 'message' => 'A confirmação de senha não coincide com a senha digitada.']);
    exit;
}

$pdo = getDbConnection();

if (!$pdo) {
    echo json_encode(['success' => false, 'message' => 'Não foi possível conectar ao banco de dados no momento.']);
    exit;
}

try {
    // 1. Verifica se já existe conta com este e-mail (Regra: e-mail único)
    $stmtCheck = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email LIMIT 1");
    $stmtCheck->execute([':email' => $email]);
    if ($stmtCheck->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Já existe uma conta cadastrada com este e-mail. Utilize outro ou faça login.']);
        exit;
    }

    // 2. Hash da senha com Bcrypt nativo
    $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

    // 3. Insere o novo usuário via Prepared Statement
    $stmtInsert = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, criado_em) VALUES (:nome, :email, :senha, NOW())");
    $stmtInsert->execute([
        ':nome' => $nome,
        ':email' => $email,
        ':senha' => $senhaHash
    ]);

    $novoId = (int)$pdo->lastInsertId();

    // 4. Inicia a sessão nativa do usuário
    $_SESSION['user_id'] = $novoId;
    $_SESSION['user_nome'] = $nome;
    $_SESSION['user_email'] = $email;

    // 5. Registra log de auditoria
    registrarAuditoria($pdo, 'CADASTRO', "Novo usuário registrado com o e-mail: {$email}", $novoId);

    echo json_encode([
        'success' => true,
        'message' => 'Conta criada com sucesso! Você já está conectado.',
        'redirect' => 'index.php'
    ]);
    exit;

} catch (PDOException $e) {
    error_log("Erro no cadastro: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erro ao salvar novo cadastro no banco de dados.']);
    exit;
}
