<div id="duplicateModal" class="fixed inset-0 hidden bg-black/40 flex items-center justify-center">
    <div class="bg-white p-6 rounded-xl w-96">
        <h2 class="font-bold text-lg">Duplicate Check</h2>
        <p id="duplicateText" class="mt-2 text-sm text-gray-600"></p>

        <div class="mt-4 flex justify-end gap-2">
            <button onclick="closeDuplicateModal()" class="px-3 py-1 border">Cancel</button>
            <button onclick="confirmInsert()" class="px-3 py-1 bg-[#a61e22] text-white">
                Proceed
            </button>
        </div>
    </div>
</div>