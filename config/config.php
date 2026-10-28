<?php
/**
 * Configuração Geral da Aplicação
 * Calculadora Estequiométrica
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configurações do Banco de Dados MySQL
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'calculadora_estequiometrica');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

// Configurações da Aplicação
define('APP_NAME', 'Calculadora Estequiométrica');
define('APP_VERSION', '1.0.0');

// Fuso horário
date_default_timezone_set('America/Sao_Paulo');

/**
 * Verifica se há um usuário autenticado na sessão
 * @return bool
 */
function isUserLoggedIn(): bool {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Retorna os dados do usuário autenticado na sessão
 * @return array|null
 */
function getLoggedUserData(): ?array {
    if (!isUserLoggedIn()) {
        return null;
    }
    return [
        'id' => $_SESSION['user_id'],
        'nome' => $_SESSION['user_nome'] ?? 'Usuário',
        'email' => $_SESSION['user_email'] ?? ''
    ];
}

/**
 * Registra um log de auditoria no banco de dados
 * @param PDO $pdo
 * @param string $acao
 * @param string|null $detalhes
 * @param int|null $usuarioId
 * @return bool
 */
function registrarAuditoria(PDO $pdo, string $acao, ?string $detalhes = null, ?int $usuarioId = null): bool {
    try {
        if ($usuarioId === null && isUserLoggedIn()) {
            $usuarioId = (int)$_SESSION['user_id'];
        }
        
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $userAgent = substr($_SERVER['HTTP_USER_AGENT'] ?? 'Desconhecido', 0, 250);
        
        $sql = "INSERT INTO logs_auditoria (usuario_id, acao, detalhes, ip_address, user_agent, criado_em) 
                VALUES (:usuario_id, :acao, :detalhes, :ip_address, :user_agent, NOW())";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':usuario_id' => $usuarioId,
            ':acao' => $acao,
            ':detalhes' => $detalhes,
            ':ip_address' => $ip,
            ':user_agent' => $userAgent
        ]);
    } catch (Exception $e) {
        // Falha no log não deve interromper o fluxo principal
        error_log("Erro ao registrar auditoria: " . $e->getMessage());
        return false;
    }
}

/**
 * Sanitiza texto contra XSS
 * @param string $data
 * @return string
 */
function sanitize(string $data): string {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
