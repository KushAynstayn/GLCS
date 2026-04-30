<div id="modal-zone" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all duration-300 ease-out scale-95 opacity-0 animate-in fade-in zoom-in-95 fill-mode-forwards duration-300">
        
        <!-- Header Section -->
        <div class="p-4 pb-0 flex items-start gap-4">
            <div class="p-2 bg-red-50 rounded-full">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 leading-tight">Advanced Report Search</h3>
                <p class="text-xs text-gray-500">Filter and narrow down your report results.</p>
            </div>
        </div>

        <!-- Form Body -->
        <div class="p-4 space-y-2 pt-3">
            <div class="space-y-2">
                <!-- Location Row 1 -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Main Zone</label>
                        <select id="mainZone" class="border border-gray-300 rounded-lg p-2 text-sm w-full outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">Select Main Zone</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Zone</label>
                        <select id="zone" class="border border-gray-300 rounded-lg p-2 text-sm w-full outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">Select Zone</option>
                        </select>
                    </div>
                </div>

                <!-- Location Row 2 -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Region</label>
                        <select id="region" class="border border-gray-300 rounded-lg p-2 text-sm w-full outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">Select Region</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Area</label>
                        <select id="area" class="border border-gray-300 rounded-lg p-2 text-sm w-full outline-none focus:ring-1 focus:ring-red-500">
                            <option value="">Select Area</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Date Range -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Date From</label>
                    <input type="date" id="dateFrom" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-1 focus:ring-red-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Date To</label>
                    <input type="date" id="dateTo" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-1 focus:ring-red-500 outline-none transition-all">
                </div>
            </div>

            <!-- Account/Partner Search -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">GL Account</label>
                    <input id="glInput" list="gl_list" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-1 focus:ring-red-500 outline-none transition-all" placeholder="Search or pick GL Code...">
                    <datalist id="gl_list"></datalist>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Partner Details</label>
                    <input id="partnerInput" list="partner_list" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-1 focus:ring-red-500 outline-none transition-all" placeholder="Search Partner...">
                    <datalist id="partner_list"></datalist>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="flex gap-2 justify-end p-4 mt-1 border-t border-gray-100">
            <button onclick="cancelFilters()" class="px-5 py-2 text-[11px] font-bold uppercase tracking-wider text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all">
                Cancel
            </button>
            <button onclick="applyFilters()" 
            class="px-5 py-2 text-[11px] font-bold uppercase tracking-wider text-white bg-[#D50000] rounded-lg hover:bg-red-700 transition-all shadow-sm">
                Search
            </button>
        </div>
    </div>
</div>