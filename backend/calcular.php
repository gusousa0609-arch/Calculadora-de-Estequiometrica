<?php
/**
 * Backend - Salvar Cálculos e Auditoria
 * Recebe o cálculo realizado na calculadora e, se o usuário estiver logado,
 * armazena no histórico do MySQL e registra o log de auditoria.
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/bd.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método inválido.']);
    exit;
}

// Suporta leitura via php://input (JSON) ou $_POST tradicional
$inputRaw = file_get_contents('php://input');
$data = json_decode($inputRaw, true);

if (!$data) {
    $data = $_POST;
}

$tipoCalculo = sanitize($data['tipo_calculo'] ?? 'estequiometria');
$entradaFormula = trim($data['entrada_formula'] ?? '');
$parametrosEntrada = isset($data['parametros_entrada']) ? json_encode($data['parametros_entrada'], JSON_UNESCAPED_UNICODE) : null;
$resultadoResumo = trim($data['resultado_resumo'] ?? '');
$resultadoCompleto = isset($data['resultado_completo']) ? json_encode($data['resultado_completo'], JSON_UNESCAPED_UNICODE) : null;

if (empty($entradaFormula) || empty($resultadoResumo)) {
    echo json_encode(['success' => false, 'message' => 'Dados de cálculo incompletos.']);
    exit;
}

$isLoggedIn = isUserLoggedIn();
$userId = $isLoggedIn ? (int)$_SESSION['user_id'] : null;

$pdo = getDbConnection();

// Se o usuário estiver autenticado e houver banco disponível, salva no histórico
if ($isLoggedIn && $pdo) {
    try {
        $stmt = $pdo->prepare("INSERT INTO historico_calculos 
            (usuario_id, tipo_calculo, entrada_formula, parametros_entrada, resultado_resumo, resultado_completo, criado_em)
            VALUES (:usuario_id, :tipo, :entrada, :params, :resumo, :completo, NOW())");
        
        $stmt->execute([
            ':usuario_id' => $userId,
            ':tipo' => $tipoCalculo,
            ':entrada' => $entradaFormula,
            ':params' => $parametrosEntrada,
            ':resumo' => $resultadoResumo,
            ':completo' => $resultadoCompleto
        ]);

        $historicoId = (int)$pdo->lastInsertId();

        // Registra log de auditoria
        registrarAuditoria($pdo, 'CALCULO_REALIZADO', "Cálculo do tipo '{$tipoCalculo}' para a fórmula '{$entradaFormula}'", $userId);

        echo json_encode([
            'success' => true,
            'message' => 'Cálculo salvo no seu histórico com sucesso!',
            'historico_id' => $historicoId,
            'logged' => true
        ]);
        exit;
    } catch (PDOException $e) {
        error_log("Erro ao salvar histórico: " . $e->getMessage());
        echo json_encode([
            'success' => true,
            'message' => 'Cálculo executado, porém houve falha ao gravar no histórico.',
            'logged' => true
        ]);
        exit;
    }
} else {
    // Usuário não cadastrado: cálculo livre, mas avisa que pode salvar se logar
    echo json_encode([
        'success' => true,
        'message' => 'Cálculo realizado com sucesso. Dica: Cadastre-se ou entre para salvar em seu histórico!',
        'logged' => false
    ]);
    exit;
}
