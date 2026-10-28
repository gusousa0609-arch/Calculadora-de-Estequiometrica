<?php
$pageTitle = "Criar Nova Conta";
require_once __DIR__ . '/../config/config.php';

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
                <i class="fas fa-user-plus text-xl"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Criar Nova Conta</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Tenha acesso a histórico salvo, auditoria e preferências salvas.</p>
        </div>

        <form id="form-register" class="space-y-4">
            <div>
                <label for="reg-nome" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Nome Completo
                </label>
                <div class="relative">
                    <input type="text" id="reg-nome" name="nome" required placeholder="Seu Nome ou Usuário"
                           class="w-full pl-10 pr-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500 focus:outline-none transition">
                    <i class="fas fa-user absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                </div>
            </div>

            <div>
                <label for="reg-email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    E-mail (Único por conta)
                </label>
                <div class="relative">
                    <input type="email" id="reg-email" name="email" required placeholder="seu.email@exemplo.com"
                           class="w-full pl-10 pr-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500 focus:outline-none transition">
                    <i class="fas fa-envelope absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                </div>
            </div>

            <div>
                <label for="reg-senha" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Senha (Mínimo 6 caracteres)
                </label>
                <div class="relative">
                    <input type="password" id="reg-senha" name="senha" required minlength="6" placeholder="••••••••"
                           class="w-full pl-10 pr-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500 focus:outline-none transition">
                    <i class="fas fa-lock absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                </div>
            </div>

            <div>
                <label for="reg-confirmar-senha" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Confirmar Senha
                </label>
                <div class="relative">
                    <input type="password" id="reg-confirmar-senha" name="confirmar_senha" required minlength="6" placeholder="••••••••"
                           class="w-full pl-10 pr-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-600 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-sky-500 focus:outline-none transition">
                    <i class="fas fa-check-double absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                </div>
            </div>

            <button type="submit" id="btn-submit-register" class="w-full py-3.5 px-4 rounded-2xl bg-sky-600 hover:bg-sky-700 text-white font-bold text-sm shadow-lg shadow-sky-500/25 active:scale-[0.99] transition flex items-center justify-center space-x-2">
                <i class="fas fa-user-check"></i>
                <span>Cadastrar Gratuitamente</span>
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700 text-center">
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Já possui uma conta cadastrada?
                <a href="login.php" class="font-bold text-sky-600 hover:underline dark:text-sky-400 ml-1">Fazer login</a>
            </p>
        </div>

    </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("form-register");

    if (form) {
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const btn = document.getElementById("btn-submit-register");
            const pass = document.getElementById("reg-senha").value;
            const passConf = document.getElementById("reg-confirmar-senha").value;

            if (pass !== passConf) {
                showToast("error", "Senhas não coincidem", "A confirmação de senha deve ser idêntica.");
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Criando conta...';

            const formData = new FormData(form);

            fetch("../backend/auth/register.php", {
                method: "POST",
                body: formData
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast("success", "Conta Criada!", res.message);
                    setTimeout(() => {
                        window.location.href = res.redirect || "index.php";
                    }, 1000);
                } else {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-user-check"></i> <span>Cadastrar Gratuitamente</span>';
                    showToast("error", "Falha no Cadastro", res.message);
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-user-check"></i> <span>Cadastrar Gratuitamente</span>';
                showToast("error", "Erro de Conexão", "Não foi possível conectar ao servidor.");
            });
        });
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
