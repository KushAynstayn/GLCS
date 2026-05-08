<div id="insertModal" class="fixed inset-0 hidden bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl w-96">

        <h2 class="font-bold text-lg mb-2">Inserting Data</h2>

        <p class="text-sm text-gray-600 mb-4">
            Processing records...
        </p>

        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div id="insertProgressBar" class="bg-green-600 h-2.5 rounded-full" style="width:0%"></div>
        </div>

        <p id="insertProgressText" class="text-sm mt-2 text-gray-600">
            0%
        </p>

        <div class="mt-4 flex justify-end">
            <button onclick="closeInsertModal()" class="px-3 py-1 border rounded">
                Close
            </button>
        </div>

    </div>
</div>