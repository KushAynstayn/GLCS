<?php
// reports_gle.php
?>

<div class="w-full mx-auto mb-16">
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

    <div class="border border-gray-100 rounded-xl bg-white shadow-sm overflow-hidden flex flex-col">

        <div class="overflow-auto scrollbar-hide max-h-[468px]">
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
                        <th class="px-6 py-2 font-bold border-b border-[#8e191d]">Cost Center</th>
                        <th class="px-6 py-2 font-bold border-b border-[#8e191d]">Item</th>
                    </tr>
                </thead>

                <tbody id="reportTableBody" class="divide-y divide-gray-100 bg-white">
                    <tr>
                        <td colspan="13" class="p-12 text-center text-gray-400 italic font-medium">
                            No data yet.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex h-[45px] items-center justify-center gap-4 py-4 border-t border-gray-100 bg-gray-50/50">
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
    let currentFilters = {};
    let currentPage = 1;
    let totalPages = 1;


    function applyFilters() {
        currentPage = 1;

        const glRaw = document.getElementById('glInput').value.trim();

        currentFilters = {
            partner: document.getElementById('partnerInput').value,
            date_from: document.getElementById('dateFrom').value,
            date_to: document.getElementById('dateTo').value,
            main_zone: document.getElementById('mainZone').value,
            zone: document.getElementById('zone').value,
            region: document.getElementById('region').value,
            area: document.getElementById('area').value,
            page: currentPage
        };

        // ✅ GL parsing
        if (!glRaw) {
            currentFilters.gl_code = '';
        } else if (glRaw.includes(' - ')) {
            currentFilters.gl_code = glRaw.split(' - ')[0].trim();
        } else {
            currentFilters.gl_code = glRaw;
        }

        fetchData();       // use stored filters
        closeModal('zone');
        resetFiltersUI();  // safe now
    }


    // MODALS
    function openModal(id) {
        document.getElementById('modal-' + id).classList.remove('hidden');
    }


    function resetFiltersUI() {
        document.getElementById('mainZone').value = '';
        document.getElementById('zone').innerHTML = `<option value="">ALL</option>`;
        document.getElementById('region').innerHTML = `<option value="">ALL</option>`;
        document.getElementById('area').value = '';
        document.getElementById('dateFrom').value = '';
        document.getElementById('dateTo').value = '';
        document.getElementById('glInput').value = '';
        document.getElementById('partnerInput').value = '';
    }

    function closeModal(id) {
        document.getElementById('modal-' + id).classList.add('hidden');
        
    }


    function cancelFilters() {
        resetFiltersUI();
        closeModal('zone');
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

        // ✅ ALWAYS USE STORED FILTERS
        let payload = {
            ...currentFilters,
            page: currentPage
        };

        console.log("FINAL PAYLOAD:", payload);

        let res = await fetch("/GLCS/public/index.php?api=1&action=report-partner", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload)
        });

        let data = await res.json();

        console.log("API RESPONSE:", data);

        if (!data.ok) {
            alert("Failed to load report");
            return;
        }

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
            <tr class="group row-fluid-transition border-b border-gray-100 bg-white hover:bg-gradient-to-r hover:bg-red-100/50 hover:to-transparent">
                <td class="px-6 py-2 text-[11px] font-bold border-l-4 border-transparent group-hover:border-[#D50000] transition-all duration-300">
                    ${formatDate(row.datetime)}
                </td>
                <td class="px-6 py-3 font-bold group-hover:translate-x-1 transition-transform duration-300">${row.gl_code ?? ''}</td>
                <td class="px-6 py-3 font-bold">${row.gl_desc ?? ''}</td>
                <td class="px-6 py-3 font-bold">${row.desc ?? ''}</td>
                <td class="px-6 py-3 font-bold">${row.reference ?? ''}</td>
                <td class="px-6 py-3 font-bold">${row.entry_number ?? ''}</td>
                <td class="px-6 py-3 font-bold">${row.currency ?? ''}</td>
                <td class="px-6 py-3 font-bold group-hover:text-[#D50000] transition-colors">${row.debit ?? ''}</td>
                <td class="px-6 py-3 font-bold group-hover:text-[#D50000] transition-colors">${row.credit ?? ''}</td>
                <td class="px-6 py-3 font-bold">${row.transaction_type ?? ''}</td>
                <td class="px-6 py-3 font-bold">${row.cost_center ?? ''}</td>
                <td class="px-6 py-3 font-bold">${row.item ?? ''}</td>
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


    async function loadGLCodes() {
        let res = await fetch("/GLCS/public/index.php?api=1&action=glcodes");
        let data = await res.json();

        console.log("GL DATA:", data); // DEBUG

        let list = document.getElementById("gl_list");
        list.innerHTML = "";

        if (!data.ok || !data.data) return;

        data.data.forEach(gl => {
            let opt = document.createElement("option");
            opt.value = gl.gl_account + " - " + gl.account_title;
            list.appendChild(opt);
        });
    }

    // LOAD ON PAGE START
    loadGLCodes();
    


    async function loadMainZones() {
        let res = await fetch("/GLCS/public/index.php?api=1&action=main-zones");
        let data = await res.json();

        let select = document.getElementById("mainZone");
        select.innerHTML = `<option value="">ALL</option>`;

        data.data.forEach(z => {
            let opt = document.createElement("option");
            opt.value = z.main_zone_code;
            opt.textContent = z.main_zone_code;
            select.appendChild(opt);
        });
    }


    async function loadZones(mainZone) {
        let res = await fetch(`/GLCS/public/index.php?api=1&action=zones&main_zone=${mainZone}`);
        let data = await res.json();

        let zone = document.getElementById("zone");
        zone.innerHTML = `<option value="">ALL</option>`;

        data.data.forEach(z => {
            let opt = document.createElement("option");
            opt.value = z.zone_code;
            opt.textContent = z.zone_code;
            zone.appendChild(opt);
        });
    }


    async function loadRegions(zoneCode) {
        let res = await fetch(`/GLCS/public/index.php?api=1&action=regions&zone=${zoneCode}`);
        let data = await res.json();

        let region = document.getElementById("region");
        region.innerHTML = `<option value="">ALL</option>`;

        data.data.forEach(r => {
            let opt = document.createElement("option");
            opt.value = r.region_description;
            opt.textContent = r.region_description;
            region.appendChild(opt);
        });
    }


    async function loadAreas() {
        let res = await fetch("/GLCS/public/index.php?api=1&action=areas");
        let data = await res.json();

        let area = document.getElementById("area");
        area.innerHTML = `<option value="">ALL</option>`;

        data.data.forEach(a => {
            let opt = document.createElement("option");
            opt.value = a;
            opt.textContent = a;
            area.appendChild(opt);
        });
    }


    document.getElementById("mainZone").addEventListener("change", function () {
        let val = this.value;

        let zone = document.getElementById("zone");
        let region = document.getElementById("region");
        let area = document.getElementById("area");

        if (!val) {
            zone.innerHTML = `<option value="">ALL</option>`;
            region.innerHTML = `<option value="">ALL</option>`;
            area.value = "";
            return;
        }

        loadZones(val);
    });


    document.getElementById("zone").addEventListener("change", function () {
        let val = this.value;

        document.getElementById("region").innerHTML = `<option value="">ALL</option>`;

        if (val) loadRegions(val);
    });


    loadMainZones();
    loadAreas();

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