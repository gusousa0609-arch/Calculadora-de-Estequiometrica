<?php
$pageTitle = "Calculadora Estequiométrica";
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/header.php';
?>

<main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">

    <!-- Hero / Apresentação -->
    <div class="mb-8 text-center max-w-3xl mx-auto">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-sky-100 text-sky-800 dark:bg-sky-900/60 dark:text-sky-300 mb-3">
            <i class="fas fa-flask mr-1.5"></i> Química Descomplicada & Precisa
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
            Cálculos Estequiométricos Inteligentes
        </h1>
        <p class="mt-2 text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed">
            Balanceie reações, calcule número de mols, massa, volume nas CNTP, partículas, Nox, titulação e concentração molar com explicações detalhadas tanto para estudantes quanto para crianças!
        </p>
    </div>

    <!-- Navegação de Abas de Cálculos (Mobile-First) -->
    <div class="flex items-center justify-center mb-6">
        <div class="inline-flex p-1 space-x-1 bg-slate-200/80 dark:bg-slate-800 rounded-2xl overflow-x-auto max-w-full">
            <button type="button" class="calc-tab-btn active px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition bg-white dark:bg-slate-700 text-sky-600 dark:text-sky-300 shadow-sm" data-tab="tab-estequio">
                <i class="fas fa-balance-scale mr-1.5"></i> Estequiometria
            </button>
            <button type="button" class="calc-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition text-slate-600 dark:text-slate-300 hover:text-sky-600" data-tab="tab-massa-nox">
                <i class="fas fa-weight-hanging mr-1.5"></i> Massa & Nox
            </button>
            <button type="button" class="calc-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition text-slate-600 dark:text-slate-300 hover:text-sky-600" data-tab="tab-titulacao">
                <i class="fas fa-vial mr-1.5"></i> Titulação
            </button>
            <button type="button" class="calc-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition text-slate-600 dark:text-slate-300 hover:text-sky-600" data-tab="tab-concentracao">
                <i class="fas fa-tint mr-1.5"></i> Concentração
            </button>
        </div>
    </div>

    <!-- Card Principal de Cálculo -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200/80 dark:border-slate-700/80 p-5 sm:p-8 mb-8">
        
        <!-- ABA 1: Estequiometria de Reação -->
        <div id="tab-estequio" class="calc-tab-content">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-2">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center">
                        <i class="fas fa-atom text-sky-600 mr-2"></i> Reação Química & Proporções
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Digite reagentes e produtos. O balanceamento e as proporções molares serão calculados automaticamente.</p>
                </div>
                <a href="tabela-periodica.php" class="inline-flex items-center text-xs font-semibold text-sky-600 dark:text-sky-400 hover:underline">
                    <i class="fas fa-th mr-1"></i> Abrir Tabela Periódica
                </a>
            </div>

            <!-- Exemplos rápidos de reações -->
            <div class="mb-4 flex flex-wrap items-center gap-1.5 text-xs">
                <span class="text-slate-400 font-medium">Exemplos rápidos:</span>
                <button type="button" class="quick-sample px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-sky-50 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 transition" data-eq="H2 + O2 -> H2O">H₂ + O₂ → H₂O</button>
                <button type="button" class="quick-sample px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-sky-50 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 transition" data-eq="CH4 + O2 -> CO2 + H2O">CH₄ + O₂ → CO₂ + H₂O</button>
                <button type="button" class="quick-sample px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-sky-50 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 transition" data-eq="Fe + O2 -> Fe2O3">Fe + O₂ → Fe₂O₃</button>
                <button type="button" class="quick-sample px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-sky-50 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 transition" data-eq="N2 + H2 -> NH3">N₂ + H₂ → NH₃</button>
                <button type="button" class="quick-sample px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-sky-50 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 transition" data-eq="Al + HCl -> AlCl3 + H2">Al + HCl → AlCl₃ + H₂</button>
            </div>

            <!-- Caixa de Texto da Fórmula / Reação + Botão Calcular (Regra dos Requisitos) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 mb-4">
                <div class="lg:col-span-8">
                    <label for="formula-input" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Equação da Reação Química
                    </label>
                    <div class="relative">
                        <input type="text" id="formula-input" placeholder="Ex: H2 + O2 -> H2O ou NaOH + HCl -> NaCl + H2O" 
                               value="CH4 + O2 -> CO2 + H2O"
                               class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-white font-mono text-base focus:ring-2 focus:ring-sky-500 focus:outline-none transition">
                        <button type="button" id="btn-clear-formula" class="absolute right-3 top-3.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1" title="Limpar">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                </div>

                <div class="lg:col-span-4 flex items-end">
                    <button type="button" id="btn-calc-stoich" class="w-full py-3.5 px-6 rounded-2xl bg-gradient-to-r from-sky-600 to-indigo-600 hover:from-sky-700 hover:to-indigo-700 text-white font-bold text-base shadow-lg shadow-sky-500/25 hover:shadow-sky-500/35 active:scale-[0.99] transition flex items-center justify-center space-x-2">
                        <i class="fas fa-calculator text-lg"></i>
                        <span>Calcular Estequiometria</span>
                    </button>
                </div>
            </div>

            <!-- Parâmetros de Entrada (Dado fornecido) -->
            <div class="bg-slate-50 dark:bg-slate-900/50 p-4 rounded-2xl border border-slate-200 dark:border-slate-700/60 mb-6">
                <span class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                    <i class="fas fa-sliders-h mr-1 text-sky-500"></i> Informações Que Você Já Possui (Para cálculo de proporção):
                </span>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs text-slate-500 dark:text-slate-400 mb-1">Substância Conhecida:</label>
                        <select id="stoich-target-species" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-xs font-semibold text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                            <option value="0">1ª Substância da Reação</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 dark:text-slate-400 mb-1">Grandeza Fornecida:</label>
                        <select id="stoich-quantity-type" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-xs font-semibold text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                            <option value="massa">Massa (gramas - g)</option>
                            <option value="mols">Número de Mols (mol)</option>
                            <option value="volume">Volume nas CNTP (Litros - L)</option>
                            <option value="particulas">Número de Partículas / Moléculas</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 dark:text-slate-400 mb-1">Valor Numérico:</label>
                        <input type="number" id="stoich-quantity-val" step="any" value="16" placeholder="Ex: 16"
                               class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-xs font-bold text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500 focus:outline-none">
                    </div>
                </div>
            </div>
        </div>

        <!-- ABA 2: Massa Molar & Número de Oxidação (Nox) -->
        <div id="tab-massa-nox" class="calc-tab-content hidden">
            <div class="mb-4">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center">
                    <i class="fas fa-weight-hanging text-indigo-600 mr-2"></i> Cálculo de Massa Molar & Nox
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Insira a fórmula de qualquer composto químico para obter massa molar, percentual mássico de cada elemento e números de oxidação (Nox).</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 mb-6">
                <div class="lg:col-span-8">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Fórmula Molecular
                    </label>
                    <input type="text" id="massa-formula-input" placeholder="Ex: KMnO4, H2SO4, Ca(OH)2, Al2(SO4)3" value="KMnO4"
                           class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-slate-900 dark:text-white font-mono text-base focus:ring-2 focus:ring-sky-500 focus:outline-none transition">
                </div>
                <div class="lg:col-span-4 flex items-end">
                    <button type="button" id="btn-calc-massa-nox" class="w-full py-3.5 px-6 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base shadow-lg shadow-indigo-500/25 transition flex items-center justify-center space-x-2">
                        <i class="fas fa-search text-lg"></i>
                        <span>Calcular Massa & Nox</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- ABA 3: Titulação Ácido-Base -->
        <div id="tab-titulacao" class="calc-tab-content hidden">
            <div class="mb-4">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center">
                    <i class="fas fa-vial text-sky-600 mr-2"></i> Titulação Ácido-Base (Cₐ · Vₐ / a = C₆ · V₆ / b)
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Preencha três campos e deixe exatamente UM em branco para que o sistema descubra o valor restante automaticamente.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-rose-50/60 dark:bg-rose-950/20 p-4 rounded-2xl border border-rose-200 dark:border-rose-800">
                    <h3 class="text-xs font-bold text-rose-700 dark:text-rose-300 uppercase tracking-wider mb-2">Ácido</h3>
                    <label class="block text-xs text-slate-500 dark:text-slate-400 mb-1">Concentração Cₐ (mol/L):</label>
                    <input type="number" id="tit-ca" step="any" placeholder="Deixe vazio se for a incógnita" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-sm font-semibold mb-2">
                    <label class="block text-xs text-slate-500 dark:text-slate-400 mb-1">Volume Vₐ (mL ou L):</label>
                    <input type="number" id="tit-va" step="any" value="25" placeholder="Ex: 25" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-sm font-semibold">
                </div>

                <div class="bg-blue-50/60 dark:bg-blue-950/20 p-4 rounded-2xl border border-blue-200 dark:border-blue-800">
                    <h3 class="text-xs font-bold text-blue-700 dark:text-blue-300 uppercase tracking-wider mb-2">Base</h3>
                    <label class="block text-xs text-slate-500 dark:text-slate-400 mb-1">Concentração C₆ (mol/L):</label>
                    <input type="number" id="tit-cb" step="any" value="0.1" placeholder="Ex: 0.1" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-sm font-semibold mb-2">
                    <label class="block text-xs text-slate-500 dark:text-slate-400 mb-1">Volume V₆ gasto (mL ou L):</label>
                    <input type="number" id="tit-vb" step="any" value="32.5" placeholder="Ex: 32.5" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-sm font-semibold">
                </div>

                <div class="bg-slate-50 dark:bg-slate-900/40 p-4 rounded-2xl border border-slate-200 dark:border-slate-700">
                    <h3 class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Proporção (a : b)</h3>
                    <label class="block text-xs text-slate-500 dark:text-slate-400 mb-1">Coeficiente Ácido (a):</label>
                    <input type="number" id="tit-pa" value="1" min="1" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-sm font-semibold mb-2">
                    <label class="block text-xs text-slate-500 dark:text-slate-400 mb-1">Coeficiente Base (b):</label>
                    <input type="number" id="tit-pb" value="1" min="1" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-sm font-semibold">
                </div>

                <div class="flex flex-col justify-end">
                    <button type="button" id="btn-calc-titulacao" class="w-full py-4 px-6 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-lg shadow-emerald-500/25 transition flex items-center justify-center space-x-2">
                        <i class="fas fa-check-double text-base"></i>
                        <span>Calcular Titulação</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- ABA 4: Concentração Molar e Comum -->
        <div id="tab-concentracao" class="calc-tab-content hidden">
            <div class="mb-4">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center">
                    <i class="fas fa-tint text-sky-600 mr-2"></i> Soluções: Molaridade & Concentração Comum
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Informe a massa do soluto, sua fórmula (ou massa molar direta) e o volume da solução em litros.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
                <div>
                    <label class="block text-xs text-slate-500 dark:text-slate-400 mb-1">Fórmula do Soluto:</label>
                    <input type="text" id="conc-formula" value="NaCl" placeholder="Ex: NaCl, NaOH, C6H12O6" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-sm font-semibold">
                </div>
                <div>
                    <label class="block text-xs text-slate-500 dark:text-slate-400 mb-1">Massa do Soluto (g):</label>
                    <input type="number" id="conc-massa" value="58.44" step="any" placeholder="Ex: 58.44" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-sm font-semibold">
                </div>
                <div>
                    <label class="block text-xs text-slate-500 dark:text-slate-400 mb-1">Volume da Solução (Litros):</label>
                    <input type="number" id="conc-volume" value="1.0" step="any" placeholder="Ex: 1.0" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-sm font-semibold">
                </div>
            </div>

            <button type="button" id="btn-calc-concentracao" class="py-3 px-6 rounded-2xl bg-sky-600 hover:bg-sky-700 text-white font-bold text-sm shadow-md transition">
                <i class="fas fa-tint mr-1.5"></i> Calcular Concentrações
            </button>
        </div>

    </div>

    <!-- SEÇÃO DE RESULTADOS DETALHADOS -->
    <div id="results-container" class="hidden space-y-6">
        
        <!-- Cartão de Destaque / Resumo -->
        <div class="bg-gradient-to-r from-sky-600 to-indigo-700 rounded-3xl p-6 sm:p-8 text-white shadow-2xl relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-white/20 pb-4 mb-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-200">Resultado do Cálculo</span>
                        <h3 id="result-main-title" class="text-2xl sm:text-3xl font-black tracking-tight mt-1">Reação Balanceada</h3>
                    </div>
                    <div id="result-status-badge" class="self-start sm:self-center px-3 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur-md text-white flex items-center space-x-1.5">
                        <i class="fas fa-check-circle text-emerald-300"></i>
                        <span>Estequiometria Verificada</span>
                    </div>
                </div>
                <div id="result-summary-box" class="font-mono text-base sm:text-lg bg-black/20 p-4 rounded-2xl backdrop-blur-sm border border-white/10 break-all leading-relaxed">
                    <!-- Resumo inserido via JS -->
                </div>
            </div>
        </div>

        <!-- Grade com Tabela de Espécies Químicas (Massa, Mols, Volume, Partículas, Nox) -->
        <div id="species-grid-card" class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200/80 dark:border-slate-700/80 p-5 sm:p-8 overflow-hidden">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                <i class="fas fa-table text-sky-600 mr-2"></i> Tabela Estequiométrica Completa
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700 text-slate-400 uppercase tracking-wider font-semibold">
                            <th class="py-3 px-3">Papel</th>
                            <th class="py-3 px-3">Substância</th>
                            <th class="py-3 px-3">Coef.</th>
                            <th class="py-3 px-3">Massa Molar</th>
                            <th class="py-3 px-3 font-bold text-sky-600 dark:text-sky-400">Quantidade (Mols)</th>
                            <th class="py-3 px-3 font-bold text-emerald-600 dark:text-emerald-400">Massa (g)</th>
                            <th class="py-3 px-3">Volume CNTP (L)</th>
                            <th class="py-3 px-3">Partículas</th>
                        </tr>
                    </thead>
                    <tbody id="species-table-body" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <!-- Linhas geradas via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ÁREA DE EXPLICAÇÕES DUPLAS (Exigência: Objetiva + Para Crianças até 11 anos) -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200/80 dark:border-slate-700/80 p-5 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-700 gap-3 mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center">
                        <i class="fas fa-chalkboard-teacher text-amber-500 mr-2"></i> Como este cálculo foi feito?
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Escolha a linguagem mais adequada para o seu aprendizado.</p>
                </div>
                
                <!-- Alternador de Linguagem da Explicação -->
                <div class="inline-flex p-1 bg-slate-100 dark:bg-slate-700 rounded-2xl self-start sm:self-auto">
                    <button type="button" id="btn-mode-objective" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition bg-white dark:bg-slate-800 text-slate-800 dark:text-white shadow-sm flex items-center space-x-1.5">
                        <i class="fas fa-graduation-cap text-sky-600"></i>
                        <span>Explicação Objetiva</span>
                    </button>
                    <button type="button" id="btn-mode-kids" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition text-slate-500 dark:text-slate-300 hover:text-slate-800 dark:hover:text-white flex items-center space-x-1.5">
                        <i class="fas fa-child text-amber-500"></i>
                        <span>Para Crianças (até 11 anos)</span>
                    </button>
                </div>
            </div>

            <!-- Explicação Objetiva / Técnica -->
            <div id="explanation-objective" class="prose dark:prose-invert max-w-none text-xs sm:text-sm leading-relaxed space-y-4 text-slate-700 dark:text-slate-300">
                <!-- Preenchido via JS -->
            </div>

            <!-- Explicação para Crianças de até 11 anos -->
            <div id="explanation-kids" class="hidden bg-amber-50/60 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-800/60 rounded-2xl p-5 sm:p-6 text-slate-800 dark:text-slate-200 text-sm leading-relaxed">
                <!-- Preenchido via JS -->
            </div>
        </div>

    </div>

