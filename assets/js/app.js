/**
 * Aplicação Principal EstequioLab
 * Gerencia Toasts, Modais, Interface Reativa, Submissão de Cálculos,
 * Teclado Químico de Subscritos/Sobrescritos e Drag & Drop de Elementos.
 */

// 1. Tratamento de Tema Escuro (Dark Mode)
function initTheme() {
    const savedTheme = localStorage.getItem("theme");
    const systemPrefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
    
    if (savedTheme === "dark" || (!savedTheme && systemPrefersDark)) {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }

    const toggleBtns = [document.getElementById("theme-toggle"), document.getElementById("theme-toggle-mobile")];
    toggleBtns.forEach(btn => {
        if (!btn) return;
        btn.addEventListener("click", () => {
            document.documentElement.classList.toggle("dark");
            const isDark = document.documentElement.classList.contains("dark");
            localStorage.setItem("theme", isDark ? "dark" : "light");
            showToast("info", "Tema Atualizado", `Modo ${isDark ? 'Escuro' : 'Claro'} ativado.`);
        });
    });
}

// 2. Menu Responsivo Mobile (Mobile-First)
function initMobileMenu() {
    const menuBtn = document.getElementById("mobile-menu-btn");
    const menu = document.getElementById("mobile-menu");
    if (!menuBtn || !menu) return;

    menuBtn.addEventListener("click", () => {
        menu.classList.toggle("hidden");
    });
}

// 3. Sistema de Notificações Toast
function showToast(type = "info", title = "", message = "", duration = 4000) {
    const container = document.getElementById("toast-container");
    const template = document.getElementById("toast-template");
    if (!container || !template) return;

    const clone = template.content.cloneNode(true);
    const toastElem = clone.querySelector(".toast-item");
    const iconElem = toastElem.querySelector(".toast-icon");
    const titleElem = toastElem.querySelector(".toast-title");
    const msgElem = toastElem.querySelector(".toast-message");
    const closeBtn = toastElem.querySelector(".toast-close");

    titleElem.innerText = title;
    msgElem.innerText = message;

    const styles = {
        success: {
            bg: "bg-emerald-50 dark:bg-emerald-950 border-emerald-300 dark:border-emerald-700 text-emerald-900 dark:text-emerald-100",
            icon: '<i class="fas fa-check-circle text-emerald-600 dark:text-emerald-400"></i>'
        },
        error: {
            bg: "bg-rose-50 dark:bg-rose-950 border-rose-300 dark:border-rose-700 text-rose-900 dark:text-rose-100",
            icon: '<i class="fas fa-exclamation-circle text-rose-600 dark:text-rose-400"></i>'
        },
        warning: {
            bg: "bg-amber-50 dark:bg-amber-950 border-amber-300 dark:border-amber-700 text-amber-900 dark:text-amber-100",
            icon: '<i class="fas fa-exclamation-triangle text-amber-600 dark:text-amber-400"></i>'
        },
        info: {
            bg: "bg-sky-50 dark:bg-sky-950 border-sky-300 dark:border-sky-700 text-sky-900 dark:text-sky-100",
            icon: '<i class="fas fa-info-circle text-sky-600 dark:text-sky-400"></i>'
        }
    };

    const s = styles[type] || styles.info;
    toastElem.className += ` ${s.bg}`;
    iconElem.innerHTML = s.icon;

    container.appendChild(toastElem);

    setTimeout(() => {
        toastElem.classList.remove("opacity-0", "translate-y-2");
    }, 20);

    const removeToast = () => {
        toastElem.classList.add("opacity-0", "translate-y-2");
        setTimeout(() => {
            if (toastElem.parentNode) {
                toastElem.parentNode.removeChild(toastElem);
            }
        }, 300);
    };

    closeBtn.addEventListener("click", removeToast);
    if (duration > 0) {
        setTimeout(removeToast, duration);
    }
}

// 4. Sistema de Modais em substituição a alert() e confirm() nativos
function showCustomModal({ title = "Aviso do Sistema", content = "", type = "info", confirmText = "Entendido", cancelText = null, onConfirm = null }) {
    const modal = document.getElementById("system-modal");
    if (!modal) return;

    const titleElem = document.getElementById("system-modal-title");
    const contentElem = document.getElementById("system-modal-content");
    const iconElem = document.getElementById("system-modal-icon");
    const iconContainer = document.getElementById("system-modal-icon-container");
    const btnConfirm = document.getElementById("system-modal-btn-confirm");
    const btnCancel = document.getElementById("system-modal-btn-cancel");
    const card = document.getElementById("system-modal-card");

    titleElem.innerText = title;
    contentElem.innerHTML = content;
    btnConfirm.innerText = confirmText;

    if (type === "error" || type === "danger") {
        iconContainer.className = "w-10 h-10 rounded-full flex items-center justify-center bg-rose-100 text-rose-600 dark:bg-rose-900/50 dark:text-rose-300";
        iconElem.className = "fas fa-exclamation-triangle text-lg";
        btnConfirm.className = "px-5 py-2 text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md transition";
    } else if (type === "success") {
        iconContainer.className = "w-10 h-10 rounded-full flex items-center justify-center bg-emerald-100 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-300";
        iconElem.className = "fas fa-check text-lg";
        btnConfirm.className = "px-5 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md transition";
    } else {
        iconContainer.className = "w-10 h-10 rounded-full flex items-center justify-center bg-sky-100 text-sky-600 dark:bg-sky-900/50 dark:text-sky-300";
        iconElem.className = "fas fa-info-circle text-lg";
        btnConfirm.className = "px-5 py-2 text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 rounded-xl shadow-md transition";
    }

    if (cancelText) {
        btnCancel.innerText = cancelText;
        btnCancel.classList.remove("hidden");
    } else {
        btnCancel.classList.add("hidden");
    }

    const closeModal = () => {
        modal.classList.add("opacity-0");
        if (card) card.classList.add("scale-95");
        setTimeout(() => {
            modal.classList.add("hidden");
        }, 200);
    };

    btnConfirm.onclick = () => {
        closeModal();
        if (typeof onConfirm === "function") onConfirm();
    };

    btnCancel.onclick = closeModal;
    modal.onclick = (e) => {
        if (e.target === modal) closeModal();
    };

    modal.classList.remove("hidden");
    setTimeout(() => {
        modal.classList.remove("opacity-0");
        if (card) card.classList.remove("scale-95");
    }, 10);
}

