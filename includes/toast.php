<!-- Componente de Toast Notifications (Regra: Mensagens de erro e sucesso via TOAST) -->
<div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col space-y-3 pointer-events-none w-80 max-w-full">
</div>

<template id="toast-template">
    <div class="toast-item pointer-events-auto flex items-start p-4 rounded-xl shadow-2xl border text-sm transition-all transform duration-300 translate-y-2 opacity-0">
        <div class="toast-icon flex-shrink-0 mr-3 mt-0.5 text-lg"></div>
        <div class="flex-1">
            <h4 class="toast-title font-semibold text-sm"></h4>
            <p class="toast-message text-xs opacity-90 mt-0.5 leading-relaxed"></p>
        </div>
        <button type="button" class="toast-close ml-2 text-current opacity-60 hover:opacity-100 focus:outline-none">
            <i class="fas fa-times"></i>
        </button>
    </div>
</template>
