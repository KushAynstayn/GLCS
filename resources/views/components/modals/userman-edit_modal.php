<div id="modal-userman" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">
        
        <div class="p-6 pb-0 flex items-start gap-4">
            <div class="p-3 bg-red-50 rounded-full">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Edit User Account</h3>
                <p class="text-sm text-gray-500">Update user profile information and access status.</p>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <div class="space-y-4">
                
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">ID Number</label>
                        <input type="text" class="w-full px-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all" value="1">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Username</label>
                        <input type="text" class="w-full px-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all" value="admi1">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">First Name</label>
                        <input type="text" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all" value="ADMIN">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Middle Name</label>
                        <input type="text" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Last Name</label>
                        <input type="text" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all" value="ADMIN">
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Change Status</h3>
                <div>
                    <select class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                        <option>Active</option>
                        <option>Disabled</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-4 pt-4 pb-6 px-6 border-t border-gray-100">
            <button type="button" onclick="closeModal('userman')" 
                class="px-6 py-2 text-xs font-bold uppercase tracking-wider text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all">
                Cancel
            </button>
            <button type="button" onclick="openModal('reset-password')" 
                class="px-6 py-2 text-xs font-bold uppercase tracking-wider text-red-700 border border-red-200 rounded-lg hover:bg-red-50 transition-all">
                Reset Password
            </button>
            <button type="button" onclick="closeModal('userman'); openModal('success'); setTimeout(() => closeModal('success'), 1000);" 
                class="px-6 py-2 text-xs font-bold uppercase tracking-wider text-white bg-[#D50000] rounded-lg hover:bg-red-700 shadow-md hover:shadow-lg transition-all">
                Save
            </button>
        </div>
    </div>
</div>