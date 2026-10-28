<?php
if (!defined('APP_NAME')) {
    require_once __DIR__ . '/../config/config.php';
}
$isLoggedIn = isUserLoggedIn();
$user = getLoggedUserData();
$currentPage = basename($_SERVER['PHP_SELF'] ?? 'index.php');
?>
<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - ' : '' ?><?= APP_NAME ?></title>
    <!-- Tailwind CSS v3 Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        chem: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0284c7',
                            600: '#0369a1',
                            700: '#075985',
                            800: '#0c4a6e',
                            900: '#082f49',
                        }
                    }
                }
            }
        }
    </script>
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 min-h-full flex flex-col antialiased">

<!-- Barra de Navegação Superior (Header Responsivo Mobile-First) -->
<header class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-700 sticky top-0 z-40 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <!-- Logo e Título -->
            <a href="index.php" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-600 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-sky-500/20 group-hover:scale-105 transition-transform">
                    <i class="fas fa-atom text-xl animate-spin-slow"></i>
                </div>
                <div>
                    <span class="font-extrabold text-lg sm:text-xl tracking-tight text-slate-900 dark:text-white block leading-tight">
                        Estequio<span class="text-sky-600 dark:text-sky-400">Lab</span>
                    </span>
                    <span class="text-[10px] text-slate-400 font-medium tracking-wider uppercase block">Cálculos & Tabela Periódica</span>
                </div>
            </a>

            <!-- Menu Desktop -->
            <nav class="hidden md:flex items-center space-x-1 lg:space-x-2">
                <a href="index.php" class="px-3 py-2 rounded-xl text-sm font-semibold transition <?= $currentPage === 'index.php' ? 'bg-sky-50 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300' : 'text-slate-600 hover:text-sky-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700/50' ?>">
                    <i class="fas fa-calculator mr-1.5 opacity-80"></i> Calculadora
                </a>
                <a href="tabela-periodica.php" class="px-3 py-2 rounded-xl text-sm font-semibold transition <?= $currentPage === 'tabela-periodica.php' ? 'bg-sky-50 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300' : 'text-slate-600 hover:text-sky-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700/50' ?>">
                    <i class="fas fa-th mr-1.5 opacity-80"></i> Tabela Periódica
                </a>
                <a href="historico.php" class="px-3 py-2 rounded-xl text-sm font-semibold transition <?= $currentPage === 'historico.php' ? 'bg-sky-50 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300' : 'text-slate-600 hover:text-sky-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700/50' ?>">
                    <i class="fas fa-history mr-1.5 opacity-80"></i> Histórico
                    <?php if (!$isLoggedIn): ?>
                        <span class="ml-1 text-[10px] bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300 px-1.5 py-0.5 rounded-full font-bold">Login</span>
                    <?php endif; ?>
                </a>
                <a href="auditoria.php" class="px-3 py-2 rounded-xl text-sm font-semibold transition <?= $currentPage === 'auditoria.php' ? 'bg-sky-50 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300' : 'text-slate-600 hover:text-sky-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700/50' ?>">
                    <i class="fas fa-shield-alt mr-1.5 opacity-80"></i> Auditoria / Logs
                </a>
            </nav>

            <!-- Ações do Usuário / Login / Tema -->
            <div class="hidden md:flex items-center space-x-3">
                <!-- Botão Alternar Dark Mode -->
                <button id="theme-toggle" type="button" class="p-2 text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition" title="Alternar Modo Escuro">
                    <i class="fas fa-moon dark:hidden"></i>
                    <i class="fas fa-sun hidden dark:inline"></i>
                </button>

                <?php if ($isLoggedIn): ?>
                    <div class="flex items-center space-x-2 pl-2 border-l border-slate-200 dark:border-slate-700">
                        <div class="w-8 h-8 rounded-full bg-sky-100 text-sky-800 dark:bg-sky-900 dark:text-sky-200 flex items-center justify-center font-bold text-xs uppercase" title="<?= htmlspecialchars($user['email']) ?>">
                            <?= substr($user['nome'], 0, 2) ?>
                        </div>
                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-200 max-w-[120px] truncate">
                            <?= htmlspecialchars($user['nome']) ?>
                        </span>
                        <a href="../backend/auth/logout.php" class="text-xs text-rose-600 hover:text-rose-700 dark:text-rose-400 hover:underline ml-2" title="Encerrar Sessão">
                            <i class="fas fa-sign-out-alt"></i> Sair
                        </a>
                    </div>
                <?php else: ?>
                    <div class="flex items-center space-x-2">
                        <a href="login.php" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-sky-600 dark:text-slate-300 transition">
                            Entrar
                        </a>
                        <a href="registro.php" class="px-4 py-2 text-sm font-semibold text-white bg-sky-600 hover:bg-sky-700 rounded-xl shadow-sm shadow-sky-500/20 transition">
                            Cadastre-se
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Botão Menu Mobile (Mobile-First) -->
            <div class="flex items-center space-x-2 md:hidden">
                <button id="theme-toggle-mobile" type="button" class="p-2 text-slate-500 hover:text-slate-700 dark:text-slate-400 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                    <i class="fas fa-moon dark:hidden"></i>
                    <i class="fas fa-sun hidden dark:inline"></i>
                </button>
                <button id="mobile-menu-btn" type="button" class="p-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Gaveta / Menu Mobile Dropdown -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 pt-3 pb-5 space-y-2">
        <a href="index.php" class="block px-3 py-2.5 rounded-xl text-base font-medium <?= $currentPage === 'index.php' ? 'bg-sky-50 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300' : 'text-slate-600 dark:text-slate-300' ?>">
            <i class="fas fa-calculator mr-2"></i> Calculadora Estequiométrica
        </a>
        <a href="tabela-periodica.php" class="block px-3 py-2.5 rounded-xl text-base font-medium <?= $currentPage === 'tabela-periodica.php' ? 'bg-sky-50 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300' : 'text-slate-600 dark:text-slate-300' ?>">
            <i class="fas fa-th mr-2"></i> Tabela Periódica
        </a>
        <a href="historico.php" class="block px-3 py-2.5 rounded-xl text-base font-medium <?= $currentPage === 'historico.php' ? 'bg-sky-50 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300' : 'text-slate-600 dark:text-slate-300' ?>">
            <i class="fas fa-history mr-2"></i> Histórico de Cálculos
        </a>
        <a href="auditoria.php" class="block px-3 py-2.5 rounded-xl text-base font-medium <?= $currentPage === 'auditoria.php' ? 'bg-sky-50 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300' : 'text-slate-600 dark:text-slate-300' ?>">
            <i class="fas fa-shield-alt mr-2"></i> Auditoria do Sistema
        </a>
        <div class="pt-4 border-t border-slate-200 dark:border-slate-700">
            <?php if ($isLoggedIn): ?>
                <div class="px-3 py-2 text-sm text-slate-500 dark:text-slate-400">
                    Conectado como <strong class="text-slate-800 dark:text-white"><?= htmlspecialchars($user['nome']) ?></strong>
                </div>
                <a href="../backend/auth/logout.php" class="block px-3 py-2 text-sm font-semibold text-rose-600 dark:text-rose-400">
                    <i class="fas fa-sign-out-alt mr-1"></i> Sair da Conta
                </a>
            <?php else: ?>
                <div class="grid grid-cols-2 gap-2 mt-2">
                    <a href="login.php" class="text-center py-2 px-3 rounded-xl border border-slate-300 dark:border-slate-600 text-sm font-medium text-slate-700 dark:text-slate-200">
                        Entrar
                    </a>
                    <a href="registro.php" class="text-center py-2 px-3 rounded-xl bg-sky-600 text-white text-sm font-semibold shadow-sm">
                        Cadastre-se
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>
