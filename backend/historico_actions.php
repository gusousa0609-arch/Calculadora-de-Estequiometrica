<?php
/**
 * Backend - Ações no Histórico do Usuário
 * Exclusão individual ou total do histórico com auditoria
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/bd.php';

header('Content-Type: application/json; charset=utf-8');

if (!isUserLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Você precisa estar logado para gerenciar seu histórico.']);
    exit;
}

$pdo = getDbConnection();
if (!$pdo) {
    echo json_encode(['success' => false, 'message' => 'Erro de conexão com o banco de dados.']);
    exit;
}

$userId = (int)$_SESSION['user_id'];
$action = $_POST['action'] ?? '';

try {
    if ($action === 'delete_item') {
        $itemId = (int)($_POST['item_id'] ?? 0);
        if ($itemId <= 0) {
            echo json_encode(['success' => false, 'message' => 'Item inválido.']);
            exit;
        }

        $stmt = $pdo->prepare("DELETE FROM historico_calculos WHERE id = :id AND usuario_id = :usuario_id");
        $stmt->execute([':id' => $itemId, ':usuario_id' => $userId]);

        registrarAuditoria($pdo, 'EXCLUSAO_HISTORICO', "Excluiu o cálculo de ID #{$itemId}", $userId);

        echo json_encode(['success' => true, 'message' => 'Item removido do histórico com sucesso.']);
        exit;

    } elseif ($action === 'clear_all') {
        $stmt = $pdo->prepare("DELETE FROM historico_calculos WHERE usuario_id = :usuario_id");
        $stmt->execute([':usuario_id' => $userId]);

        registrarAuditoria($pdo, 'LIMPEZA_HISTORICO', "Limpou todo o histórico de cálculos", $userId);

        echo json_encode(['success' => true, 'message' => 'Todo o histórico de cálculos foi limpo com sucesso.']);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Ação não reconhecida.']);
        exit;
    }
} catch (PDOException $e) {
    error_log("Erro em historico_actions: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erro interno ao processar ação no histórico.']);
    exit;
}
