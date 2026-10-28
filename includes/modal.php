<!-- Componente Global de Modais (Regra: Mensagens nativas tratadas em MODAL) -->

<!-- Modal Genérico para Diálogos de Alerta e Confirmação -->
<div id="system-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
    <div id="system-modal-card" class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full p-6 border border-slate-200 dark:border-slate-700 transform scale-95 transition-transform duration-300">
        <div class="flex items-center space-x-3 mb-4">
            <div id="system-modal-icon-container" class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-300">
                <i id="system-modal-icon" class="fas fa-info-circle text-lg"></i>
            </div>
            <h3 id="system-modal-title" class="text-lg font-bold text-slate-800 dark:text-white">Aviso do Sistema</h3>
        </div>
        <div id="system-modal-content" class="text-sm text-slate-600 dark:text-slate-300 mb-6 leading-relaxed">
            Mensagem descritiva aqui.
        </div>
        <div class="flex items-center justify-end space-x-3">
            <button id="system-modal-btn-cancel" type="button" class="px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-xl transition hidden">
                Cancelar
            </button>
            <button id="system-modal-btn-confirm" type="button" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition">
                Entendido
            </button>
        </div>
    </div>
</div>

<!-- Modal de Detalhes do Elemento Químico da Tabela Periódica -->
<div id="element-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-2xl max-w-lg w-full p-6 sm:p-8 border border-slate-200 dark:border-slate-700 transform scale-95 transition-transform duration-300 relative overflow-hidden">
        
        <!-- Faixa de cabeçalho com cor temática -->
        <div id="elem-modal-banner" class="absolute top-0 left-0 right-0 h-3 bg-indigo-500"></div>
        
        <button id="elem-modal-close" type="button" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 dark:hover:text-white p-2 text-lg">
            <i class="fas fa-times"></i>
        </button>

        <div class="flex items-center space-x-4 mt-2 mb-6">
            <div id="elem-modal-box" class="w-20 h-20 rounded-2xl flex flex-col items-center justify-center text-white font-bold shadow-md bg-indigo-600">
                <span id="elem-modal-atomic-number" class="text-xs font-mono opacity-80">1</span>
                <span id="elem-modal-symbol" class="text-2xl font-black">H</span>
                <span id="elem-modal-mass" class="text-[10px] font-mono">1.008</span>
            </div>
            <div>
                <h3 id="elem-modal-name" class="text-2xl font-black text-slate-900 dark:text-white">Hidrogênio</h3>
                <span id="elem-modal-category" class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300">Não-metal</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3 text-sm mb-6">
            <div class="bg-slate-50 dark:bg-slate-700/50 p-3 rounded-xl">
                <span class="block text-xs text-slate-400 uppercase tracking-wider font-semibold">Grupo / Família</span>
                <span id="elem-modal-group" class="font-bold text-slate-700 dark:text-slate-200 text-sm">1 (1A)</span>
            </div>
            <div class="bg-slate-50 dark:bg-slate-700/50 p-3 rounded-xl">
                <span class="block text-xs text-slate-400 uppercase tracking-wider font-semibold">Período</span>
                <span id="elem-modal-period" class="font-bold text-slate-700 dark:text-slate-200 text-sm">1</span>
            </div>
            <div class="bg-slate-50 dark:bg-slate-700/50 p-3 rounded-xl">
                <span class="block text-xs text-slate-400 uppercase tracking-wider font-semibold">Eletronegatividade</span>
                <span id="elem-modal-electronegativity" class="font-bold text-slate-700 dark:text-slate-200 text-sm">2.20</span>
            </div>
            <div class="bg-slate-50 dark:bg-slate-700/50 p-3 rounded-xl">
                <span class="block text-xs text-slate-400 uppercase tracking-wider font-semibold">Estado a 25°C</span>
                <span id="elem-modal-state" class="font-bold text-slate-700 dark:text-slate-200 text-sm">Gasoso</span>
            </div>
            <div class="bg-slate-50 dark:bg-slate-700/50 p-3 rounded-xl col-span-2">
                <span class="block text-xs text-slate-400 uppercase tracking-wider font-semibold">Distribuição Eletrônica</span>
                <span id="elem-modal-config" class="font-mono text-xs font-semibold text-slate-800 dark:text-slate-200">1s¹</span>
            </div>
            <div class="bg-slate-50 dark:bg-slate-700/50 p-3 rounded-xl col-span-2">
                <span class="block text-xs text-slate-400 uppercase tracking-wider font-semibold">Nox Mais Comuns</span>
                <span id="elem-modal-nox" class="font-mono text-xs font-semibold text-slate-800 dark:text-slate-200">+1, -1</span>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3">
            <button id="elem-modal-btn-insert" type="button" class="w-full sm:flex-1 py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm shadow-md transition flex items-center justify-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Adicionar à Fórmula</span>
            </button>
            <button id="elem-modal-btn-copy" type="button" class="w-full sm:w-auto py-2.5 px-4 rounded-xl border border-slate-300 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-medium text-sm transition flex items-center justify-center space-x-2">
                <i class="far fa-copy"></i>
                <span>Copiar Símbolo</span>
            </button>
        </div>
    </div>
</div>
