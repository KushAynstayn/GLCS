<div class="w-full mx-auto mb-4">
    <h1 class="text-3xl font-extrabold text-[#a61e22] tracking-tight">User Management</h1>
    <p class="text-gray-500 mb-2 text-sm">Manage user accounts and statuses</p>

    <div class="flex items-center justify-between mb-4">
        <!-- Search and Status moved to the left -->
        <div class="flex gap-6 items-center">
            <div class="flex items-center gap-2">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Search</label>
                <input type="text" placeholder="Search by name, ID or username..." class="px-4 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-1 focus:ring-[#D50000] w-64 transition-all">
            </div>
            <div class="flex items-center gap-2">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Status</label>
                <select class="px-4 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-1 focus:ring-[#D50000] transition-all">
                    <option>All</option>
                    <option>Active</option>
                    <option>Inactive</option>
                </select>
            </div>
        </div>

        <!-- Add Button moved to the right, made thinner, and description removed -->
        <div class="flex gap-3">
            <button onclick="openModal('add-user')" class="px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Add</span>
            </button>
        </div>
    </div>

    <?php include __DIR__ . '/../components/modals/userman-add_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/userman-edit_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/reset-password_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/success_modal.php'; ?>

    <div class="border border-gray-100 rounded-xl bg-white shadow-sm overflow-hidden flex flex-col">
        <!-- Scrollable Container with Fluid feel -->
        <div class="overflow-auto scrollbar-hide max-h-[440px]">
            <table class="w-full min-w-max text-center text-[11px] text-gray-700 border-collapse whitespace-nowrap">
                <thead class="bg-[#D50000] text-white sticky top-0 z-30 shadow-sm">
                    <tr class="uppercase tracking-wider">
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">No.</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">ID Number</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Username</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">First Name</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Middle Name</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Last Name</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Last Online</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Date Modified</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Role</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Status</th>
                    </tr>
                </thead>
                <tbody id="userTableBody" class="divide-y divide-gray-100 bg-white">
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $index => $user): ?>
                            <tr onclick="openModal('userman')" 
                                class="group relative row-fluid-transition cursor-pointer border-b border-gray-100 bg-white hover:bg-red-100/60">
                                
                                <!-- Column 1: Number + Piano Key Accent -->
                                <td class="px-6 py-2 font-bold relative group-hover:translate-x-1 transition-transform duration-300">
                                    <!-- The Piano Key Indicator -->
                                    <div class="absolute left-0 top-0 bottom-0 w-[4px] bg-[#D50000] scale-y-0 group-hover:scale-y-100 transition-transform duration-300 origin-center"></div>
                                    <?= $index + 1 ?>
                                </td>

                                <td class="px-6 py-2"><?= htmlspecialchars($user['id']) ?></td>
                                <td class="px-6 py-2 font-bold text-gray-800"><?= htmlspecialchars($user['username']) ?></td>
                                <td class="px-6 py-2"><?= htmlspecialchars($user['first_name'] ?? '') ?></td>
                                <td class="px-6 py-2"><?= htmlspecialchars($user['middle_name'] ?? '') ?></td>
                                <td class="px-6 py-2"><?= htmlspecialchars($user['last_name'] ?? '') ?></td>
                                <td class="px-6 py-2 italic text-gray-500"><?= htmlspecialchars($user['last_online'] ?? '') ?></td>
                                <td class="px-6 py-2"><?= htmlspecialchars($user['updated_at'] ?? '') ?></td>
                                
                                <td class="px-6 py-2">
                                    <span class="px-2 py-1 bg-gray-100 rounded text-[9px] font-bold uppercase tracking-tighter group-hover:bg-white transition-colors">
                                        <?= htmlspecialchars($user['role_name'] ?? 'User') ?>
                                    </span>
                                </td>

                                <td class="px-6 py-2">
                                    <span class="text-[10px] font-bold uppercase transition-colors duration-300 group-hover:text-red-700 <?= ($user['status'] ?? 'Active') === 'Active' ? 'text-green-600' : 'text-gray-400' ?>">
                                        <?= htmlspecialchars($user['status'] ?? 'Active') ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="p-12 text-center text-gray-400 italic font-medium">
                                No users found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="flex h-[40px] items-center justify-center gap-4 py-2 border-t border-gray-100 bg-gray-50/50">
            <button class="px-4 py-1 text-[11px] font-bold border border-gray-300 text-gray-600 rounded uppercase tracking-wider hover:bg-gray-200 disabled:opacity-50 transition-colors">
                Prev
            </button>
            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                1 / 1
            </span>
            <button class="px-4 py-1 text-[11px] font-bold border border-gray-300 text-gray-600 rounded uppercase tracking-wider hover:bg-gray-200 disabled:opacity-50 transition-colors">
                Next
            </button>
        </div>
    </div>
</div>

<script src="../resources/assets/js/add-user.js"></script>

<script>
    function openModal(id) {
        document.getElementById('modal-' + id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById('modal-' + id).classList.add('hidden');
    }
</script>

<style>
    /* Bounce Animation for modal content */
    #modal-userman:not(.hidden) > div {
        animation: pop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    @keyframes pop {
        0% { opacity: 0; transform: scale(0.95); }
        100% { opacity: 1; transform: scale(1); }
    }


    /* This hides the scrollbar across all browsers while keeping scroll functionality */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }


    /* Custom fluid transition */
    .row-fluid-transition {
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

</style>