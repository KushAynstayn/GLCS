<div id="modal-zone" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all duration-300 ease-out scale-95 opacity-0 animate-in fade-in zoom-in-95 fill-mode-forwards duration-300">
        
        <div class="p-6 pb-0 flex items-start gap-4">
            <div class="p-3 bg-red-50 rounded-full">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Advanced Report Search</h3>
                <p class="text-sm text-gray-500">Filter and narrow down your report results.</p>
            </div>
        </div>

        <div class="p-6 space-y-4 pt-5">
            <div class="space-y-3">
                <div class="grid grid-cols-2 gap-4">
                    <select class="border border-gray-300 rounded-lg p-2.5 text-sm w-full outline-none focus:ring-1 focus:ring-red-500"><option>Select Main Zone</option></select>
                    <select class="border border-gray-300 rounded-lg p-2.5 text-sm w-full outline-none focus:ring-1 focus:ring-red-500"><option>Select Zone</option></select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <select class="border border-gray-300 rounded-lg p-2.5 text-sm w-full outline-none focus:ring-1 focus:ring-red-500"><option>Select Region</option></select>
                    <select class="border border-gray-300 rounded-lg p-2.5 text-sm w-full outline-none focus:ring-1 focus:ring-red-500"><option>Select Area</option></select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Date From</label>
                    <input type="date" id="dateFrom" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-1 focus:ring-red-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Date To</label>
                    <input type="date" id="dateTo" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-1 focus:ring-red-500 outline-none transition-all">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">GL Account</h3>
                    <input type="text" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-1 focus:ring-red-500 outline-none transition-all" placeholder="Search or pick GL Code...">
                </div>
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Partner Details</h3>
                    <input id="partnerInput" type="text" list="partner_list" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-1 focus:ring-red-500 outline-none transition-all" placeholder="Type partner name...">
                    <datalist id="partner_list"></datalist>
                </div>
            </div>
        </div>

        <div class="flex gap-3 justify-end p-6 mt-2 border-t border-gray-100">
            <button onclick="closeModal('zone')" class="px-6 py-2 text-xs font-bold uppercase tracking-wider text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all">
                Cancel
            </button>
            <button class="px-6 py-2 text-xs font-bold uppercase tracking-wider text-white bg-[#D50000] rounded-lg hover:bg-red-700 shadow-md hover:shadow-lg transition-all">
                Search
            </button>
        </div>
    </div>
</div>