<?php
$pageTitle = "Tabela Periódica dos Elementos Químicos";
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/header.php';
?>

<main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <!-- Cabeçalho da Página -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300">
                    <i class="fas fa-th mr-1"></i> Tabela IUPAC Interativa
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white mt-1">
                Tabela Periódica dos Elementos
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                Clique sobre qualquer elemento químico para ver massa atômica, Nox, distribuição eletrônica e transferir para a calculadora.
            </p>
        </div>

        <!-- Barra de Busca Rápida -->
        <div class="w-full md:w-80">
            <div class="relative">
                <input type="text" id="elem-search-input" placeholder="Buscar por símbolo, nome ou Z (ex: Au, Ouro, 79)..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-xs sm:text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500 focus:outline-none shadow-sm transition">
                <i class="fas fa-search absolute left-3.5 top-3 text-slate-400 text-sm"></i>
                <button type="button" id="btn-clear-search" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 hidden">
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Filtros por Categoria Química (Chips com cores) -->
    <div class="mb-6 overflow-x-auto pb-2">
        <div class="inline-flex flex-wrap gap-1.5 items-center">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mr-1">Famílias:</span>
            <button type="button" class="category-filter-btn active px-3 py-1 rounded-xl text-xs font-semibold bg-sky-600 text-white shadow-sm transition" data-category="all">Todas</button>
            <button type="button" class="category-filter-btn px-3 py-1 rounded-xl text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300 hover:scale-105 transition" data-category="nao-metal">Não-metais</button>
            <button type="button" class="category-filter-btn px-3 py-1 rounded-xl text-xs font-semibold bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-300 hover:scale-105 transition" data-category="metal-alcalino">Metais Alcalinos</button>
            <button type="button" class="category-filter-btn px-3 py-1 rounded-xl text-xs font-semibold bg-orange-100 text-orange-800 dark:bg-orange-900/40 dark:text-orange-300 hover:scale-105 transition" data-category="alcalino-terroso">Alcalinoterrosos</button>
            <button type="button" class="category-filter-btn px-3 py-1 rounded-xl text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300 hover:scale-105 transition" data-category="metal-transicao">Metais de Transição</button>
            <button type="button" class="category-filter-btn px-3 py-1 rounded-xl text-xs font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900/40 dark:text-indigo-300 hover:scale-105 transition" data-category="metal-pos-transicao">Pós-transição</button>
            <button type="button" class="category-filter-btn px-3 py-1 rounded-xl text-xs font-semibold bg-teal-100 text-teal-800 dark:bg-teal-900/40 dark:text-teal-300 hover:scale-105 transition" data-category="semimetal">Semimetais</button>
            <button type="button" class="category-filter-btn px-3 py-1 rounded-xl text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300 hover:scale-105 transition" data-category="halogenio">Halogênios</button>
            <button type="button" class="category-filter-btn px-3 py-1 rounded-xl text-xs font-semibold bg-purple-100 text-purple-800 dark:bg-purple-900/40 dark:text-purple-300 hover:scale-105 transition" data-category="gas-nobre">Gases Nobres</button>
            <button type="button" class="category-filter-btn px-3 py-1 rounded-xl text-xs font-semibold bg-cyan-100 text-cyan-800 dark:bg-cyan-900/40 dark:text-cyan-300 hover:scale-105 transition" data-category="lantanideo">Lantanídeos</button>
            <button type="button" class="category-filter-btn px-3 py-1 rounded-xl text-xs font-semibold bg-pink-100 text-pink-800 dark:bg-pink-900/40 dark:text-pink-300 hover:scale-105 transition" data-category="actinideo">Actinídeos</button>
        </div>
    </div>

    <!-- Tabela Periódica em Grid Responsiva (Horizontal scroll para telas menores) -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200/80 dark:border-slate-700/80 p-4 sm:p-6 overflow-x-auto">
        <div class="min-w-[960px]">
            
            <!-- Grid dos 18 Grupos Principais -->
            <div id="main-periodic-grid" class="periodic-table-grid mb-4">
                <!-- Células geradas via JavaScript com posição exata (col/row) -->
            </div>

            <!-- Separador para Lantanídeos e Actinídeos -->
            <div class="my-4 border-t border-dashed border-slate-200 dark:border-slate-700 pt-3">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-2">Série dos Lantanídeos e Actinídeos (Bloco F)</span>
                
                <div id="lanthanides-grid" class="grid grid-cols-15 gap-1 mb-1.5" style="display: grid; grid-template-columns: repeat(15, minmax(44px, 1fr));">
                    <!-- Gerado via JS -->
                </div>
                <div id="actinides-grid" class="grid grid-cols-15 gap-1" style="display: grid; grid-template-columns: repeat(15, minmax(44px, 1fr));">
                    <!-- Gerado via JS -->
                </div>
            </div>

        </div>
    </div>

</main>

