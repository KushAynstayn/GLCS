<?php
// reports_gle.php
?>

<div class="max-w-7xl mx-auto mb-16">
    <h1 class="text-3xl font-extrabold text-[#a61e22] tracking-tight">
        General Ledger Extraction Report
    </h1>

    <p class="text-gray-500 mb-6 text-sm">
        Filter by organization hierarchy, GL codes, or partner names to view detailed extraction records.
    </p>

    <div class="flex items-center justify-between mb-8">
        <div class="flex gap-3">

            <button onclick="openModal('zone')" id="btn-zone"
                class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-3">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>

                <div class="flex flex-col items-start">
                    <span>Filter</span>
                    <span class="text-[9px] opacity-75">Search Data</span>
                </div>
            </button>

            <button class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                <div class="flex flex-col items-start">
                    <span>Download</span>
                    <span class="text-[9px] opacity-75">Export Data</span>
                </div>
            </button>
        </div>
    </div>

    <?php include __DIR__ . '/../components/modals/report-filter_modal.php'; ?>

    <div class="border border-gray-100 rounded-xl bg-white shadow-sm overflow-hidden">

        <div class="overflow-x-auto thin-scrollbar border border-gray-100 rounded-xl shadow-sm">
    
        <table class="w-full text-center text-[11px] text-gray-700 border-collapse whitespace-nowrap">
            <thead class="bg-[#D50000] text-white sticky top-0 z-30">
                <tr class="uppercase tracking-wider">
                    <th class="px-4 py-3 font-bold border-b border-[#8e191d]">Date Time</th>
                    <th class="px-4 py-3 font-bold border-b border-[#8e191d]">GL Code</th>
                    <th class="px-4 py-3 font-bold border-b border-[#8e191d]">GL Description</th>
                    <th class="px-4 py-3 font-bold border-b border-[#8e191d]">Description</th>
                    <th class="px-4 py-3 font-bold border-b border-[#8e191d]">Reference</th>
                    <th class="px-4 py-3 font-bold border-b border-[#8e191d]">Entry Number</th>
                    <th class="px-4 py-3 font-bold border-b border-[#8e191d]">Currency</th>
                    <th class="px-4 py-3 font-bold border-b border-[#8e191d]">Debit</th>
                    <th class="px-4 py-3 font-bold border-b border-[#8e191d]">Credit</th>
                    <th class="px-4 py-3 font-bold border-b border-[#8e191d]">Transaction Type</th>
                    <th class="px-4 py-3 font-bold border-b border-[#8e191d]">Branch ID</th>
                    <th class="px-4 py-3 font-bold border-b border-[#8e191d]">Cost Center</th>
                    <th class="px-4 py-3 font-bold border-b border-[#8e191d]">Item</th>
                </tr>
            </thead>
        </table>

        <div class="max-h-[450px] overflow-y-auto no-scrollbar">
            <table class="w-full text-center text-[11px] text-gray-700 border-collapse whitespace-nowrap">
                <tbody id="reportTableBody" class="divide-y divide-gray-100">
                    <tr>
                        <td colspan="13" class="p-12 text-center text-gray-400 italic font-medium">
                            No data yet.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

        <div class="flex items-center justify-center gap-4 py-4 border-t border-gray-100 bg-gray-50/50">
            <button id="btn-prev" onclick="prevPage()"
                class="px-4 py-1.5 text-[11px] font-bold border border-gray-300 text-gray-600 rounded uppercase tracking-wider hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                Prev
            </button>

            <span id="pageInfo" class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                1 / 1
            </span>

            <button id="btn-next" onclick="nextPage()"
                class="px-4 py-1.5 text-[11px] font-bold border border-gray-300 text-gray-600 rounded uppercase tracking-wider hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                Next
            </button>
        </div>

    </div>
</div>

