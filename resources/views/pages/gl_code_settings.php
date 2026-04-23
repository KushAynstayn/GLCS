<?php
// gl_code_settings.php
?>

<div class="max-w-7xl mx-auto mb-16">
    <h1 class="text-3xl font-extrabold text-[#a61e22] tracking-tight">GL Code Settings</h1>
    <p class="text-gray-500 mb-6 text-sm">Manage user permissions and access levels</p>

    <div class="flex items-end justify-between mb-8">
        <div class="flex flex-col gap-1">
            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Search</label>
            <input type="text" placeholder="Search by GL code or description..." class="px-4 py-2 text-xs border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-1 focus:ring-[#D50000] w-64 transition-all">
        </div>

        <button class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-red-600 hover:border-red-200 transition-all duration-300 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            Reset All
        </button>
    </div>

    <?php include __DIR__ . '/../components/modals/user-access_modal.php'; ?>
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
                    <th class="px-2 py-3 font-semibold">Access Level</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <tr onclick="openModal('user-access')" class="cursor-pointer hover:bg-red-50/50 transition-colors">
                    <td class="px-2 py-3">379</td>
                    <td class="px-2 py-3">1</td>
                    <td class="px-2 py-3">admi1</td>
                    <td class="px-2 py-3">ADMIN</td>
                    <td class="px-2 py-3"></td>
                    <td class="px-2 py-3">ADMIN</td>
                    <td class="px-2 py-3">-1</td>
                </tr>
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

<script>
    function openModal(id) {
        var modal = document.getElementById('modal-' + id);
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closeModal(id) {
        var modal = document.getElementById('modal-' + id);
        if (modal) {
            modal.classList.add('hidden');
        }
    }
</script>