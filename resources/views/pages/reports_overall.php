<?php
// reports_overall.php
?>

<div class="w-full mx-auto mb-4">
    <h1 class="text-3xl font-extrabold text-[#a61e22] tracking-tight">
        Overall Reports
    </h1>

    <p class="text-gray-500 mb-2 text-sm">
        View a comprehensive summary of total records by partner and GL code.
    </p>

    <!-- UI Header: Search on Left, Buttons on Right for Uniformity -->
    <div class="flex items-center justify-between mb-4">
        <!-- Search Section (Left) -->
        <div class="flex items-center gap-2">
            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Search</label>
            <input type="text" id="searchInput" placeholder="Search by partner or GL code..." 
                class="px-4 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-1 focus:ring-[#D50000] w-64 transition-all">
        </div>

        <!-- Download Section (Right) -->
        <div class="flex items-center gap-3">
            <button type="button"
                class="px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                <span>Download</span>
            </button>
        </div>
    </div>

    <div class="border border-gray-100 rounded-xl bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto thin-scrollbar">
            <table class="w-full text-center text-[11px] text-gray-700 border-collapse whitespace-nowrap">
                <thead class="bg-[#D50000] text-white sticky top-0 z-30">
                    <tr class="uppercase tracking-wider">
                        <th class="px-4 py-1.5 font-bold border-b border-[#8e191d]">Partner</th>
                        <th class="px-4 py-1.5 font-bold border-b border-[#8e191d]">GL Code</th>
                        <th class="px-4 py-1.5 font-bold border-b border-[#8e191d]">Amount</th>
                    </tr>
                </thead>
                <tbody id="reportTableBody" class="divide-y divide-gray-100 uppercase">
                    <tr>
                        <td colspan="3" class="p-8 text-center text-gray-400 italic font-medium">
                            No data yet.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-center gap-4 py-2 border-t border-gray-100 bg-gray-50/50">
            <button id="btn-prev" onclick="prevPage()"
                class="px-4 py-1 text-[11px] font-bold border border-gray-300 text-gray-600 rounded uppercase tracking-wider hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                Prev
            </button>
            <span id="pageInfo" class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">1 / 1</span>
            <button id="btn-next" onclick="nextPage()"
                class="px-4 py-1 text-[11px] font-bold border border-gray-300 text-gray-600 rounded uppercase tracking-wider hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                Next
            </button>
        </div>
    </div>
</div>

<script>
    let currentFilters = { search: '' };
    let currentPage = 1;
    let totalPages = 1;

    // Search Input Listener
    document.getElementById('searchInput').addEventListener('input', function(e) {
        currentFilters.search = e.target.value;
        currentPage = 1; // Reset to page 1
        fetchData();
    });

    async function fetchData() {
        const tbody = document.getElementById("reportTableBody");
        tbody.innerHTML = `<tr><td colspan="3" class="p-12 text-center text-gray-400 italic">Loading...</td></tr>`;

        let res = await fetch("/GLCS/public/index.php?api=1&action=report-overall", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ 
                search: currentFilters.search, 
                page: currentPage 
            })
        });

        let data = await res.json();
        if (!data.ok) return;

        totalPages = data.total_pages || 1;
        currentPage = data.page || 1;
        renderPage(data.data || []);
    }

    function renderPage(rows) {
        const tbody = document.getElementById("reportTableBody");
        if (!rows.length) {
            tbody.innerHTML = `<tr><td colspan="3" class="p-12 text-center text-gray-400 italic">No data found.</td></tr>`;
            return;
        }

        tbody.innerHTML = rows.map(row => `
            <tr class="hover:bg-red-50 transition-colors duration-150">
                <td class="px-4 py-1.5 font-medium">${row.partner ?? ''}</td>
                <td class="px-4 py-1.5 font-medium">${row.gl_code ?? ''}</td>
                <td class="px-4 py-1.5 font-medium">${row.amount ?? ''}</td>
            </tr>
        `).join('');

        document.getElementById("pageInfo").textContent = `${currentPage} / ${totalPages}`;
        document.getElementById("btn-prev").disabled = currentPage <= 1;
        document.getElementById("btn-next").disabled = currentPage >= totalPages;
    }

    function nextPage() { if (currentPage < totalPages) { currentPage++; fetchData(); } }
    function prevPage() { if (currentPage > 1) { currentPage--; fetchData(); } }
    
    fetchData(); // Initial load
</script>

<style>
    .thin-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
    .thin-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 10px; }
</style>