<script>
    let currentFilters = { partner: '', dateFrom: '', dateTo: '' };
    let currentPage = 1;
    let totalPages = 1;

    // MODALS
    function openModal(id) {
        document.getElementById('modal-' + id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById('modal-' + id).classList.add('hidden');
    }

    // TRIGGERED BY THE SEARCH BUTTON
    function searchPartner() {
        // Save current filters so pagination knows what we are searching for
        currentFilters.partner = document.getElementById('partnerInput').value;
        currentFilters.dateFrom = document.getElementById('dateFrom').value;
        currentFilters.dateTo = document.getElementById('dateTo').value;
        
        // Always reset to page 1 on a new search
        currentPage = 1; 
        fetchData();
        closeModal('partner');
    }

    // THE MAIN FETCH FUNCTION (Handles both Search and Pagination)
    async function fetchData() {
        const tbody = document.getElementById("reportTableBody");
        tbody.innerHTML = `<tr><td colspan="13" class="p-12 text-center text-gray-400 italic">Loading...</td></tr>`;

        let res = await fetch("/GLCS/public/index.php?api=1&action=report-partner", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ 
                partner: currentFilters.partner, 
                date_from: currentFilters.dateFrom, 
                date_to: currentFilters.dateTo,
                page: currentPage // Sending the requested page to PHP!
            })
        });

        let data = await res.json();

        if (!data.ok) {
            alert("Failed to load report");
            return;
        }

        // Update global pagination state from PHP response
        totalPages = data.total_pages || 1;
        currentPage = data.page || 1;

        renderPage(data.data || []);
    }

    // RENDER THE DATA TO THE TABLE
    function renderPage(rows) {
        const tbody = document.getElementById("reportTableBody");
        const btnPrev = document.getElementById("btn-prev");
        const btnNext = document.getElementById("btn-next");

        if (!rows.length) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="13" class="p-12 text-center text-gray-400 italic">
                        No data found.
                    </td>
                </tr>
            `;
            document.getElementById("pageInfo").textContent = `1 / 1`;
            btnPrev.disabled = true;
            btnNext.disabled = true;
            return;
        }

        tbody.innerHTML = rows.map(row => `
            <tr class="hover:bg-red-50 transition-colors duration-150">
                <td class="px-4 py-3 font-medium">${formatDate(row.datetime)}</td>
                <td class="px-4 py-3 font-medium">${row.gl_code ?? ''}</td>
                <td class="px-4 py-3 font-medium">${row.gl_desc ?? ''}</td>
                <td class="px-4 py-3 font-medium">${row.desc ?? ''}</td>
                <td class="px-4 py-3 font-medium">${row.reference ?? ''}</td>
                <td class="px-4 py-3 font-medium">${row.entry_number ?? ''}</td>
                <td class="px-4 py-3 font-medium">${row.currency ?? ''}</td>
                <td class="px-4 py-3 font-medium">${row.debit ?? ''}</td>
                <td class="px-4 py-3 font-medium">${row.credit ?? ''}</td>
                <td class="px-4 py-3 font-medium">${row.transaction_type ?? ''}</td>
                <td class="px-4 py-3 font-medium">${row.branch_id ?? ''}</td>
                <td class="px-4 py-3 font-medium">${row.cost_center ?? ''}</td>
                <td class="px-4 py-3 font-medium">${row.item ?? ''}</td>
            </tr>
        `).join('');

        // Update UI Page Info
        document.getElementById("pageInfo").textContent = `${currentPage} / ${totalPages}`;

        // Manage Pagination Button States
        btnPrev.disabled = currentPage <= 1;
        btnNext.disabled = currentPage >= totalPages;
    }

    // PAGINATION BUTTON ACTIONS
    function nextPage() {
        if (currentPage < totalPages) {
            currentPage++;
            fetchData(); // Fetch the next 20 from PHP
        }
    }

    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            fetchData(); // Fetch the previous 20 from PHP
        }
    }

    // 12-HOUR FORMAT FIX
    function formatDate(datetime) {
        if (!datetime) return '';
        let d = new Date(datetime);

        return d.toLocaleString('en-US', {
            month: 'short',
            day: '2-digit',
            year: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
    }

    // LOAD PARTNERS
    async function loadPartners() {
        let res = await fetch("/GLCS/public/index.php?api=1&action=partners");
        let data = await res.json();

        if (!data.ok || !data.data) return;

        let list = document.getElementById("partner_list");
        list.innerHTML = "";

        data.data.forEach(p => {
            let opt = document.createElement("option");
            opt.value = p;
            list.appendChild(opt);
        });
    }

    loadPartners();
</script>

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
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .no-scrollbar {
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
</style>