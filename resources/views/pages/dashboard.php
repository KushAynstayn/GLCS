<div class="max-w-7xl mx-auto mb-8">
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
                    <a href="#" class="block px-4 py-2 text-xs text-gray-600 hover:bg-red-50 hover:text-[#D50000] transition-colors">Day</a>
                    <a href="#" class="block px-4 py-2 text-xs text-gray-600 hover:bg-red-50 hover:text-[#D50000] transition-colors">Week</a>
                    <a href="#" class="block px-4 py-2 text-xs text-gray-600 hover:bg-red-50 hover:text-[#D50000] transition-colors">Month</a>
                    <a href="#" class="block px-4 py-2 text-xs text-gray-600 hover:bg-red-50 hover:text-[#D50000] transition-colors">Year</a>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Universal function to toggle dropdowns
    function toggleDropdown(id) {
        document.querySelectorAll('[id$="-dropdown"]').forEach(el => {
            if (el.id !== id) el.classList.add('hidden');
        });
        document.getElementById(id).classList.toggle('hidden');
    }

    // Function to apply selected dates
    function applyDate() {
        const fromInput = document.getElementById('from-date').value;
        const toInput = document.getElementById('to-date').value;
        const dateLabel = document.getElementById('date-label');

        if (fromInput && toInput) {
            // Helper to format date as "8 Feb 2024"
            const formatDate = (dateStr) => {
                const date = new Date(dateStr);
                return date.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
            };
            dateLabel.textContent = `${formatDate(fromInput)} - ${formatDate(toInput)}`;
        }
        
        // Close the dropdown
        toggleDropdown('date-dropdown');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        const isClickInside = e.target.closest('.relative');
        if (!isClickInside) {
            document.querySelectorAll('[id$="-dropdown"]').forEach(el => {
                el.classList.add('hidden');
            });
        }
    });
</script>