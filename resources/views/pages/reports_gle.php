<?php
// reports_gle.php
?>

<div class="w-full mx-auto mb-4">
    <h1 class="text-3xl font-extrabold text-[#a61e22] tracking-tight">
        General Ledger Extraction Report
    </h1>

    <p class="text-gray-500 mb-2 text-sm">
        Filter by organization hierarchy, GL codes, or partner names to view detailed extraction records.
    </p>

    <div class="flex items-center justify-end mb-4">
        <div class="flex gap-3">

            <button onclick="openModal('zone')" id="btn-zone"
                class="px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-2">

                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>

                <span>Filter</span>
            </button>

            <!-- START: Modified Download Dropdown -->
            <div class="relative inline-block text-left" id="downloadDropdownContainer">
                <button onclick="toggleDownloadDropdown()" 
                    class="px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    <span>Download</span>
                </button>

                <div id="downloadDropdownMenu" class="hidden absolute right-0 mt-2 w-32 origin-top-right bg-white border border-gray-100 rounded-lg shadow-xl z-50 overflow-hidden">
                    <button onclick="downloadReport('excel')" class="w-full text-left px-4 py-2 text-xs font-bold uppercase text-gray-700 hover:bg-red-50 hover:text-[#a61e22] transition-colors flex items-center gap-2">
                         <span class="w-2 h-2 bg-green-500 rounded-full"></span> Excel
                    </button>
                    <button onclick="downloadReport('pdf')" class="w-full text-left px-4 py-2 text-xs font-bold uppercase text-gray-700 hover:bg-red-50 hover:text-[#a61e22] transition-colors flex items-center gap-2 border-t border-gray-50">
                        <span class="w-2 h-2 bg-red-500 rounded-full"></span> PDF
                    </button>
                </div>
            </div>
            <!-- END: Modified Download Dropdown -->
        </div>
    </div>

    <!-- ADDED: Filter Summary and Totals Containers -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <!-- Filter Info Container -->
        <div class="md:col-span-2 p-4 bg-white border border-gray-100 rounded-xl shadow-sm">
            <h3 class="text-[10px] uppercase font-bold text-gray-400 mb-2 tracking-widest">Active Filters</h3>
            <div id="activeFiltersContainer" class="flex flex-wrap gap-2">
                <span class="text-xs text-gray-400 italic">No filters applied</span>
            </div>
        </div>

        <!-- Total Credit Container -->
        <div class="p-4 bg-white border border-red-100 rounded-xl shadow-sm flex flex-col justify-center">
            <h3 class="text-[10px] uppercase font-bold text-red-400 mb-1 tracking-widest">Total Credit (Current Page)</h3>
            <div id="totalCreditDisplay" class="text-2xl font-black text-[#a61e22]">
                0.00
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../components/modals/report-filter_modal.php'; ?>

    <div class="border border-gray-100 rounded-xl bg-white shadow-sm overflow-hidden flex flex-col">

        <div class="overflow-auto scrollbar-hide max-h-[500px]">
            <table class="w-full min-w-max text-center text-[11px] text-gray-700 border-collapse whitespace-nowrap">
                <thead class="bg-[#D50000] text-white sticky top-0 z-30 shadow-sm">
                    <tr class="uppercase tracking-wider">
                        <th class="px-6 py-2 font-bold border-b border-[#8e191d]">Date Time</th>
                        <th class="px-6 py-2 font-bold border-b border-[#8e191d]">GL Code</th>
                        <th class="px-6 py-2 font-bold border-b border-[#8e191d]">GL Description</th>
                        <th class="px-6 py-2 font-bold border-b border-[#8e191d]">Description</th>
                        <th class="px-6 py-2 font-bold border-b border-[#8e191d]">Reference</th>
                        <th class="px-6 py-2 font-bold border-b border-[#8e191d]">Entry Number</th>
                        <th class="px-6 py-2 font-bold border-b border-[#8e191d]">Currency</th>
                        <th class="px-6 py-2 font-bold border-b border-[#8e191d]">Debit</th>
                        <th class="px-6 py-2 font-bold border-b border-[#8e191d]">Credit</th>
                        <th class="px-6 py-2 font-bold border-b border-[#8e191d]">Transaction Type</th>
                        <th class="px-6 py-2 font-bold border-b border-[#8e191d]">Branch ID</th>
                        <th class="px-6 py-2 font-bold border-b border-[#8e191d]">Cost Center</th>
                        <th class="px-6 py-2 font-bold border-b border-[#8e191d]">Item</th>
                    </tr>
                </thead>

                <!-- Added 'uppercase' class to handle all content formatting -->
                <tbody id="reportTableBody" class="divide-y divide-gray-100 bg-white uppercase">
                    <tr>
                        <td colspan="13" class="p-8 text-center text-gray-400 italic font-medium">
                            No data yet.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex h-[40px] items-center justify-center gap-4 py-2 border-t border-gray-100 bg-gray-50/50">
            <button id="btn-prev" onclick="prevPage()"
                class="px-4 py-1 text-[11px] font-bold border border-gray-300 text-gray-600 rounded uppercase tracking-wider hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                Prev
            </button>

            <span id="pageInfo" class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                1 / 1
            </span>

            <button id="btn-next" onclick="nextPage()"
                class="px-4 py-1 text-[11px] font-bold border border-gray-300 text-gray-600 rounded uppercase tracking-wider hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                Next
            </button>
        </div>

    </div>
</div>

<script src="../resources/assets/js/reports_gle.js"></script>


<style>
/* ORIGINAL + SAFE MERGED ANIMATION */
#modal-zone:not(.hidden) > div,
#modal-gl:not(.hidden) > div,
#modal-partner:not(.hidden) > div {
    animation: pop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
}

@keyframes pop {
    0% { opacity: 0; transform: scale(0.95); }
    100% { opacity: 1; transform: scale(1); }
}


/* Hide scrollbar for Chrome, Safari and Opera */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
    /* Optional: If you want a "Ghost" scrollbar that only appears on hover */
    .thin-scrollbar::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    .thin-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(0,0,0,0.1);
        border-radius: 10px;
    }
    .thin-scrollbar:hover::-webkit-scrollbar-thumb {
        background: rgba(0,0,0,0.2);
    }


    /* Custom fluid transition */
    .row-fluid-transition {
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

</style>