<script>
// Script de Montagem e Interatividade da Tabela Periódica
document.addEventListener("DOMContentLoaded", () => {
    const mainGrid = document.getElementById("main-periodic-grid");
    const lanthGrid = document.getElementById("lanthanides-grid");
    const actGrid = document.getElementById("actinides-grid");
    const searchInput = document.getElementById("elem-search-input");
    const clearSearchBtn = document.getElementById("btn-clear-search");
    const filterBtns = document.querySelectorAll(".category-filter-btn");

    let currentFilter = "all";
    let currentSearch = "";

    function renderTable() {
        mainGrid.innerHTML = "";
        lanthGrid.innerHTML = "";
        actGrid.innerHTML = "";

        // Cria matriz 7 linhas x 18 colunas
        const matrix = Array(7).fill(null).map(() => Array(18).fill(null));

        ELEMENTS_DATA.forEach(elem => {
            // Lantanídeos (58 a 71) e Actinídeos (90 a 103) vão para suas próprias faixas
            if (elem.z >= 58 && elem.z <= 71) {
                lanthGrid.appendChild(createElementCell(elem));
            } else if (elem.z >= 90 && elem.z <= 103) {
                actGrid.appendChild(createElementCell(elem));
            } else {
                if (elem.p && elem.g) {
                    matrix[elem.p - 1][elem.g - 1] = elem;
                }
            }
        });

        // Preenche o grid principal
        for (let row = 0; row < 7; row++) {
            for (let col = 0; col < 18; col++) {
                const elem = matrix[row][col];
                if (elem) {
                    mainGrid.appendChild(createElementCell(elem));
                } else if (row === 5 && col === 2) {
                    // Marcador de Lantanídeos 57-71
                    const placeholder = document.createElement("div");
                    placeholder.className = "element-cell flex flex-col items-center justify-center p-1 rounded-xl border border-dashed border-cyan-400 bg-cyan-50/50 dark:bg-cyan-950/30 text-cyan-700 dark:text-cyan-300 text-[10px] font-bold";
                    placeholder.innerHTML = "<span>57-71</span><span class='text-[8px]'>La-Lu</span>";
                    mainGrid.appendChild(placeholder);
                } else if (row === 6 && col === 2) {
                    // Marcador de Actinídeos 89-103
                    const placeholder = document.createElement("div");
                    placeholder.className = "element-cell flex flex-col items-center justify-center p-1 rounded-xl border border-dashed border-pink-400 bg-pink-50/50 dark:bg-pink-950/30 text-pink-700 dark:text-pink-300 text-[10px] font-bold";
                    placeholder.innerHTML = "<span>89-103</span><span class='text-[8px]'>Ac-Lr</span>";
                    mainGrid.appendChild(placeholder);
                } else {
                    const emptyCell = document.createElement("div");
                    emptyCell.className = "element-cell invisible";
                    mainGrid.appendChild(emptyCell);
                }
            }
        }
    }

    function createElementCell(elem) {
        const cell = document.createElement("div");
        const catStyle = CATEGORY_COLORS[elem.c] || { bg: "bg-slate-100 dark:bg-slate-700 text-slate-800" };
        
        // Verifica filtros ativos
        let matchesFilter = currentFilter === "all" || elem.c === currentFilter;
        let matchesSearch = true;
        if (currentSearch) {
            const q = currentSearch.toLowerCase();
            matchesSearch = elem.s.toLowerCase().includes(q) ||
                            elem.n.toLowerCase().includes(q) ||
                            String(elem.z) === q;
        }

        const isDimmed = !matchesFilter || !matchesSearch;

        cell.className = `element-cell cursor-pointer flex flex-col justify-between p-1.5 rounded-xl border text-center transition-all ${catStyle.bg} ${isDimmed ? 'opacity-20 grayscale pointer-events-none' : 'opacity-100 hover:shadow-lg'}`;
        cell.title = `${elem.n} (Z=${elem.z}, Massa=${elem.m.toFixed(2)})`;

        cell.innerHTML = `
            <div class="flex justify-between items-center text-[9px] font-mono opacity-70 leading-none">
                <span>${elem.z}</span>
                <span class="hidden sm:inline text-[8px]">${elem.m.toFixed(1)}</span>
            </div>
            <div class="text-sm font-black tracking-tight leading-none my-0.5">${elem.s}</div>
            <div class="text-[9px] truncate opacity-90 leading-none font-medium hidden sm:block">${elem.n}</div>
        `;

        cell.addEventListener("click", () => {
            showElementDetails(elem);
        });

        return cell;
    }

    // Filtros de Categoria
    filterBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            filterBtns.forEach(b => b.classList.remove("active", "bg-sky-600", "text-white"));
            btn.classList.add("active", "bg-sky-600", "text-white");
            currentFilter = btn.getAttribute("data-category");
            renderTable();
        });
    });

    // Busca de elementos
    if (searchInput) {
        searchInput.addEventListener("input", (e) => {
            currentSearch = e.target.value.trim();
            if (currentSearch.length > 0) {
                clearSearchBtn.classList.remove("hidden");
            } else {
                clearSearchBtn.classList.add("hidden");
            }
            renderTable();
        });

        clearSearchBtn.addEventListener("click", () => {
            searchInput.value = "";
            currentSearch = "";
            clearSearchBtn.classList.add("hidden");
            renderTable();
        });
    }

    renderTable();
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
