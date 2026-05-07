<div id="modal-gl-addgl" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all">
        
        <!-- Header: Reduced padding and gap -->
        <div class="p-4 pb-0 flex items-start gap-3">
            <div class="p-2 bg-red-50 rounded-full">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 leading-tight">Add New GL Code</h3>
                <p class="text-xs text-gray-500">Define a new General Ledger account and its hierarchy.</p>
            </div>
        </div>

        <!-- Form: Reduced padding and vertical spacing -->
        <form id="addGlForm" class="p-4 space-y-2">
            
            <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">GL Account</label>
                    <input type="text" name="gl_account" required placeholder="Input GL Code"
                        class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Account Title</label>
                    <input type="text" name="account_title" placeholder="Input Account Title"
                    class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Level 4</label>
                    <select name="level_4" id="level_4" class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                        <option value="">Select Level 4</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Level 3</label>
                    <select name="level_3" id="level_3" class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                        <option value="">Select Level 3</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Level 2</label>
                    <select name="level_2" id="level_2" class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                        <option value="">Select Level 2</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Level 1</label>
                    <select name="level_1" id="level_1" class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                        <option value="">Select Level 1</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">FS Account Type</label>
                    <select name="fs_account_type" id="fs_account_type" class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                        <option value="">Select FS Account Type</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Normal Balance</label>
                    <select name="normal_balance" id="normal_balance" class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                        <option value="">Select Normal Balance</option>
                    </select>
                </div>
            </div>

            <!-- Footer: Reduced margin-top and padding -->
            <div class="flex justify-end gap-3 mt-4 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeModal('gl-addgl')" 
                    class="px-5 py-1.5 text-[11px] font-bold uppercase tracking-wider text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all">
                    Cancel
                </button>
                <button type="submit" 
                    class="px-5 py-1.5 text-[11px] font-bold uppercase tracking-wider text-white bg-[#D50000] rounded-lg hover:bg-red-700 shadow-sm hover:shadow-md transition-all">
                    Save GL Code
                </button>
            </div>
        </form>
    </div>
</div>