</main>

<script>
// Script específico da página principal
document.addEventListener("DOMContentLoaded", () => {
    // 1. Gerenciamento de Abas
    const tabBtns = document.querySelectorAll(".calc-tab-btn");
    const tabContents = document.querySelectorAll(".calc-tab-content");

    tabBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            tabBtns.forEach(b => {
                b.classList.remove("active", "bg-white", "dark:bg-slate-700", "text-sky-600", "dark:text-sky-300", "shadow-sm");
                b.classList.add("text-slate-600", "dark:text-slate-300");
            });
            btn.classList.add("active", "bg-white", "dark:bg-slate-700", "text-sky-600", "dark:text-sky-300", "shadow-sm");
            btn.classList.remove("text-slate-600", "dark:text-slate-300");

            const targetId = btn.getAttribute("data-tab");
            tabContents.forEach(c => {
                if (c.id === targetId) {
                    c.classList.remove("hidden");
                } else {
                    c.classList.add("hidden");
                }
            });
        });
    });

    // 2. Exemplos Rápidos
    const sampleBtns = document.querySelectorAll(".quick-sample");
    const formulaInput = document.getElementById("formula-input");
    sampleBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            if (formulaInput) {
                formulaInput.value = btn.getAttribute("data-eq");
                showToast("info", "Exemplo Carregado", `Reação carregada: ${formulaInput.value}`);
                updateSpeciesSelector();
            }
        });
    });

    // Limpar fórmula
    const btnClear = document.getElementById("btn-clear-formula");
    if (btnClear && formulaInput) {
        btnClear.addEventListener("click", () => {
            formulaInput.value = "";
            formulaInput.focus();
        });
    }

    // 3. Atualizar seletor de espécies dinamicamente
    function updateSpeciesSelector() {
        const sel = document.getElementById("stoich-target-species");
        if (!sel || !formulaInput) return;
        try {
            const eq = formulaInput.value.trim();
            if (eq.includes("->") || eq.includes("=")) {
                const b = balanceEquation(eq);
                sel.innerHTML = "";
                b.allSpecies.forEach((sp, idx) => {
                    const opt = document.createElement("option");
                    opt.value = idx;
                    opt.text = `${sp.formula} (${idx < b.reactants.length ? 'Reagente' : 'Produto'})`;
                    sel.appendChild(opt);
                });
            }
        } catch (e) {
            // Ignora enquanto o usuário ainda está digitando
        }
    }

    if (formulaInput) {
        formulaInput.addEventListener("blur", updateSpeciesSelector);
        updateSpeciesSelector();
    }

    // 4. Execução do Cálculo Estequiométrico
    const btnCalcStoich = document.getElementById("btn-calc-stoich");
    if (btnCalcStoich) {
        btnCalcStoich.addEventListener("click", () => {
            const eqStr = formulaInput.value.trim();
            if (!eqStr) {
                showToast("warning", "Campo Vazio", "Por favor, digite a reação química.");
                return;
            }

            try {
                // Balanceia a equação
                const balanced = balanceEquation(eqStr);
                const speciesIdx = parseInt(document.getElementById("stoich-target-species").value, 10) || 0;
                const qtyType = document.getElementById("stoich-quantity-type").value;
                const qtyVal = parseFloat(document.getElementById("stoich-quantity-val").value) || 1;

                const stoichResult = solveFullStoichiometry(balanced, speciesIdx, qtyType, qtyVal);
                const explanations = generateExplanations("estequiometria", stoichResult);

                renderResults({
                    title: "Reação Estequiométrica Balanceada",
                    summary: balanced.balancedEquation,
                    type: "estequiometria",
                    formula: eqStr,
                    data: stoichResult,
                    explanations: explanations
                });

                showToast("success", "Cálculo Realizado", "Equação balanceada e grandezas computadas com sucesso!");
            } catch (err) {
                showToast("error", "Erro no Cálculo", err.message);
                customAlert(err.message, "Atenção na Reação Química");
            }
        });
    }

    // 5. Execução do Cálculo de Massa Molar & Nox
    const btnCalcMassa = document.getElementById("btn-calc-massa-nox");
    if (btnCalcMassa) {
        btnCalcMassa.addEventListener("click", () => {
            const fStr = document.getElementById("massa-formula-input").value.trim();
            if (!fStr) {
                showToast("warning", "Campo Vazio", "Por favor, informe a fórmula molecular.");
                return;
            }

            try {
                const mmData = calculateMolarMass(fStr);
                const noxData = calculateNox(fStr);
                const expMM = generateExplanations("massa_molar", mmData);
                const expNox = generateExplanations("nox", noxData);

                let summary = `Fórmula: ${fStr} | Massa Molar: ${mmData.molarMass.toFixed(3)} g/mol\nNox: `;
                for (let sym in noxData.noxMap) {
                    const v = noxData.noxMap[sym];
                    summary += `${sym}: ${v > 0 ? '+' + v : v}  `;
                }

                renderResults({
                    title: `Massa Molar & Nox: ${fStr}`,
                    summary: summary,
                    type: "massa_nox",
                    formula: fStr,
                    molarData: mmData,
                    noxData: noxData,
                    explanations: {
                        objective: expMM.objective + "\n\n" + expNox.objective,
                        kids: expMM.kids + "\n\n" + expNox.kids
                    }
                });

                showToast("success", "Cálculo Realizado", `Massa Molar: ${mmData.molarMass.toFixed(3)} g/mol`);
            } catch (err) {
                showToast("error", "Erro na Fórmula", err.message);
                customAlert(err.message, "Fórmula Inválida");
            }
        });
    }

    // 6. Execução de Titulação
    const btnCalcTit = document.getElementById("btn-calc-titulacao");
    if (btnCalcTit) {
        btnCalcTit.addEventListener("click", () => {
            const va = parseFloat(document.getElementById("tit-va").value) || null;
            const ca = parseFloat(document.getElementById("tit-ca").value) || null;
            const vb = parseFloat(document.getElementById("tit-vb").value) || null;
            const cb = parseFloat(document.getElementById("tit-cb").value) || null;
            const pa = parseFloat(document.getElementById("tit-pa").value) || 1;
            const pb = parseFloat(document.getElementById("tit-pb").value) || 1;

            try {
                const titRes = calculateTitration(va, ca, vb, cb, pa, pb);
                renderResults({
                    title: `Titulação Ácido-Base: ${titRes.variable}`,
                    summary: `${titRes.variable} = ${titRes.value.toFixed(4)}`,
                    type: "titulacao",
                    formula: `Titulação (a=${pa}, b=${pb})`,
                    explanations: {
                        objective: `### Determinação da Titulação\n` + titRes.steps.join("\n\n"),
                        kids: `🧪 **O Ponto de Virada das Gotinhas!**\nImagine que o ácido e a base são dois times brincando de equilibrar uma gangorra mágica. Fomos pingando as gotinhas até a gangorra ficar retinha! O valor exato para o equilíbrio foi: **${titRes.value.toFixed(4)}**!`
                    }
                });
                showToast("success", "Titulação Calculada", `${titRes.variable}: ${titRes.value.toFixed(4)}`);
            } catch (err) {
                showToast("error", "Erro na Titulação", err.message);
                customAlert(err.message, "Titulação");
            }
        });
    }

    // 7. Execução de Concentração
    const btnCalcConc = document.getElementById("btn-calc-concentracao");
    if (btnCalcConc) {
        btnCalcConc.addEventListener("click", () => {
            const form = document.getElementById("conc-formula").value.trim();
            const mass = parseFloat(document.getElementById("conc-massa").value);
            const vol = parseFloat(document.getElementById("conc-volume").value);

            if (!form || isNaN(mass) || isNaN(vol)) {
                showToast("warning", "Campos Incompletos", "Preencha a fórmula, massa e volume.");
                return;
            }

            try {
                const mm = calculateMolarMass(form);
                const concRes = calculateConcentration(mass, mm.molarMass, vol);
                
                const summary = `Soluto: ${form} (M = ${mm.molarMass.toFixed(3)} g/mol)\nConcentração Molar (M): ${concRes.molarity.toFixed(4)} mol/L\nConcentração Comum (C): ${concRes.commonConcentration.toFixed(4)} g/L`;

                renderResults({
                    title: `Concentração da Solução (${form})`,
                    summary: summary,
                    type: "concentracao",
                    formula: `${mass}g de ${form} em ${vol}L`,
                    explanations: {
                        objective: `### Concentração da Solução\n- Número de Mols: $n = m / M = ${mass} / ${mm.molarMass.toFixed(3)} = ${concRes.moles.toFixed(4)} \\text{ mol}$\n- Molaridade: $M = n / V = ${concRes.moles.toFixed(4)} / ${vol} = ${concRes.molarity.toFixed(4)} \\text{ mol/L}$\n- Concentração Comum: $C = m / V = ${mass} / ${vol} = ${concRes.commonConcentration.toFixed(4)} \\text{ g/L}$`,
                        kids: `🧃 **Misturando o Suquinho da Química!**\nColocamos **${mass}g** do pozinho de **${form}** dentro de **${vol} litros** de água pura! Ficou na medida certa: cada copinho tem exatamente a dose necessária de sabor e átomos!`
                    }
                });
                showToast("success", "Concentração Calculada", `Molaridade: ${concRes.molarity.toFixed(4)} mol/L`);
            } catch (err) {
                showToast("error", "Erro em Concentração", err.message);
                customAlert(err.message, "Cálculo de Concentração");
            }
        });
    }

    // 8. Renderizar Resultados na Interface
    function renderResults(payload) {
        const container = document.getElementById("results-container");
        container.classList.remove("hidden");

        document.getElementById("result-main-title").innerText = payload.title;
        document.getElementById("result-summary-box").innerText = payload.summary;

        // Tabela de espécies
        const speciesCard = document.getElementById("species-grid-card");
        const tbody = document.getElementById("species-table-body");
        tbody.innerHTML = "";

        if (payload.type === "estequiometria" && payload.data) {
            speciesCard.classList.remove("hidden");
            payload.data.results.forEach(item => {
                const tr = document.createElement("tr");
                tr.className = "hover:bg-slate-50 dark:hover:bg-slate-700/30 transition";
                tr.innerHTML = `
                    <td class="py-3 px-3"><span class="px-2 py-0.5 rounded-full text-[11px] font-bold ${item.isReagent ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300' : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300'}">${item.isReagent ? 'Reagente' : 'Produto'}</span></td>
                    <td class="py-3 px-3 font-mono font-bold text-slate-800 dark:text-white">${item.formula}</td>
                    <td class="py-3 px-3 font-mono">${item.coeff}</td>
                    <td class="py-3 px-3 font-mono">${item.molarMass.toFixed(3)} g/mol</td>
                    <td class="py-3 px-3 font-mono font-bold text-sky-600 dark:text-sky-400">${item.moles.toFixed(4)} mol</td>
                    <td class="py-3 px-3 font-mono font-bold text-emerald-600 dark:text-emerald-400">${item.mass.toFixed(4)} g</td>
                    <td class="py-3 px-3 font-mono">${item.volume.toFixed(3)} L</td>
                    <td class="py-3 px-3 font-mono text-[11px]">${item.particles.toExponential(4)}</td>
                `;
                tbody.appendChild(tr);
            });
        } else {
            speciesCard.classList.add("hidden");
        }

        // Explicações
        const objBox = document.getElementById("explanation-objective");
        const kidsBox = document.getElementById("explanation-kids");
        
        // Converte quebras de linha e markdown simples
        objBox.innerHTML = formatMarkdown(payload.explanations.objective);
        kidsBox.innerHTML = formatMarkdown(payload.explanations.kids);

        // Salva via backend se logado (ou localStorage)
        saveCalculation({
            tipo_calculo: payload.type,
            entrada_formula: payload.formula,
            resultado_resumo: payload.summary,
            resultado_completo: payload
        });

        // Rola até os resultados suavemente
        container.scrollIntoView({ behavior: "smooth", block: "start" });
    }

    // 9. Alternador de Linguagem da Explicação (Objetiva vs Crianças)
    const btnObj = document.getElementById("btn-mode-objective");
    const btnKids = document.getElementById("btn-mode-kids");
    const expObj = document.getElementById("explanation-objective");
    const expKids = document.getElementById("explanation-kids");

    if (btnObj && btnKids) {
        btnObj.addEventListener("click", () => {
            btnObj.classList.add("bg-white", "dark:bg-slate-800", "text-slate-800", "dark:text-white", "shadow-sm");
            btnObj.classList.remove("text-slate-500", "dark:text-slate-300");
            btnKids.classList.remove("bg-white", "dark:bg-slate-800", "text-slate-800", "dark:text-white", "shadow-sm");
            btnKids.classList.add("text-slate-500", "dark:text-slate-300");

            expObj.classList.remove("hidden");
            expKids.classList.add("hidden");
        });

        btnKids.addEventListener("click", () => {
            btnKids.classList.add("bg-white", "dark:bg-slate-800", "text-slate-800", "dark:text-white", "shadow-sm");
            btnKids.classList.remove("text-slate-500", "dark:text-slate-300");
            btnObj.classList.remove("bg-white", "dark:bg-slate-800", "text-slate-800", "dark:text-white", "shadow-sm");
            btnObj.classList.add("text-slate-500", "dark:text-slate-300");

            expKids.classList.remove("hidden");
            expObj.classList.add("hidden");
            showToast("info", "Modo Didático Ativado", "Visualizando a explicação ilustrada para crianças até 11 anos! 🎈");
        });
    }

    // 10. Persistência de Cálculo (Backend PHP / PDO / LocalStorage)
    function saveCalculation(data) {
        // Envia ao backend se disponível
        fetch("../backend/calcular.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        }).then(r => r.json()).then(res => {
            if (res.logged) {
                // Usuário logado: salvo no banco de dados MySQL
                console.log("Cálculo registrado no banco de dados para o usuário autenticado.");
            }
        }).catch(err => {
            // Falha silenciosa no envio remoto, salva no localStorage como fallback
            const localHist = JSON.parse(localStorage.getItem("local_history") || "[]");
            localHist.unshift({
                tipo: data.tipo_calculo,
                entrada: data.entrada_formula,
                resumo: data.resultado_resumo,
                data: new Date().toLocaleString("pt-BR")
            });
            localStorage.setItem("local_history", JSON.stringify(localHist.slice(0, 50)));
        });
    }

    // Helper simples para formatar markdown em HTML
    function formatMarkdown(text) {
        if (!text) return "";
        return text
            .replace(/^### (.*$)/gim, '<h3 class="text-base font-bold text-slate-900 dark:text-white mt-3 mb-1">$1</h3>')
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            .replace(/\n/g, '<br>');
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
