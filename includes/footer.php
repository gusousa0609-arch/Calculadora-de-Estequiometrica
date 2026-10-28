<?php
// Componente de Rodapé Global com Fontes e Referências Confiáveis da Internet
?>
<footer class="mt-auto bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            
            <!-- Coluna 1: Sobre o Projeto -->
            <div class="md:col-span-1 space-y-3">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-lg bg-sky-600 flex items-center justify-center text-white font-bold">
                        <i class="fas fa-atom"></i>
                    </div>
                    <span class="font-extrabold text-lg text-slate-900 dark:text-white">Estequio<span class="text-sky-600">Lab</span></span>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    Ferramenta inteligente e acessível voltada para estudantes, professores e profissionais da química. Facilita o balanceamento, cálculos molares, concentrações e titulações com explicações objetivas e didáticas.
                </p>
            </div>

            <!-- Coluna 2: Navegação Rápida -->
            <div>
                <h4 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-3">Navegação</h4>
                <ul class="space-y-2 text-xs text-slate-600 dark:text-slate-300">
                    <li><a href="index.php" class="hover:text-sky-600 dark:hover:text-sky-400 transition"><i class="fas fa-angle-right mr-1 opacity-50"></i> Calculadora</a></li>
                    <li><a href="tabela-periodica.php" class="hover:text-sky-600 dark:hover:text-sky-400 transition"><i class="fas fa-angle-right mr-1 opacity-50"></i> Tabela Periódica Interativa</a></li>
                    <li><a href="historico.php" class="hover:text-sky-600 dark:hover:text-sky-400 transition"><i class="fas fa-angle-right mr-1 opacity-50"></i> Histórico de Consultas</a></li>
                    <li><a href="auditoria.php" class="hover:text-sky-600 dark:hover:text-sky-400 transition"><i class="fas fa-angle-right mr-1 opacity-50"></i> Logs e Auditoria</a></li>
                </ul>
            </div>

            <!-- Coluna 3: Fontes e Fórmulas da Internet (Exigência do Requisitos.md) -->
            <div class="md:col-span-2">
                <h4 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-3 flex items-center">
                    <i class="fas fa-book-open text-sky-600 mr-2"></i> Fontes & Referências Científicas Consultadas
                </h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">
                    Conforme os requisitos do projeto, todas as fórmulas, constantes (Avogadro, Volume Molar nas CNTP) e massas atômicas seguem normas padronizadas:
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                    <a href="https://goldbook.iupac.org/" target="_blank" rel="noopener noreferrer" class="p-2 rounded-lg bg-slate-50 dark:bg-slate-700/50 hover:bg-sky-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 transition flex items-center space-x-2">
                        <i class="fas fa-external-link-alt text-sky-500 text-[10px]"></i>
                        <span><strong>IUPAC Gold Book</strong> - Nomenclatura e Constantes</span>
                    </a>
                    <a href="https://www.sbq.org.br/" target="_blank" rel="noopener noreferrer" class="p-2 rounded-lg bg-slate-50 dark:bg-slate-700/50 hover:bg-sky-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 transition flex items-center space-x-2">
                        <i class="fas fa-external-link-alt text-sky-500 text-[10px]"></i>
                        <span><strong>SBQ</strong> - Sociedade Brasileira de Química</span>
                    </a>
                    <a href="https://brasilescola.uol.com.br/quimica/calculos-estequiometricos.htm" target="_blank" rel="noopener noreferrer" class="p-2 rounded-lg bg-slate-50 dark:bg-slate-700/50 hover:bg-sky-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 transition flex items-center space-x-2">
                        <i class="fas fa-external-link-alt text-sky-500 text-[10px]"></i>
                        <span><strong>Brasil Escola</strong> - Cálculos Estequiométricos</span>
                    </a>
                    <a href="https://pt.khanacademy.org/science/chemistry/chemical-reactions-stoichiome" target="_blank" rel="noopener noreferrer" class="p-2 rounded-lg bg-slate-50 dark:bg-slate-700/50 hover:bg-sky-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 transition flex items-center space-x-2">
                        <i class="fas fa-external-link-alt text-sky-500 text-[10px]"></i>
                        <span><strong>Khan Academy</strong> - Estequiometria Química</span>
                    </a>
                    <a href="https://www.todamateria.com.br/estequiometria/" target="_blank" rel="noopener noreferrer" class="p-2 rounded-lg bg-slate-50 dark:bg-slate-700/50 hover:bg-sky-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 transition flex items-center space-x-2">
                        <i class="fas fa-external-link-alt text-sky-500 text-[10px]"></i>
                        <span><strong>Toda Matéria</strong> - Regras de Três & Proporções</span>
                    </a>
                    <a href="https://pt.wikipedia.org/wiki/Massa_molar" target="_blank" rel="noopener noreferrer" class="p-2 rounded-lg bg-slate-50 dark:bg-slate-700/50 hover:bg-sky-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 transition flex items-center space-x-2">
                        <i class="fas fa-external-link-alt text-sky-500 text-[10px]"></i>
                        <span><strong>Tabela Periódica Oficial</strong> - Pesos Atômicos IUPAC</span>
                    </a>
                </div>
            </div>

        </div>

        <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400">
            <p>&copy; <?= date('Y') ?> Calculadora Estequiométrica - Projeto de Química Computacional. Desenvolvido com PHP, PDO MySQL e Tailwind CSS.</p>
            <p class="mt-2 sm:mt-0 font-medium text-slate-500 dark:text-slate-400">Mobile-First &bull; Modo Criança &bull; Auditoria de Logs</p>
        </div>
    </div>
</footer>

<!-- Inclusão dos Toasts e Modais Universais -->
<?php require_once __DIR__ . '/toast.php'; ?>
<?php require_once __DIR__ . '/modal.php'; ?>

<!-- Scripts Globais -->
<script src="../assets/js/periodic-table.js"></script>
<script src="../assets/js/stoichiometry.js"></script>
<script src="../assets/js/app.js"></script>
</body>
</html>
