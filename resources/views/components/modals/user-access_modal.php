<div id="modal-user-access" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg border border-gray-100 modal-content">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center rounded-t-xl">
            <h2 class="text-lg font-bold text-gray-800" id="user-access-name">ADMIN ADMIN</h2>
        </div>

        <div class="p-6 space-y-6">
            <div class="space-y-2">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Assigned GL Codes</label>
                <div class="max-h-20 overflow-y-auto p-3 border border-gray-100 rounded-lg bg-gray-50 shadow-inner">
                    <div class="flex flex-wrap gap-2">
                        <?php for($i = 1; $i <= 20; $i++): ?>
                            <div class="flex items-center gap-1 px-3 py-1 text-[10px] font-bold text-gray-600 bg-white rounded-full border border-gray-200">
                                1000<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <div class="space-y-4 relative">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">GL Code Access</label>
                
                <input type="text" id="gl-search" 
                    oninput="filterGlCodes()" 
                    onfocus="document.getElementById('gl-dropdown').classList.remove('hidden')"
                    placeholder="Search or select GL code..." 
                    class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-[#D50000] focus:outline-none">
                
                <ul id="gl-dropdown" class="hidden absolute z-50 w-full bg-white border border-gray-200 mt-1 max-h-48 overflow-y-auto rounded-lg shadow-lg">
                    <li onclick="selectGlCode('100001')" class="cursor-pointer px-3 py-2 text-sm hover:bg-red-50 hover:text-red-600 transition-colors">100001</li>
                    <li onclick="selectGlCode('100002')" class="cursor-pointer px-3 py-2 text-sm hover:bg-red-50 hover:text-red-600 transition-colors">100002</li>
                    <li onclick="selectGlCode('100003')" class="cursor-pointer px-3 py-2 text-sm hover:bg-red-50 hover:text-red-600 transition-colors">100003</li>
                    <li onclick="selectGlCode('100004')" class="cursor-pointer px-3 py-2 text-sm hover:bg-red-50 hover:text-red-600 transition-colors">100004</li>
                    <li onclick="selectGlCode('100005')" class="cursor-pointer px-3 py-2 text-sm hover:bg-red-50 hover:text-red-600 transition-colors">100005</li>
                    <li onclick="selectGlCode('100006')" class="cursor-pointer px-3 py-2 text-sm hover:bg-red-50 hover:text-red-600 transition-colors">100006</li>
                    <li onclick="selectGlCode('100007')" class="cursor-pointer px-3 py-2 text-sm hover:bg-red-50 hover:text-red-600 transition-colors">100007</li>
                </ul>
                
                <div id="tag-container" class="flex flex-wrap gap-2 pt-2">
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3 rounded-b-xl">
            <button onclick="closeModal('user-access')" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-gray-600 hover:text-gray-800 transition-colors">Cancel</button>
            <button onclick="closeModal('user-access'); openModal('success'); setTimeout(() => closeModal('success'), 1000);" class="px-6 py-2 text-xs font-bold uppercase tracking-wider text-white bg-[#D50000] rounded-lg hover:bg-[#b00000] transition-colors shadow-sm">Save</button>
        </div>
    </div>
</div>

<script>
    // Search Filter Logic
    function filterGlCodes() {
        const input = document.getElementById('gl-search').value.toLowerCase();
        const dropdown = document.getElementById('gl-dropdown');
        const items = dropdown.getElementsByTagName('li');
        
        dropdown.classList.remove('hidden');
        
        for (let i = 0; i < items.length; i++) {
            const txt = items[i].textContent || items[i].innerText;
            if (txt.toLowerCase().indexOf(input) > -1) {
                items[i].style.display = "";
            } else {
                items[i].style.display = "none";
            }
        }
    }

    // Selection Logic
    function selectGlCode(val) {
        const container = document.getElementById('tag-container');
        
        // Prevent duplicates
        if (document.getElementById('tag-' + val)) return;

        const tag = document.createElement('div');
        tag.id = 'tag-' + val;
        tag.className = 'flex items-center gap-1 px-3 py-1 text-[10px] font-bold text-red-700 bg-red-100 rounded-full border border-red-200';
        tag.innerHTML = `${val} <button onclick="this.parentElement.remove()" class="ml-1 hover:text-red-900"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>`;
        container.appendChild(tag);
        
        // Reset Search Input and hide dropdown
        document.getElementById('gl-search').value = '';
        document.getElementById('gl-dropdown').classList.add('hidden');
    }

    // Hide dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('gl-dropdown');
        const searchInput = document.getElementById('gl-search');
        if (e.target !== searchInput && e.target !== dropdown) {
            dropdown.classList.add('hidden');
        }
    });
</script>

<style>
    #modal-user-access:not(.hidden) .modal-content {
        animation: pop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
    @keyframes pop {
        0% { opacity: 0; transform: scale(0.95); }
        100% { opacity: 1; transform: scale(1); }
    }
    /* Custom scrollbar for containers */
    .overflow-y-auto::-webkit-scrollbar {
        width: 4px;
    }
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 4px;
    }
</style>