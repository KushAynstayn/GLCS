<div class="w-full px-4 mb-8">
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-[#a61e22] tracking-tight">Dashboard Overview</h1>
        <p class="text-gray-500 text-sm">Monitor your system performance and data activities in real-time.</p>
    </div>

    <div class="flex items-center justify-between gap-4">
        <div class="flex-1 max-w-sm">
            <input type="text" 
                placeholder="Search by keywords..." 
                class="w-full px-4 py-2 text-xs border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-1 focus:ring-[#D50000] transition-all">
        </div>

        <div class="flex items-center gap-3">
            <div class="relative">
                <button type="button" onclick="toggleDropdown('date-dropdown')" class="flex items-center gap-2 px-3 py-2 text-xs border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition-all cursor-pointer">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span id="date-label">8 Feb - 15 Feb 2024</span>
                </button>

                <div id="date-dropdown" class="hidden absolute right-0 mt-2 w-64 bg-white border border-gray-100 rounded-lg shadow-xl z-50 p-4 space-y-3">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase">From</label>
                        <input type="date" id="from-date" class="w-full px-2 py-1 text-xs border border-gray-200 rounded focus:ring-1 focus:ring-[#D50000] outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-gray-400 uppercase">To</label>
                        <input type="date" id="to-date" class="w-full px-2 py-1 text-xs border border-gray-200 rounded focus:ring-1 focus:ring-[#D50000] outline-none">
                    </div>
                    <button onclick="applyDate()" class="w-full py-2 bg-[#D50000] text-white text-[10px] font-bold uppercase rounded hover:bg-red-700 transition-colors">Apply</button>
                </div>
            </div>

            <div class="relative">
                <button onclick="toggleDropdown('filter-dropdown')" 
                    class="flex items-center gap-2 px-4 py-2 text-xs font-bold uppercase tracking-wider text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filter
                </button>

                <div id="filter-dropdown" class="hidden absolute right-0 mt-2 w-32 bg-white border border-gray-100 rounded-lg shadow-xl z-50 overflow-hidden">
                    <a href="javascript:void(0)" onclick="updateTrend('day')" class="block px-4 py-2 text-xs text-gray-600 hover:bg-red-50 hover:text-[#D50000] transition-colors">Day</a>
                    <a href="javascript:void(0)" onclick="updateTrend('week')" class="block px-4 py-2 text-xs text-gray-600 hover:bg-red-50 hover:text-[#D50000] transition-colors">Week</a>
                    <a href="javascript:void(0)" onclick="updateTrend('month')" class="block px-4 py-2 text-xs text-gray-600 hover:bg-red-50 hover:text-[#D50000] transition-colors">Month</a>
                    <a href="javascript:void(0)" onclick="updateTrend('year')" class="block px-4 py-2 text-xs text-gray-600 hover:bg-red-50 hover:text-[#D50000] transition-colors">Year</a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-6">
        <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="flex-1">
                <div class="flex items-center mb-1">
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2zm16 4H4v8h16V8z"></path></svg>
                        <span class="text-xs font-semibold">GL Accounts</span>
                    </div>
                </div>
                <div class="mt-1">
                    <div class="flex items-center gap-1 text-xs text-gray-500 mb-0.5">Overall GL codes accounts</div>
                    <div class="text-2xl font-extrabold text-gray-900">1,248</div>
                    <div id="trend-text" class="text-green-500 text-[11px] font-medium flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        15.43% Than last month
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-2 ml-4">
                <button onclick="openModal('gl-addgl')" class="flex items-center justify-center gap-2 px-4 py-2 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add
                </button>
                <button onclick="openModal('gl-importgl')" class="flex items-center justify-center gap-2 px-4 py-2 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Import
                </button>
            </div>
        </div>

        <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-sm flex items-center justify-between">
            <div class="flex-1">
                <div class="flex items-center mb-1">
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"></path></svg>
                        <span class="text-xs font-semibold">Partner Details</span>
                    </div>
                </div>
                <div class="mt-1">
                    <div class="flex items-center gap-1 text-xs text-gray-500 mb-0.5">Overall partner accounts</div>
                    <div class="text-2xl font-extrabold text-gray-900">85</div>
                    <div id="partner-trend-text" class="text-green-500 text-[11px] font-medium flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        5.2% Than last month
                    </div>
                </div>
            </div>
            <div class="ml-4">
                <a href="index.php?page=reports-overall" class="flex items-center justify-center gap-2 px-4 py-2 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 w-full">
                    <i class="fas fa-globe mr-2"></i> Reports
                </a>
            </div>
        </div>

        <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-sm h-[381px] flex flex-col lg:row-span-2">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2 text-gray-600">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
                    <span class="text-xs font-semibold">User Access</span>
                </div>
                <a href="index.php?page=user-management" class="text-[10px] font-bold uppercase tracking-wider text-red-700 hover:text-red-900 transition-colors">See More</a>
            </div>
            <div class="flex-1 overflow-y-auto pr-2 space-y-3 custom-scrollbar">
                <div class="text-[11px] text-gray-700">
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>Maria Josefina</span><span class="font-bold text-red-600">15 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>John Doe</span><span class="font-bold text-red-600">12 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>Alice Smith</span><span class="font-bold text-red-600">10 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>Bob Johnson</span><span class="font-bold text-red-600">8 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>Charlie Brown</span><span class="font-bold text-red-600">7 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>David Wilson</span><span class="font-bold text-red-600">6 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>Eva Martinez</span><span class="font-bold text-red-600">5 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>Frank Thomas</span><span class="font-bold text-red-600">5 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>Grace Lee</span><span class="font-bold text-red-600">4 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>Henry White</span><span class="font-bold text-red-600">4 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>Ivy Taylor</span><span class="font-bold text-red-600">3 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>Jack Harris</span><span class="font-bold text-red-600">3 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>Kelly Clark</span><span class="font-bold text-red-600">3 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>Leo Lewis</span><span class="font-bold text-red-600">2 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>Mia Robinson</span><span class="font-bold text-red-600">2 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>Noah Walker</span><span class="font-bold text-red-600">2 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>Olivia Hall</span><span class="font-bold text-red-600">2 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>Peter Allen</span><span class="font-bold text-red-600">1 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>Quinn Young</span><span class="font-bold text-red-600">1 GL</span></div>
                    <div class="flex justify-between py-1 border-b border-gray-50"><span>Riley King</span><span class="font-bold text-red-600">1 GL</span></div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-sm lg:col-span-2 relative">
            <h3 class="text-xs font-bold text-gray-500 uppercase mb-4">Activity Overview</h3>
            
            <div id="chart-tooltip" class="fixed hidden bg-gray-800 text-white text-[10px] px-2 py-1 rounded shadow-lg z-50 pointer-events-none"></div>

            <div id="graph-container" class="flex items-end h-32 gap-6 pb-4 border-b border-gray-50 overflow-x-auto">
                <div class="flex flex-col justify-between h-full text-[10px] text-gray-400 shrink-0">
                    <span>100</span><span>50</span><span>0</span>
                </div>
                <div id="bars-wrapper" class="flex items-end gap-4 flex-1 h-full ml-4 min-w-[400px]">
                </div>
            </div>
            
            <div class="flex gap-4 mt-4 text-[10px] text-gray-500">
                <div class="flex items-center gap-1"><span class="w-3 h-3 bg-red-600 rounded-sm"></span> GL Accounts</div>
                <div class="flex items-center gap-1"><span class="w-3 h-3 bg-red-300 rounded-sm"></span> Partners</div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../components/modals/gl-addgl_modal.php'; ?>
<?php include __DIR__ . '/../components/modals/gl-importgl_modal.php'; ?>

<script>
    const chartData = {
        day: [
            { label: 'Mon', gl: 45, pr: 30 }, { label: 'Tue', gl: 55, pr: 40 }, { label: 'Wed', gl: 30, pr: 20 },
            { label: 'Thu', gl: 70, pr: 50 }, { label: 'Fri', gl: 80, pr: 60 }, { label: 'Sat', gl: 40, pr: 30 }, { label: 'Sun', gl: 20, pr: 15 }
        ],
        week: [
            { label: 'Wk 1', gl: 60, pr: 40 }, { label: 'Wk 2', gl: 80, pr: 60 }, 
            { label: 'Wk 3', gl: 50, pr: 35 }, { label: 'Wk 4', gl: 75, pr: 55 }
        ],
        month: [
            { label: 'Jan', gl: 75, pr: 55 }, { label: 'Feb', gl: 90, pr: 70 }, { label: 'Mar', gl: 65, pr: 45 },
            { label: 'Apr', gl: 80, pr: 60 }, { label: 'May', gl: 55, pr: 40 }, { label: 'Jun', gl: 70, pr: 50 },
            { label: 'Jul', gl: 60, pr: 45 }, { label: 'Aug', gl: 85, pr: 65 }, { label: 'Sep', gl: 40, pr: 30 },
            { label: 'Oct', gl: 50, pr: 35 }, { label: 'Nov', gl: 95, pr: 75 }, { label: 'Dec', gl: 85, pr: 65 }
        ],
        year: [
            { label: '2017', gl: 40, pr: 30 }, { label: '2018', gl: 50, pr: 40 }, { label: '2019', gl: 60, pr: 45 },
            { label: '2020', gl: 30, pr: 20 }, { label: '2021', gl: 70, pr: 55 }, { label: '2022', gl: 80, pr: 60 },
            { label: '2023', gl: 85, pr: 65 }, { label: '2024', gl: 95, pr: 75 }, { label: '2025', gl: 90, pr: 70 }, { label: '2026', gl: 88, pr: 68 }
        ]
    };

    function showTooltip(e, label, gl, pr) {
        const tooltip = document.getElementById('chart-tooltip');
        const content = `<strong>${label}</strong><br/>GL: ${gl}%<br/>Part: ${pr}%`;
        
        if (tooltip.innerHTML !== content || tooltip.classList.contains('hidden')) {
            tooltip.innerHTML = content;
        }
        
        // CHANGED: Use clientX/Y to match 'fixed' positioning
        tooltip.style.left = (e.clientX + 15) + 'px';
        tooltip.style.top = (e.clientY - 60) + 'px';
        tooltip.style.pointerEvents = 'none';
        tooltip.classList.remove('hidden');
    }

    function hideTooltip() {
        document.getElementById('chart-tooltip').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', () => updateTrend('month'));

    function toggleDropdown(id) {
        document.querySelectorAll('[id$="-dropdown"]').forEach(el => {
            if (el.id !== id) el.classList.add('hidden');
        });
        document.getElementById(id).classList.toggle('hidden');
    }

    function updateTrend(period) {
        const trendText = document.getElementById('trend-text');
        trendText.innerHTML = `<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> 15.43% Than last ${period}`;

        const partnerTrendText = document.getElementById('partner-trend-text');
        partnerTrendText.innerHTML = `<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> 5.2% Than last ${period}`;

        const wrapper = document.getElementById('bars-wrapper');
        const data = chartData[period] || chartData['month'];
        
        wrapper.innerHTML = ''; 
        
        data.forEach(item => {
            const barGroup = document.createElement('div');
            barGroup.className = 'flex flex-col items-center gap-2 flex-1 min-w-[20px]';
            barGroup.innerHTML = `
                <div class="flex gap-1 items-end h-20 w-full justify-center">
                    <div class="w-3 md:w-5 bg-red-600 rounded-t-sm transition-all duration-500 cursor-pointer" 
                         style="height: ${item.gl}%" 
                         onmouseover="showTooltip(event, '${item.label}', ${item.gl}, ${item.pr})" 
                         onmouseout="hideTooltip()"></div>
                    <div class="w-3 md:w-5 bg-red-300 rounded-t-sm transition-all duration-500 cursor-pointer" 
                         style="height: ${item.pr}%" 
                         onmouseover="showTooltip(event, '${item.label}', ${item.gl}, ${item.pr})" 
                         onmouseout="hideTooltip()"></div>
                </div>
                <span class="text-[9px] font-bold text-gray-500 uppercase truncate w-full text-center">${item.label}</span>
            `;
            wrapper.appendChild(barGroup);
        });
    }

    function applyDate() {
        const fromInput = document.getElementById('from-date').value;
        const toInput = document.getElementById('to-date').value;
        const dateLabel = document.getElementById('date-label');

        if (fromInput && toInput) {
            const formatDate = (dateStr) => {
                const date = new Date(dateStr);
                return date.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
            };
            dateLabel.textContent = `${formatDate(fromInput)} - ${formatDate(toInput)}`;
        }
        toggleDropdown('date-dropdown');
    }

    function openModal(id) {
        var modal = document.getElementById('modal-' + id);
        if (modal) {
            modal.classList.remove('hidden');
            modal.style.zIndex = '999999'; 
        }
    }

    function closeModal(id) {
        var modal = document.getElementById('modal-' + id);
        if (modal) modal.classList.add('hidden');
    }

    document.addEventListener('click', function(e) {
        const isClickInside = e.target.closest('.relative');
        
        if (!isClickInside) {
            document.querySelectorAll('[id$="-dropdown"]').forEach(el => {
                if (el.id.includes('dropdown')) {
                    el.classList.add('hidden');
                }
            });
        }
    });
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #D50000; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #a61e22; }
</style>