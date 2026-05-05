<div id="duplicateModal" class="fixed inset-0 hidden bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl w-96">

        <h2 class="font-bold text-lg mb-2 text-red-600">
            Duplicate File Detected
        </h2>

        <p class="text-sm text-gray-600 mb-4">
            This file was already imported. Do you want to override the existing data?
        </p>

        <div class="flex justify-end gap-2">
            <button onclick="cancelDuplicate()" class="px-4 py-2 border rounded">
                Cancel
            </button>

            <button onclick="confirmOverride()" class="px-4 py-2 bg-red-600 text-white rounded">
                Override
            </button>
        </div>

    </div>
</div>