<div id="modal-userman" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
    <!-- Increased width to max-w-4xl for the 2-column layout -->
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl overflow-hidden transform transition-all flex flex-col max-h-[95vh]">
        
        <!-- Header -->
        <div class="p-4 pb-0 flex items-start gap-3">
            <div class="p-2 bg-red-50 rounded-full">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 leading-tight">Edit User Account</h3>
                <p class="text-xs text-gray-500">Update user profile information and access status.</p>
            </div>
        </div>

        <!-- Body: 2-Column Grid Layout -->
        <div class="p-4 flex-1 overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- ================= LEFT COLUMN ================= -->
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">ID Number</label>
                            <input id="edit_id_number" type="text" class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Username</label>
                            <input id="edit_username" type="text" class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">First Name</label>
                            <input id="edit_firstname" type="text" class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Middle Name</label>
                            <input id="edit_middlename" type="text" class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Last Name</label>
                            <input id="edit_lastname" type="text" class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Role</h3>
                        <select id="edit_role" class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none cursor-pointer">
                            <?php if (!empty($roles)): ?>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role['id'] ?>">
                                        <?= htmlspecialchars($role['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Change Status</h3>
                        <div>
                            <select id="edit_status" class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                                <option>Active</option>
                                <option>Disabled</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- ================= RIGHT COLUMN ================= -->
                <div class="flex flex-col h-full space-y-3">
                    
                    <div class="space-y-1">
                        <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Assign GL Codes</h3>
                        <input id="edit_gl_search"
                            type="text"
                            placeholder="Search GL Code..."
                            class="w-full px-3 py-1.5 text-xs border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none">

                        <div id="edit_gl_results"
                            class="border mt-1 rounded max-h-24 overflow-y-auto text-xs empty:hidden"></div>
                    </div>

                    <div class="space-y-1 flex flex-col flex-1">
                        <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            Assigned GL Codes
                        </h3>
                        <!-- Increased height and added flex-grow -->
                        <div id="edit_gl_tags_container" style="scrollbar-width: thin;"
                            class="flex flex-wrap content-start gap-2 p-3 bg-gray-50 border border-gray-200 rounded-lg h-[380px] overflow-y-auto">
                            <!-- GL tags will appear here -->
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="flex justify-end gap-2 p-4 pt-3 border-t border-gray-100 shrink-0">
            <button type="button" onclick="resetEditModal(); closeModal('userman')" 
                class="px-4 py-1.5 text-[11px] font-bold uppercase tracking-wider text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all">
                Cancel
            </button>
            <button type="button" onclick="resetUserPassword()"
                class="px-4 py-1.5 text-[11px] font-bold uppercase tracking-wider text-red-700 border border-red-200 rounded-lg hover:bg-red-50 transition-all">
                Reset Password
            </button>
            <button type="button" onclick="saveEditUser(); setTimeout(() => closeModal('success'), 1000);" 
                class="px-4 py-1.5 text-[11px] font-bold uppercase tracking-wider text-white bg-[#D50000] rounded-lg hover:bg-red-700 shadow-sm transition-all">
                Save
            </button>
        </div>
    </div>
</div>


