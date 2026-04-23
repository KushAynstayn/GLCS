<div id="modal-reset-password" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm overflow-hidden border border-gray-100">
        <div class="px-6 pt-6 pb-2 flex justify-center">
            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-red-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
        </div>

        <div class="px-6 py-4 text-center">
            <h2 class="text-lg font-bold text-gray-800 mb-2">Reset Password</h2>
            <p class="text-xs text-gray-500">This will reset the user's password to the default format. This action cannot be undone.</p>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-center gap-3">
            <button onclick="closeModal('reset-password')" class="px-6 py-2 text-xs font-bold uppercase tracking-wider text-gray-600 hover:text-gray-800 transition-colors">Cancel</button>
            <button onclick="closeModal('reset-password'); openModal('success'); setTimeout(() => closeModal('success'), 1000);" class="px-6 py-2 text-xs font-bold uppercase tracking-wider text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors shadow-sm">Okay</button>
        </div>
    </div>
</div>

<style>
    /* Bounce Animation for this specific modal */
    #modal-reset-password:not(.hidden) > div {
        animation: pop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
</style>