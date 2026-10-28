<?php
$pageTitle = "Histórico de Cálculos";
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/bd.php';
require_once __DIR__ . '/../includes/header.php';

$isLoggedIn = isUserLoggedIn();
$historico = [];

if ($isLoggedIn) {
    $pdo = getDbConnection();
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT id, tipo_calculo, entrada_formula, parametros_entrada, resultado_resumo, resultado_completo, criado_em 
                                   FROM historico_calculos 
                                   WHERE usuario_id = :uid 
                                   ORDER BY criado_em DESC");
            $stmt->execute([':uid' => (int)$_SESSION['user_id']]);
            $historico = $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erro ao carregar histórico: " . $e->getMessage());
        }
    }
}
?>

<main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <!-- Cabeçalho -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white flex items-center">
                <i class="fas fa-history text-sky-600 mr-3"></i> Histórico de Cálculos Químicos
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Acompanhe todas as reações e cálculos realizados em sua conta para estudos e auditorias.
            </p>
        </div>

        <?php if ($isLoggedIn && count($historico) > 0): ?>
            <div>
                <button type="button" id="btn-clear-all-history" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-rose-600 hover:text-white hover:bg-rose-600 border border-rose-300 dark:border-rose-700 rounded-xl transition shadow-sm flex items-center space-x-1.5">
                    <i class="fas fa-trash-alt"></i>
                    <span>Limpar Todo o Histórico</span>
                </button>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!$isLoggedIn): ?>
        <!-- Alerta para Usuários Não Autenticados (Regra dos Requisitos) -->
        <div class="bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800/80 rounded-3xl p-6 sm:p-8 text-center max-w-2xl mx-auto shadow-md my-8">
            <div class="w-14 h-14 rounded-2xl bg-amber-100 dark:bg-amber-900/50 text-amber-600 dark:text-amber-400 flex items-center justify-center text-2xl mx-auto mb-4">
                <i class="fas fa-lock"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Histórico Permanente Bloqueado</h2>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed mb-6">
                Conforme as regras do sistema, você pode realizar todos os cálculos livremente sem cadastro. Porém, para armazenar e consultar seu <strong>histórico perpétuo</strong> no banco de dados e manter registros de auditoria, é necessário estar conectado.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="login.php" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm shadow-md transition">
                    <i class="fas fa-sign-in-alt mr-1.5"></i> Fazer Login
                </a>
                <a href="registro.php" class="w-full sm:w-auto px-6 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-700 font-semibold text-sm text-slate-700 dark:text-slate-200 transition">
                    Criar Conta Gratuita
                </a>
            </div>
        </div>

        <!-- Exibição de Histórico Local Temporário se houver -->
        <div id="local-history-section" class="hidden mt-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400">Cálculos Desta Sessão Local (Navegador)</h3>
                <button type="button" id="btn-clear-local" class="text-xs text-rose-500 hover:underline">Limpar Sessão</button>
            </div>
            <div id="local-history-container" class="space-y-3">
                <!-- Preenchido via JavaScript -->
            </div>
        </div>

    <?php elseif (empty($historico)): ?>
        <!-- Usuário Conectado mas sem cálculos ainda -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-10 text-center border border-slate-200 dark:border-slate-700 shadow-sm max-w-lg mx-auto">
            <div class="w-16 h-16 rounded-2xl bg-sky-50 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 flex items-center justify-center text-3xl mx-auto mb-4">
                <i class="fas fa-calculator"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">Nenhum cálculo registrado ainda</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">Você ainda não realizou cálculos logado. Suas futuras consultas aparecerão listadas aqui!</p>
            <a href="index.php" class="inline-flex items-center px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm shadow-md transition">
                <i class="fas fa-play mr-2 text-xs"></i> Começar a Calcular
            </a>
        </div>

    <?php else: ?>
        <!-- Lista de Histórico do Usuário -->
        <div class="space-y-4">
            <?php foreach ($historico as $item): 
                $tipoLabels = [
                    'estequiometria' => ['label' => 'Estequiometria', 'bg' => 'bg-sky-100 text-sky-800 dark:bg-sky-900/50 dark:text-sky-300'],
                    'massa_nox' => ['label' => 'Massa Molar & Nox', 'bg' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300'],
                    'titulacao' => ['label' => 'Titulação', 'bg' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300'],
                    'concentracao' => ['label' => 'Concentração', 'bg' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300'],
                ];
                $badge = $tipoLabels[$item['tipo_calculo']] ?? ['label' => ucfirst($item['tipo_calculo']), 'bg' => 'bg-slate-100 text-slate-800'];
            ?>
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-700/80 shadow-sm hover:shadow-md transition flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1.5 flex-1">
                        <div class="flex items-center space-x-2">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold <?= $badge['bg'] ?>">
                                <?= $badge['label'] ?>
                            </span>
                            <span class="text-xs text-slate-400 flex items-center">
                                <i class="far fa-clock mr-1"></i>
                                <?= date('d/m/Y H:i', strtotime($item['criado_em'])) ?>
                            </span>
                        </div>
                        <h3 class="text-base font-bold font-mono text-slate-900 dark:text-white">
                            <?= htmlspecialchars($item['entrada_formula']) ?>
                        </h3>
                        <p class="text-xs font-mono text-slate-600 dark:text-slate-300 line-clamp-2">
                            <?= nl2br(htmlspecialchars($item['resultado_resumo'])) ?>
                        </p>
                    </div>

                    <div class="flex items-center space-x-2 pt-2 md:pt-0 border-t md:border-t-0 border-slate-100 dark:border-slate-700">
                        <button type="button" class="btn-delete-item px-3 py-1.5 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition" data-id="<?= (int)$item['id'] ?>" title="Excluir do Histórico">
                            <i class="fas fa-trash mr-1"></i> Excluir
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</main>

<script>
document.addEventListener("DOMContentLoaded", () => {
    // 1. Carrega histórico local se usuário não estiver logado
    const localSection = document.getElementById("local-history-section");
    const localContainer = document.getElementById("local-history-container");
    const btnClearLocal = document.getElementById("btn-clear-local");

    if (localSection && localContainer) {
        const localHist = JSON.parse(localStorage.getItem("local_history") || "[]");
        if (localHist.length > 0) {
            localSection.classList.remove("hidden");
            localContainer.innerHTML = "";
            localHist.forEach((item, idx) => {
                const card = document.createElement("div");
                card.className = "bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 text-xs";
                card.innerHTML = `
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-bold text-sky-600 uppercase text-[10px]">${item.tipo}</span>
                        <span class="text-slate-400">${item.data}</span>
                    </div>
                    <div class="font-mono font-bold text-slate-800 dark:text-white mb-1">${item.entrada}</div>
                    <div class="text-slate-500 dark:text-slate-400 font-mono">${item.resumo}</div>
                `;
                localContainer.appendChild(card);
            });
        }

        if (btnClearLocal) {
            btnClearLocal.addEventListener("click", () => {
                customConfirm("Deseja realmente limpar os cálculos da sessão local?", () => {
                    localStorage.removeItem("local_history");
                    localSection.classList.add("hidden");
                    showToast("info", "Sessão Limpa", "Os cálculos locais foram removidos.");
                });
            });
        }
    }

    // 2. Exclusão individual de item do histórico do banco
    const deleteBtns = document.querySelectorAll(".btn-delete-item");
    deleteBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            const id = btn.getAttribute("data-id");
            customConfirm("Tem certeza de que deseja excluir este cálculo do seu histórico permanente?", () => {
                const formData = new FormData();
                formData.append("action", "delete_item");
                formData.append("item_id", id);

                fetch("../backend/historico_actions.php", {
                    method: "POST",
                    body: formData
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        showToast("success", "Excluído", res.message);
                        setTimeout(() => location.reload(), 800);
                    } else {
                        showToast("error", "Erro", res.message);
                    }
                })
                .catch(err => {
                    showToast("error", "Falha de Conexão", "Não foi possível contatar o servidor.");
                });
            });
        });
    });

    // 3. Limpeza total do histórico
    const btnClearAll = document.getElementById("btn-clear-all-history");
    if (btnClearAll) {
        btnClearAll.addEventListener("click", () => {
            customConfirm("Atenção! Esta ação excluirá permanentemente TODO o seu histórico de cálculos estequiométricos. Deseja prosseguir?", () => {
                const formData = new FormData();
                formData.append("action", "clear_all");

                fetch("../backend/historico_actions.php", {
                    method: "POST",
                    body: formData
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        showToast("success", "Histórico Limpo", res.message);
                        setTimeout(() => location.reload(), 800);
                    } else {
                        showToast("error", "Erro", res.message);
                    }
                })
                .catch(err => {
                    showToast("error", "Falha de Conexão", "Não foi possível contatar o servidor.");
                });
            }, "Confirmar Exclusão Total");
        });
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
