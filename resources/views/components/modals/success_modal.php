<div id="modal-success" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm p-8 text-center border border-gray-100">
        <div class="mx-auto w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-500 mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <h2 class="text-lg font-bold text-gray-800">Success!</h2>
        <p class="text-xs text-gray-500 mt-2">Changes saved successfully.</p>
    </div>
</div>

<style>
    #modal-success:not(.hidden) > div {
        animation: pop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
</style>