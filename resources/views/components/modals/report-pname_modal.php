<div id="modal-partner" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white p-6 rounded-2xl shadow-2xl w-full max-w-lg transform transition-all duration-300 ease-out scale-95 opacity-0 animate-in fade-in zoom-in-95 fill-mode-forwards duration-300">
        
        <h2 class="text-xl font-bold text-[#0D2149]">Partner Name Search</h2>
        <hr class="my-4 border-gray-200">
        
        <div class="space-y-5 pt-2">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Partner Name</label>
                <input id="partnerInput" type="text" list="partner_list" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-[#a61e22] focus:border-transparent outline-none transition-all" placeholder="Type partner name...">
                <datalist id="partner_list">
                    <!-- Options will be populated by JavaScript -->
                </datalist>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Date From</label>
                <input id="dateFrom" type="date" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-[#a61e22] focus:border-transparent outline-none transition-all">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Date To</label>
                <input id="dateTo" type="date" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-[#a61e22] focus:border-transparent outline-none transition-all">
            </div>
        </div>

        <div class="flex gap-2 justify-end mt-8 border-t border-gray-100 pt-6">
            <button onclick="closeModal('partner')" class="px-4 py-2 text-gray-600 hover:text-gray-800 font-semibold">Cancel</button>
            <button onclick="searchPartner()" class="bg-[#a61e22] text-white px-6 py-2 rounded-lg font-semibold hover:bg-[#8e191d] transition-all shadow-md hover:shadow-lg">Search</button>
        </div>
    </div>
</div>