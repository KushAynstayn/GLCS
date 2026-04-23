<?php
// reports_gle.php
?>

<div class="max-w-7xl mx-auto mb-16">
    <h1 class="text-3xl font-extrabold text-[#a61e22] tracking-tight">General Ledger Extraction Report</h1>
    <p class="text-gray-500 mb-6 text-sm">Filter by organization hierarchy, GL codes, or partner names to view detailed extraction records.</p>

    <div class="flex items-center justify-between mb-8">
        <div class="flex gap-3">
            <button onclick="openModal('zone')" id="btn-zone" class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 110 4H5a2 2 0 100 4h1a2 2 0 100-4V9a2 2 0 012-2M16 21v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="flex flex-col items-start">
                    <span>Zone</span>
                    <span class="text-[9px] opacity-75">Hierarchy</span>
                </div>
            </button>
            <button onclick="openModal('gl')" id="btn-gl" class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <div class="flex flex-col items-start">
                    <span>GL Code</span>
                    <span class="text-[9px] opacity-75">Exact code</span>
                </div>
            </button>
            <button onclick="openModal('partner')" id="btn-partner" class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <div class="flex flex-col items-start">
                    <span>Partner Name</span>
                    <span class="text-[9px] opacity-75">Lookup</span>
                </div>
            </button>
        </div>

        <button class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-red-700 bg-white border border-red-200 rounded-lg hover:bg-[#D50000] hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Download
        </button>
    </div>

    <?php include __DIR__ . '/../components/modals/report-zone_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/report-glcode_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/report-pname_modal.php'; ?>

    <div class="border border-gray-100 rounded-xl bg-white shadow-sm overflow-hidden">
        <table class="w-full text-left text-[10px] text-gray-600 border-collapse">
            <thead class="bg-[#D50000] border-b border-[#8e191d]">
                <tr class="text-white uppercase tracking-wider">
                    <th class="px-2 py-3 font-semibold">Date Time</th>
                    <th class="px-2 py-3 font-semibold">GL Code</th>
                    <th class="px-2 py-3 font-semibold">GL Description</th>
                    <th class="px-2 py-3 font-semibold">Description</th>
                    <th class="px-2 py-3 font-semibold">Reference</th>
                    <th class="px-2 py-3 font-semibold">Entry Number</th>
                    <th class="px-2 py-3 font-semibold">Currency</th>
                    <th class="px-2 py-3 font-semibold">Debit</th>
                    <th class="px-2 py-3 font-semibold">Credit</th>
                    <th class="px-2 py-3 font-semibold">Transaction Type</th>
                    <th class="px-2 py-3 font-semibold">Branch ID</th>
                    <th class="px-2 py-3 font-semibold">Branch Name</th>
                    <th class="px-2 py-3 font-semibold">Item</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <tr>
                    <td colspan="13" class="p-8 text-center text-gray-400 italic">No data yet.</td>
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
        document.getElementById('modal-' + id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById('modal-' + id).classList.add('hidden');
    }
</script>

<style>
    /* Centralized animation style for all modals */
    #modal-zone:not(.hidden) > div,
    #modal-gl:not(.hidden) > div,
    #modal-partner:not(.hidden) > div {
        animation: pop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    @keyframes pop {
        0% { opacity: 0; transform: scale(0.95); }
        100% { opacity: 1; transform: scale(1); }
    }
</style>