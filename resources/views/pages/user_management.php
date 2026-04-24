<?php include __DIR__ . '/../components/modals/adduser_modal.php'; ?>

<div class="max-w-7xl mx-auto mb-16">
    <h1 class="text-3xl font-extrabold text-[#a61e22] tracking-tight">User Management</h1>
    <p class="text-gray-500 mb-6 text-sm">Manage user accounts and statuses</p>

    <div class="flex items-end justify-between mb-8">
        <div class="flex gap-4">
            <div class="flex flex-col gap-1">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Search</label>
                <input type="text" placeholder="Search by name, ID or username..." class="px-4 py-2 text-xs border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-1 focus:ring-[#D50000] w-64 transition-all">
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</label>
                <select class="px-4 py-2 text-xs border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-1 focus:ring-[#D50000] transition-all">
                    <option>All</option>
                    <option>Active</option>
                    <option>Inactive</option>
                </select>
            </div>
        </div>

        <button onclick="openModal('add-user')" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-red-700 bg-white border border-red-200 rounded-lg hover:bg-[#D50000] hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Add
        </button>
    </div>

    <?php include __DIR__ . '/../components/modals/userman_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/reset-password_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/success_modal.php'; ?>

    <div class="border border-gray-100 rounded-xl bg-white shadow-sm overflow-hidden">
        <table class="w-full text-left text-[10px] text-gray-600 border-collapse">
            <thead class="bg-[#D50000] border-b border-[#8e191d]">
                <tr class="text-white uppercase tracking-wider">
                    <th class="px-2 py-3 font-semibold">No.</th>
                    <th class="px-2 py-3 font-semibold">ID Number</th>
                    <th class="px-2 py-3 font-semibold">Username</th>
                    <th class="px-2 py-3 font-semibold">First Name</th>
                    <th class="px-2 py-3 font-semibold">Middle Name</th>
                    <th class="px-2 py-3 font-semibold">Last Name</th>
                    <th class="px-2 py-3 font-semibold">Last Online</th>
                    <th class="px-2 py-3 font-semibold">Date Modified</th>
                    <th class="px-2 py-3 font-semibold">Role</th>
                    <th class="px-2 py-3 font-semibold">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">

                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $index => $user): ?>
                        <tr onclick="openModal('userman')" class="cursor-pointer hover:bg-red-50/50 transition-colors">

                            <td class="px-2 py-3"><?= $index + 1 ?></td>
                            <td class="px-2 py-3"><?= htmlspecialchars($user['id']) ?></td>
                            <td class="px-2 py-3"><?= htmlspecialchars($user['username']) ?></td>
                            <td class="px-2 py-3"><?= htmlspecialchars($user['first_name'] ?? '') ?></td>
                            <td class="px-2 py-3"><?= htmlspecialchars($user['middle_name'] ?? '') ?></td>
                            <td class="px-2 py-3"><?= htmlspecialchars($user['last_name'] ?? '') ?></td>
                            <td class="px-2 py-3"><?= htmlspecialchars($user['last_online'] ?? '') ?></td>
                            <td class="px-2 py-3"><?= htmlspecialchars($user['updated_at'] ?? '') ?></td>
                            <td class="px-2 py-3"><?= htmlspecialchars($user['role_name'] ?? 'User') ?></td>
                            <td class="px-2 py-3"><?= htmlspecialchars($user['status'] ?? 'Active') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center py-4 text-gray-400">
                            No users found
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>

        <div class="flex items-center justify-center gap-4 py-3 border-t border-gray-100 bg-gray-50/50">
            <button class="px-3 py-1 text-[10px] font-semibold text-gray-600 bg-white border border-gray-200 rounded hover:border-red-200 hover:text-red-600 transition-colors shadow-sm uppercase tracking-wider">
                Prev
            </button>
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                1 / 1
            </span>
            <button class="px-3 py-1 text-[10px] font-semibold text-gray-600 bg-white border border-gray-200 rounded hover:border-red-200 hover:text-red-600 transition-colors shadow-sm uppercase tracking-wider">
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
</style>