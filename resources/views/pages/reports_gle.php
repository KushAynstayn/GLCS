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

<script>
    let currentFilters = {};
    let currentPage = 1;
    let totalPages = 1;

    // NEW: Dropdown Toggle Function
    function toggleDownloadDropdown() {
        const menu = document.getElementById('downloadDropdownMenu');
        menu.classList.toggle('hidden');
    }

    // UPDATED: Handle Download and connect to DownloadController.php
    function downloadReport(type) {
        // Convert the currentFilters object into a URL query string
        const queryString = new URLSearchParams({
            api: 'gl-download',
            type: type,
            source: 'report_extraction',
            ...currentFilters
        }).toString();

        // Redirect to the download API endpoint
        window.location.href = `index.php?${queryString}`;
        
        document.getElementById('downloadDropdownMenu').classList.add('hidden');
    }

    // NEW: Close dropdown when clicking outside
    window.addEventListener('click', function(e) {
        const container = document.getElementById('downloadDropdownContainer');
        const menu = document.getElementById('downloadDropdownMenu');
        if (menu && container && !container.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });

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
            branch: document.getElementById('branchInput').value || '',
            transaction_type: document.getElementById('transactionTypeInput').value || '',
            currency: document.getElementById('currencyInput').value || '',
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

        updateFilterUI(); // Update the badges
        fetchData();       // use stored filters
        closeModal('zone');
        resetFiltersUI();  // safe now
    }


    // MODALS
    function openModal(id) {
        resetFiltersUI(); // FORCE CLEAN STATE EVERY OPEN
        document.getElementById('modal-' + id).classList.remove('hidden');

        loadAreas();
    }


    function resetFiltersUI() {
        document.getElementById('mainZone').value = '';

        document.getElementById('zone').innerHTML = `
            <option value="" disabled selected>Select Zone</option>
            <option value="">ALL</option>
        `;

        document.getElementById('region').innerHTML = `
            <option value="" disabled selected>Select Region</option>
            <option value="">ALL</option>
        `;

        loadAreas(); // 🔥 reload properly

        document.getElementById('dateFrom').value = '';
        document.getElementById('dateTo').value = '';
        document.getElementById('glInput').value = '';
        document.getElementById('partnerInput').value = '';

        document.getElementById('branchInput').value = '';
        document.getElementById('transactionTypeInput').value = '';
        document.getElementById('currencyInput').value = '';
    }

    function closeModal(id) {
        document.getElementById('modal-' + id).classList.add('hidden');
        
    }


    function cancelFilters() {
        resetFiltersUI();
        closeModal('zone');
    }

    // UPDATED: UI function for displaying active filters
    function updateFilterUI() {
        const container = document.getElementById('activeFiltersContainer');
        container.innerHTML = '';
        
        let hasFilters = false;
        const labels = {
            partner: 'Partner',
            gl_code: 'GL Code',
            date_from: 'From',
            date_to: 'To',
            main_zone: 'Main Zone',
            zone: 'Zone',
            region: 'Region',
            area: 'Area',
            branch: 'Branch',
            transaction_type: 'Transaction Type',
            currency: 'Currency'
        };

        Object.keys(currentFilters).forEach(key => {
            if (currentFilters[key] && key !== 'page') {
                hasFilters = true;
                const span = document.createElement('span');
                span.className = "px-2 py-1 bg-red-50 text-[10px] font-bold text-red-700 border border-red-100 rounded-md uppercase";
                span.textContent = `${labels[key] || key}: ${currentFilters[key]}`;
                container.appendChild(span);
            }
        });

        if (!hasFilters) {
            container.innerHTML = '<span class="text-xs text-gray-400 italic">No filters applied</span>';
        }
    }

    // TRIGGERED BY THE SEARCH BUTTON
    function searchPartner() {
        // Save current filters so pagination knows what we are searching for
        currentFilters.partner = document.getElementById('partnerInput').value;
        currentFilters.dateFrom = document.getElementById('dateFrom').value;
        currentFilters.dateTo = document.getElementById('dateTo').value;
        
        // Always reset to page 1 on a new search
        currentPage = 1; 
        updateFilterUI();
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
        const creditDisplay = document.getElementById("totalCreditDisplay");

        let totalCredit = 0;

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
            creditDisplay.textContent = "0.00";
            return;
        }

        tbody.innerHTML = rows.map(row => {
            // Accumulate total credit for this page
            const val = parseFloat(row.credit) || 0;
            totalCredit += val;

            return `
            <tr class="group relative row-fluid-transition border-b border-gray-50 bg-white uppercase hover:bg-red-100/60 transition-all duration-300">
                <!-- The First Cell (Contains the Piano Key) -->
                <td class="px-6 py-2 text-[11px] font-bold relative group-hover:translate-x-1 transition-transform duration-300">
                    <!-- The Piano Key Accent -->
                    <div class="absolute left-0 top-0 bottom-0 w-[4px] bg-[#D50000] scale-y-0 group-hover:scale-y-100 transition-transform duration-300 origin-center"></div>
                    
                    ${formatDate(row.datetime)}
                </td>
                
                <td class="px-6 py-2 font-bold group-hover:translate-x-1 transition-transform duration-300">${row.gl_code ?? ''}</td>
                <td class="px-6 py-2 font-bold">${row.gl_desc ?? ''}</td>
                <td class="px-6 py-2 font-bold">${row.desc ?? ''}</td>
                <td class="px-6 py-2 font-bold">${row.reference ?? ''}</td>
                <td class="px-6 py-2 font-bold">${row.entry_number ?? ''}</td>
                <td class="px-6 py-2 font-bold">${row.currency ?? ''}</td>
                <td class="px-6 py-2 font-bold group-hover:text-[#D50000] transition-colors">${row.debit ?? ''}</td>
                <td class="px-6 py-2 font-bold group-hover:text-[#D50000] transition-colors">${row.credit ?? ''}</td>
                <td class="px-6 py-2 font-bold">${row.transaction_type ?? ''}</td>
                <td class="px-6 py-2 font-bold">${row.branch_id ?? ''}</td>
                <td class="px-6 py-2 font-bold">${row.cost_center ?? ''}</td>
                <td class="px-6 py-2 font-bold">${row.item ?? ''}</td>
            </tr>
        `}).join('');

        // Update Total Credit display
        creditDisplay.textContent = totalCredit.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

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



    async function loadBranches() {
        let res = await fetch("/GLCS/public/index.php?api=1&action=branches");
        let data = await res.json();

        if (!data.ok || !data.data) return;

        let list = document.getElementById("branch_list");
        list.innerHTML = "";

        data.data.forEach(b => {
            let opt = document.createElement("option");
            opt.value = b;
            list.appendChild(opt);
        });
    }

    loadBranches();


    async function loadTransactionTypes() {
        let res = await fetch("/GLCS/public/index.php?api=1&action=transaction-types");
        let data = await res.json();

        if (!data.ok || !data.data) return;

        let list = document.getElementById("transaction_type_list");
        list.innerHTML = "";

        data.data.forEach(t => {
            let opt = document.createElement("option");
            opt.value = t;
            list.appendChild(opt);
        });
    }

    loadTransactionTypes();


     
    async function loadMainZones() {
        let res = await fetch("/GLCS/public/index.php?api=1&action=main-zones");
        let data = await res.json();

        let select = document.getElementById("mainZone");
        select.innerHTML = `
            <option value="">Select Main Zone</option>
            <option value="ALL">ALL</option>
        `;

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

        zone.innerHTML = `
            <option value="" disabled selected>Select Zone</option>
            <option value="">ALL</option>
        `;

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

        region.innerHTML = `
            <option value="" disabled selected>Select Region</option>
            <option value="">ALL</option>
        `;

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

        // 🔥 Proper structure: placeholder + ALL + data
        area.innerHTML = `
            <option value="" disabled selected>Select Area</option>
            <option value="">ALL</option>
        `;

        if (!data.ok || !data.data) return;

        data.data.forEach(a => {
            let opt = document.createElement("option");
            opt.value = a;
            opt.textContent = a;
            area.appendChild(opt);
        });
    }


    document.getElementById("mainZone").addEventListener("change", function () {
        let val = this.value;

        if (val === "ALL") {
            // 🔥 Proper ALL cascade
            document.getElementById("zone").innerHTML = `
                <option value="ALL" selected>ALL</option>
            `;

            document.getElementById("region").innerHTML = `
                <option value="ALL" selected>ALL</option>
            `;

            return;
        }

        // Normal flow
        loadZones(val);

        document.getElementById("region").innerHTML = `
            <option value="" disabled selected>Select Region</option>
            <option value="ALL">ALL</option>
        `;
    });


    document.getElementById("zone").addEventListener("change", function () {
        let val = this.value;

        if (val === "ALL") {
            document.getElementById("region").innerHTML = `
                <option value="ALL" selected>ALL</option>
            `;
            return;
        }

        loadRegions(val);
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