<div id="previewModal" class="fixed inset-0 hidden bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="bg-white w-[90%] max-h-[90vh] overflow-y-auto rounded-xl p-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Preview Data</h2>
            <button onclick="closePreviewModal()" class="text-gray-500">✕</button>
        </div>

        <div id="previewTables" class="space-y-6"></div>

        <div class="mt-6 flex justify-end gap-2">
            <button onclick="closePreviewModal()" class="px-4 py-2 border rounded">Cancel</button>
            <button onclick="openInsertModal()" class="px-4 py-2 bg-green-600 text-white rounded">
                Proceed to Insert
            </button>
        </div>

    </div>
</div>