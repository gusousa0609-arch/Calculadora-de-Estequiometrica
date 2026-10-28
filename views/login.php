<?php
$pageTitle = "Entrar no Sistema";
require_once __DIR__ . '/../config/config.php';

// Se já estiver logado, redireciona para a página principal
if (isUserLoggedIn()) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . '/../includes/header.php';
?>

<main class="flex-1 flex items-center justify-center px-4 py-12">
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-2xl border border-slate-200/80 dark:border-slate-700/80 max-w-md w-full p-6 sm:p-8">
        
        <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-sky-600 to-indigo-600 flex items-center justify-center text-white mx-auto shadow-md shadow-sky-500/25 mb-3">
                <i class="fas fa-atom text-2xl"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Bem-vindo(a) de volta!</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Acesse sua conta para consultar seu histórico permanente e auditorias.</p>
        </div>

        <form id="form-login" class="space-y-4">
            <div>
                <label for="login-email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    E-mail
                </label>
                <div class="relative">
                    <input type="email" id="login-email" name="email" required placeholder="seu.email@exemplo.com"
                           class="w-full pl-10 pr-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500 focus:outline-none transition">
                    <i class="fas fa-envelope absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="login-password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Senha
                    </label>
                </div>
                <div class="relative">
                    <input type="password" id="login-password" name="senha" required placeholder="••••••••"
                           class="w-full pl-10 pr-10 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500 focus:outline-none transition">
                    <i class="fas fa-lock absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                    <button type="button" id="toggle-password" class="absolute right-3.5 top-3.5 text-slate-400 hover:text-slate-600">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" id="btn-submit-login" class="w-full py-3.5 px-4 rounded-2xl bg-sky-600 hover:bg-sky-700 text-white font-bold text-sm shadow-lg shadow-sky-500/25 active:scale-[0.99] transition flex items-center justify-center space-x-2">
                <i class="fas fa-sign-in-alt"></i>
                <span>Acessar Conta</span>
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700 text-center">
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Não tem uma conta ainda?
                <a href="registro.php" class="font-bold text-sky-600 hover:underline dark:text-sky-400 ml-1">Cadastre-se gratuitamente</a>
            </p>
            <div class="mt-3">
                <a href="index.php" class="text-xs text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition">
                    <i class="fas fa-arrow-left mr-1"></i> Continuar usando como visitante
                </a>
            </div>
        </div>

    </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("form-login");
    const togglePass = document.getElementById("toggle-password");
    const passInput = document.getElementById("login-password");

    if (togglePass && passInput) {
        togglePass.addEventListener("click", () => {
            const isPass = passInput.type === "password";
            passInput.type = isPass ? "text" : "password";
            togglePass.innerHTML = isPass ? '<i class="far fa-eye-slash"></i>' : '<i class="far fa-eye"></i>';
        });
    }

    if (form) {
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const btn = document.getElementById("btn-submit-login");
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Autenticando...';

            const formData = new FormData(form);

            fetch("../backend/auth/login.php", {
                method: "POST",
                body: formData
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast("success", "Sucesso!", res.message);
                    setTimeout(() => {
                        window.location.href = res.redirect || "index.php";
                    }, 1000);
                } else {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-sign-in-alt"></i> <span>Acessar Conta</span>';
                    showToast("error", "Falha de Login", res.message);
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-sign-in-alt"></i> <span>Acessar Conta</span>';
                showToast("error", "Erro de Conexão", "Não foi possível conectar ao servidor.");
            });
        });
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
