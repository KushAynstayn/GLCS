<div id="modal-user-access" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all modal-content">
        
        <div class="p-6 pb-0 flex items-start gap-4">
            <div class="p-3 bg-red-50 rounded-full">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900" id="user-access-name">ADMIN ADMIN</h3>
                <p class="text-sm text-gray-500">Manage user permissions and GL code access levels.</p>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Assigned GL Codes</label>
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
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">GL Code Access</label>
                
                <input type="text" id="gl-search" 
                    oninput="filterGlCodes()" 
                    onfocus="document.getElementById('gl-dropdown').classList.remove('hidden')"
                    placeholder="Search or select GL code..." 
                    class="w-full px-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                
                <ul id="gl-dropdown" class="hidden absolute z-[60] w-full bg-white border border-gray-200 mt-1 max-h-48 overflow-y-auto rounded-lg shadow-xl">
                    <li onclick="selectGlCode('100001')" class="cursor-pointer px-3 py-2 text-sm hover:bg-gray-50 transition-colors">100001</li>
                    <li onclick="selectGlCode('100002')" class="cursor-pointer px-3 py-2 text-sm hover:bg-gray-50 transition-colors">100002</li>
                    <li onclick="selectGlCode('100003')" class="cursor-pointer px-3 py-2 text-sm hover:bg-gray-50 transition-colors">100003</li>
                    <li onclick="selectGlCode('100004')" class="cursor-pointer px-3 py-2 text-sm hover:bg-gray-50 transition-colors">100004</li>
                    <li onclick="selectGlCode('100005')" class="cursor-pointer px-3 py-2 text-sm hover:bg-gray-50 transition-colors">100005</li>
                    <li onclick="selectGlCode('100006')" class="cursor-pointer px-3 py-2 text-sm hover:bg-gray-50 transition-colors">100006</li>
                    <li onclick="selectGlCode('100007')" class="cursor-pointer px-3 py-2 text-sm hover:bg-gray-50 transition-colors">100007</li>
                </ul>
                
                <div id="tag-container" class="flex flex-wrap gap-2 pt-2">
                </div>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3 rounded-b-2xl">
            <button type="button" onclick="closeModal('user-access')" 
                class="px-6 py-2 text-xs font-bold uppercase tracking-wider text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all">
                Cancel
            </button>
            <button type="button" onclick="closeModal('user-access'); openModal('success'); setTimeout(() => closeModal('success'), 1000);" 
                class="px-6 py-2 text-xs font-bold uppercase tracking-wider text-white bg-[#D50000] rounded-lg hover:bg-red-700 shadow-md hover:shadow-lg transition-all">
                Save Changes
            </button>
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
    .overflow-y-auto::-webkit-scrollbar {
        width: 4px;
    }
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 4px;
    }
</style>