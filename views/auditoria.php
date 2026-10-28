<?php
$pageTitle = "Logs de Auditoria do Sistema";
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/bd.php';
require_once __DIR__ . '/../includes/header.php';

$pdo = getDbConnection();
$logs = [];

if ($pdo) {
    try {
        $sql = "SELECT l.id, l.usuario_id, l.acao, l.detalhes, l.ip_address, l.user_agent, l.criado_em,
                       u.nome AS usuario_nome, u.email AS usuario_email
                FROM logs_auditoria l
                LEFT JOIN usuarios u ON l.usuario_id = u.id
                ORDER BY l.criado_em DESC
                LIMIT 150";
        $stmt = $pdo->query($sql);
        $logs = $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Erro ao carregar auditoria: " . $e->getMessage());
    }
}
?>

<main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <!-- Cabeçalho -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300">
                    <i class="fas fa-shield-alt mr-1"></i> Rastreabilidade & Segurança
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white mt-1">
                Auditoria & Logs do Sistema
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                Registro imutável de todas as ações de autenticação, cálculos e modificações realizadas por usuários.
            </p>
        </div>

        <div class="text-xs text-slate-500 bg-white dark:bg-slate-800 p-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 flex items-center space-x-2">
            <i class="fas fa-database text-sky-600"></i>
            <span>Exibindo os últimos <strong><?= count($logs) ?></strong> eventos registrados</span>
        </div>
    </div>

    <!-- Tabela de Logs de Auditoria -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200/80 dark:border-slate-700/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 text-slate-400 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-4">Data / Hora</th>
                        <th class="py-3.5 px-4">Ação</th>
                        <th class="py-3.5 px-4">Usuário</th>
                        <th class="py-3.5 px-4">Detalhes do Evento</th>
                        <th class="py-3.5 px-4">Endereço IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60">
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-400">
                                <i class="fas fa-inbox text-3xl mb-2 block opacity-50"></i>
                                Nenhum evento de auditoria registrado no banco de dados até o momento.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): 
                            $badgeClass = "bg-slate-100 text-slate-800";
                            $icon = "fa-circle";

                            switch ($log['acao']) {
                                case 'LOGIN_SUCESSO':
                                    $badgeClass = "bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300";
                                    $icon = "fa-sign-in-alt";
                                    break;
                                case 'LOGIN_FALHA':
                                    $badgeClass = "bg-rose-100 text-rose-800 dark:bg-rose-900/50 dark:text-rose-300";
                                    $icon = "fa-exclamation-circle";
                                    break;
                                case 'CADASTRO':
                                    $badgeClass = "bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300";
                                    $icon = "fa-user-plus";
                                    break;
                                case 'CALCULO_REALIZADO':
                                    $badgeClass = "bg-sky-100 text-sky-800 dark:bg-sky-900/50 dark:text-sky-300";
                                    $icon = "fa-calculator";
                                    break;
                                case 'LOGOUT':
                                    $badgeClass = "bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300";
                                    $icon = "fa-sign-out-alt";
                                    break;
                                case 'EXCLUSAO_HISTORICO':
                                case 'LIMPEZA_HISTORICO':
                                    $badgeClass = "bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300";
                                    $icon = "fa-trash";
                                    break;
                            }
                        ?>
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/30 transition">
                                <td class="py-3 px-4 font-mono text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap">
                                    <?= date('d/m/Y H:i:s', strtotime($log['criado_em'])) ?>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold <?= $badgeClass ?>">
                                        <i class="fas <?= $icon ?> mr-1 text-[10px]"></i>
                                        <?= htmlspecialchars($log['acao']) ?>
                                    </span>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <?php if ($log['usuario_id']): ?>
                                        <div class="font-semibold text-slate-800 dark:text-white">
                                            <?= htmlspecialchars($log['usuario_nome'] ?? 'Usuário') ?>
                                        </div>
                                        <div class="text-[11px] text-slate-400">
                                            <?= htmlspecialchars($log['usuario_email'] ?? '') ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-xs text-slate-400 italic">Anônimo / Visitante</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-xs font-mono text-slate-700 dark:text-slate-300 max-w-xs sm:max-w-md truncate" title="<?= htmlspecialchars($log['detalhes'] ?? '') ?>">
                                    <?= htmlspecialchars($log['detalhes'] ?? 'Sem detalhes adicionais') ?>
                                </td>
                                <td class="py-3 px-4 font-mono text-xs text-slate-500 whitespace-nowrap">
                                    <?= htmlspecialchars($log['ip_address'] ?? '-') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