window.customAlert = (msg, title = "Atenção") => {
    showCustomModal({ title, content: msg, type: "info" });
};

window.customConfirm = (msg, onConfirm, title = "Confirmação Necessária") => {
    showCustomModal({
        title,
        content: msg,
        type: "warning",
        confirmText: "Sim, Confirmar",
        cancelText: "Cancelar",
        onConfirm
    });
};

/**
 * 5. Inserção de Texto na Posição do Cursor (Teclado Químico)
 */
function insertTextAtCursor(input, text) {
    if (!input) return;
    const start = input.selectionStart || input.value.length;
    const end = input.selectionEnd || input.value.length;
    const val = input.value;
    input.value = val.substring(0, start) + text + val.substring(end);
    input.selectionStart = input.selectionEnd = start + text.length;
    input.focus();
    input.dispatchEvent(new Event('input', { bubbles: true }));
}

/**
 * 6. Configuração do Teclado Químico e Caracteres Especiais (Subscritos/Sobrescritos)
 */
function initChemicalKeyboard() {
    // Identifica o input atualmente ativo (fórmula estequiométrica ou massa molar)
    let activeInput = document.getElementById("formula-input");

    const formulaInput = document.getElementById("formula-input");
    const massaInput = document.getElementById("massa-formula-input");

    if (formulaInput) {
        formulaInput.addEventListener("focus", () => { activeInput = formulaInput; });
    }
    if (massaInput) {
        massaInput.addEventListener("focus", () => { activeInput = massaInput; });
    }

    // Botões de caracteres (Subscritos, Sobrescritos e Símbolos)
    document.querySelectorAll(".chem-key-btn").forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const char = btn.getAttribute("data-char");
            if (!char) return;
            const target = activeInput || formulaInput;
            insertTextAtCursor(target, char);
        });
    });

    // Pílulas de Elementos Rápidos Clicáveis
    document.querySelectorAll(".draggable-elem").forEach(pill => {
        pill.addEventListener("click", () => {
            const sym = pill.getAttribute("data-elem");
            if (!sym) return;
            const target = activeInput || formulaInput;
            insertTextAtCursor(target, sym);
            showToast("info", "Elemento Inserido", `Símbolo ${sym} adicionado à fórmula!`, 2000);
        });
    });
}

/**
 * 7. Suporte a Drag & Drop de Elementos da Tabela Periódica para a Aba de Cálculo
 */
function setupDragAndDrop() {
    const dropZones = document.querySelectorAll(".formula-drop-zone");

    dropZones.forEach(zone => {
        const input = zone.querySelector("input");
        if (!input) return;

        zone.addEventListener("dragover", (e) => {
            e.preventDefault();
            e.dataTransfer.dropEffect = "copy";
            zone.classList.add("ring-4", "ring-sky-400/50", "border-sky-500", "bg-sky-50/60", "dark:bg-sky-950/40");
        });

        zone.addEventListener("dragleave", (e) => {
            if (!zone.contains(e.relatedTarget)) {
                zone.classList.remove("ring-4", "ring-sky-400/50", "border-sky-500", "bg-sky-50/60", "dark:bg-sky-950/40");
            }
        });

        zone.addEventListener("drop", (e) => {
            e.preventDefault();
            zone.classList.remove("ring-4", "ring-sky-400/50", "border-sky-500", "bg-sky-50/60", "dark:bg-sky-950/40");

            const symbol = e.dataTransfer.getData("text/plain");
            if (symbol && symbol.trim().length > 0) {
                insertTextAtCursor(input, symbol.trim());
                showToast("success", "Elemento Movido!", `Elemento ${symbol.trim()} adicionado à caixa de cálculo!`);
            }
        });
    });

    // Torna as pílulas rápidas arrastáveis
    document.querySelectorAll(".draggable-elem").forEach(el => {
        el.setAttribute("draggable", "true");
        el.addEventListener("dragstart", (e) => {
            const sym = el.getAttribute("data-elem");
            e.dataTransfer.setData("text/plain", sym);
            e.dataTransfer.effectAllowed = "copy";
        });
    });
}

// 8. Inicialização
document.addEventListener("DOMContentLoaded", () => {
    initTheme();
    initMobileMenu();
    initChemicalKeyboard();
    setupDragAndDrop();
});
