<div id="modal-userman" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-800">Edit User Account</h2>
            <button onclick="closeModal('userman')" class="text-gray-400 hover:text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="p-6 space-y-6">
            <div class="space-y-4">
                <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Edit Profile</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-500 uppercase mb-1">ID Number</label>
                        <input type="text" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-[#D50000] focus:outline-none" value="1">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-500 uppercase mb-1">Username</label>
                        <input type="text" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-[#D50000] focus:outline-none" value="admi1">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-500 uppercase mb-1">First Name</label>
                        <input type="text" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-[#D50000] focus:outline-none" value="ADMIN">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-500 uppercase mb-1">Middle Name</label>
                        <input type="text" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-[#D50000] focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-500 uppercase mb-1">Last Name</label>
                        <input type="text" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-[#D50000] focus:outline-none" value="ADMIN">
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            <div class="space-y-4">
                <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Change Status</h3>
                <div>
                    <select class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-[#D50000] focus:outline-none">
                        <option>Active</option>
                        <option>Disabled</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-2">
            <button onclick="closeModal('userman')" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-gray-600 hover:text-gray-800 transition-colors">Cancel</button>
            <button onclick="openModal('reset-password')" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-red-700 border border-red-200 rounded-lg hover:bg-red-50 transition-colors">Reset Password</button>
            <button onclick="closeModal('userman'); openModal('success'); setTimeout(() => closeModal('success'), 1000);" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-white bg-[#D50000] rounded-lg hover:bg-[#b00000] transition-colors shadow-sm">Save</button>
        </div>
    </div>
</div>