<div id="fetchModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm hidden transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
        <div class="flex items-center gap-4">
            <div class="bg-[#a61e22] p-3 rounded-full text-white flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">Extracting Data</h3>
                <p class="text-sm text-gray-500">Streaming Excel files and preparing JSON previews...</p>
            </div>
        </div>

        <div class="mt-6">
            <div class="flex justify-between text-sm mb-2">
                <span id="fileProgressText" class="font-medium text-gray-700">File count: 0/0</span>
                <span id="progressPercent" class="font-medium text-gray-700">0%</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                <div id="progressBar" class="bg-[#a61e22] h-2.5 rounded-full transition-all duration-300" style="width: 0%"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function showFetchModal(totalFiles) {
        const modal = document.getElementById('fetchModal');
        const modalContent = document.getElementById('modalContent');

        // reset progress
        document.getElementById('fileProgressText').textContent =
            `File count: 0/${totalFiles}`;
        document.getElementById('progressPercent').textContent = "0%";
        document.getElementById('progressBar').style.width = "0%";

        // show backdrop
        modal.classList.remove('hidden');

        // FORCE reflow (critical fix)
        void modal.offsetWidth;

        // animate modal in
        modalContent.classList.remove('opacity-0', 'scale-95');
        modalContent.classList.add('opacity-100', 'scale-100');
    }

    function closeFetchModal() {
        const modal = document.getElementById('fetchModal');
        const modalContent = document.getElementById('modalContent');

        modalContent.classList.remove('opacity-100', 'scale-100');
        modalContent.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }
    
</script>