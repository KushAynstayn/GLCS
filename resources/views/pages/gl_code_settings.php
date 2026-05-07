<?php
// gl_code_settings.php
?>

<div class="w-full mx-auto mb-4">
    <h1 class="text-3xl font-extrabold text-[#a61e22] tracking-tight">GL Settings</h1>
    <p class="text-gray-500 mb-2 text-sm">Configure and manage General Ledger accounts, hierarchies, and structures.</p>

    <div class="flex items-center justify-between mb-4">
        <!-- Search Group (Moved to the Left) -->
        <div class="flex items-center gap-2">
            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Search</label>
            <input type="text" placeholder="Search by GL code or description..." class="px-4 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-1 focus:ring-[#D50000] w-64 transition-all">
        </div>

        <!-- Action Buttons (Moved to the Right and made thinner) -->
        <div class="flex gap-3">
            <button onclick="openModal('gl-addgl')" class="px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Add</span>
            </button>

            <button onclick="openModal('gl-importgl')" class="px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                <span>Import</span>
            </button>
        </div>
    </div>

    <?php include __DIR__ . '/../components/modals/gl-useraccess_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/gl-addgl_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/gl-importgl_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/success_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/fetch_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/preview_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/insert_modal.php'; ?>

    <div class="border border-gray-100 rounded-xl bg-white shadow-sm overflow-hidden flex flex-col">
        <div class="overflow-auto scrollbar-hide max-h-[440px]">
            <table class="w-full min-w-max text-center text-[11px] text-gray-700 border-collapse whitespace-nowrap">
                <thead class="bg-[#D50000] text-white sticky top-0 z-30 shadow-sm">
                    <tr class="uppercase tracking-wider">
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">GL Account</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Account Title</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Level 4</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Level 3</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Level 2</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Level 1</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">FS Account Type</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Normal Balance</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Status</th>
                    </tr>
                </thead>

                <tbody id="glTableBody" class="divide-y divide-gray-100 bg-white uppercase">
                    <tr>
                        <td colspan="9" class="p-12 text-center text-gray-400 italic font-medium">
                            No data yet.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex h-[40px] items-center justify-center gap-4 py-2 border-t border-gray-100 bg-gray-50/50">
            <button id="btn-prev-gl" onclick="prevPage()"
                class="px-4 py-1 text-[11px] font-bold border border-gray-300 text-gray-600 rounded uppercase tracking-wider hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                Prev
            </button>

            <span id="pageInfo" class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                1 / 1
            </span>

            <button id="btn-next-gl" onclick="nextPage()"
                class="px-4 py-1 text-[11px] font-bold border border-gray-300 text-gray-600 rounded uppercase tracking-wider hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                Next
            </button>
        </div>
    </div>
</div>

<script src="../resources/assets/js/gl_settings.js"></script>


<style>
/* Modal Animation */
#modal-user-access:not(.hidden) > div,
#modal-gl-addgl:not(.hidden) > div,
#modal-gl-importgl:not(.hidden) > div {
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