<?php

$totalGLCodes = $totalGLCodes ?? 0;
$totalUsers = $totalUsers ?? 0;

$userGLAccess = $userGLAccess ?? [];
$recentImports = $recentImports ?? [];
$importsPerMonth = $importsPerMonth ?? [];

$from = $from ?? '';
$to = $to ?? '';


// Define targets for the progress bars
$glGoal = 1000;   // Example: bar is full if there are 1,000 codes
$userGoal = 100;  // Example: bar is full if there are 100 users

// Calculate Percentages (Clamp between 0 and 100)
$glPercentage = ($totalGLCodes > 0) ? min(($totalGLCodes / $glGoal) * 100, 100) : 0;
$userPercentage = ($totalUsers > 0) ? min(($totalUsers / $userGoal) * 100, 100) : 0;
?>


<div class="w-full px-4 mb-8">

    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-[#a61e22] tracking-tight">
            Dashboard Overview
        </h1>

        <p class="text-gray-500 text-sm">
            Monitor your system performance and data activities in real-time.
        </p>
    </div>

    <!-- DATE FILTER -->
    <div class="flex items-center justify-start gap-4">

        <div class="relative">

            <button
                type="button"
                onclick="toggleDropdown('date-dropdown')"
                class="flex items-center gap-2 px-3 py-2 text-xs border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition-all cursor-pointer">

                <svg class="w-4 h-4 text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>

                </svg>

                <span id="date-label">

                    <?php if (!empty($from) && !empty($to)): ?>

                        <?= date('d M Y', strtotime($from)) ?>
                        -
                        <?= date('d M Y', strtotime($to)) ?>

                    <?php else: ?>

                        Select Date Range

                    <?php endif; ?>

                </span>

            </button>

            <!-- DROPDOWN -->
            <div
                id="date-dropdown"
                class="hidden absolute left-0 mt-2 w-64 bg-white border border-gray-100 rounded-lg shadow-xl z-50 p-4 space-y-3">

                <div class="space-y-1">

                    <label class="text-[10px] font-bold text-gray-400 uppercase">
                        From
                    </label>

                    <input
                        type="date"
                        id="from-date"
                        class="w-full px-2 py-1 text-xs border border-gray-200 rounded focus:ring-1 focus:ring-[#D50000] outline-none">

                </div>

                <div class="space-y-1">

                    <label class="text-[10px] font-bold text-gray-400 uppercase">
                        To
                    </label>

                    <input
                        type="date"
                        id="to-date"
                        class="w-full px-2 py-1 text-xs border border-gray-200 rounded focus:ring-1 focus:ring-[#D50000] outline-none">

                </div>

                <button
                    onclick="applyDate()"
                    class="w-full py-2 bg-[#D50000] text-white text-[10px] font-bold uppercase rounded hover:bg-red-700 transition-colors">

                    Apply

                </button>

            </div>

        </div>

    </div>

    <!-- DASHBOARD GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-6">

        <!-- GL ACCOUNTS -->
        <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-sm flex items-center justify-between gap-4">

            <div class="flex-1 max-w-[calc(100%-180px)]">

                <div class="flex items-center justify-between mb-3">

                    <div class="flex items-center gap-2 text-gray-600">

                        <svg class="w-4 h-4"
                            fill="currentColor"
                            viewBox="0 0 24 24">

                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2zm16 4H4v8h16V8z">
                            </path>

                        </svg>

                        <span class="text-xs font-semibold uppercase tracking-[0.2em]">
                            GL Accounts
                        </span>

                    </div>

                    <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-red-700">
                        Live
                    </span>

                </div>

                <div class="text-sm text-gray-500 mb-2">
                    Overall GL Code Accounts
                </div>

                <div class="h-2 rounded-full bg-gray-100 overflow-hidden">
                    <div class="h-full bg-red-500 transition-all duration-500" 
                        style="width: <?= $glPercentage ?>%;"></div>
                </div>

            </div>

            <div class="text-right">

                <div class="text-4xl font-extrabold text-gray-900">
                    <?= number_format($totalGLCodes) ?>
                </div>

                <div class="text-xs uppercase tracking-[0.3em] text-gray-400 mt-1">
                    Total GL Codes
                </div>

            </div>

        </div>

        <!-- TOTAL USERS -->
        <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-sm flex items-center justify-between gap-4">

            <div class="flex-1 max-w-[calc(100%-140px)]">

                <div class="flex items-center justify-between mb-3">

                    <div class="flex items-center gap-2 text-gray-600">

                        <svg class="w-4 h-4"
                            fill="currentColor"
                            viewBox="0 0 24 24">

                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z">
                            </path>

                        </svg>

                        <span class="text-xs font-semibold uppercase tracking-[0.2em]">
                            Total Users
                        </span>

                    </div>

                    <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-red-700">
                        Active
                    </span>

                </div>

                <div class="text-sm text-gray-500 mb-2">
                    Overall Registered Users
                </div>

                <div class="h-2 rounded-full bg-gray-100 overflow-hidden">
                    <div class="h-full bg-red-500 transition-all duration-500" 
                        style="width: <?= $userPercentage ?>%;"></div>
                </div>

            </div>

            <div class="text-right">

                <div class="text-4xl font-extrabold text-gray-900">
                    <?= number_format($totalUsers) ?>
                </div>

                <div class="text-xs uppercase tracking-[0.3em] text-gray-400 mt-1">
                    User Accounts
                </div>

            </div>

        </div>

        <!-- USER GL ACCESS -->
        <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-sm h-[381px] flex flex-col lg:row-span-2">

            <div class="flex items-center justify-between mb-3">

                <div class="flex items-center gap-2 text-gray-600">

                    <svg class="w-4 h-4"
                        fill="currentColor"
                        viewBox="0 0 24 24">

                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z">
                        </path>

                    </svg>

                    <span class="text-xs font-semibold">
                        User GL Codes Access
                    </span>

                </div>

            </div>

            <div class="flex-1 overflow-y-auto pr-2 space-y-3 custom-scrollbar">

                <div class="text-[11px] text-gray-700">

                    <?php foreach ($userGLAccess as $user): ?>

                        <div class="flex justify-between py-1 border-b border-gray-50">

                            <span>
                                <?= htmlspecialchars($user['full_name']) ?>
                            </span>

                            <span class="font-bold text-red-600">
                                <?= $user['total_gl'] ?> GL
                            </span>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>

        </div>

        <!-- IMPORTS -->
        <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-sm lg:col-span-2 relative">

            <h3 class="text-xs font-bold text-gray-500 uppercase mb-4">
                Recent GLE Imports
            </h3>

            <div
                id="chart-tooltip"
                class="fixed hidden bg-gray-800 text-white text-[10px] px-2 py-1 rounded shadow-lg z-50 pointer-events-none">
            </div>

            <!-- GRAPH -->
            <div id="graph-container" class="flex items-end h-40 gap-6 pb-4 border-b border-gray-50 overflow-x-auto">
                <div class="flex flex-col justify-between h-24 mb-6 text-[10px] text-gray-400 shrink-0">
                    <span id="y-max">...</span>
                    <span id="y-mid">...</span>
                    <span>0</span>
                </div>

                <div id="bars-wrapper" class="flex items-end gap-4 flex-1 h-full ml-4 min-w-[400px]">
                    </div>
            </div>

            <!-- RECENT IMPORTS -->
            <div class="mt-5 border-t border-gray-100 pt-4">

                <h4 class="text-[11px] font-bold uppercase text-gray-500 mb-3">
                    Recent Imported Files
                </h4>

                <div class="space-y-2">

                    <?php foreach ($recentImports as $file): ?>

                        <div class="flex justify-between text-[11px]">

                            <span class="text-gray-700 truncate max-w-[70%]">
                                <?= htmlspecialchars($file['file_name']) ?>
                            </span>

                            <span class="text-gray-400">
                                <?= date('M d, Y h:i A', strtotime($file['created_at'])) ?>
                            </span>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

    const chartData = <?= json_encode($importsPerMonth) ?>;

    document.addEventListener('DOMContentLoaded', () => {

        updateTrend();

        document.getElementById('from-date').value =
            "<?= $from ?>";

        document.getElementById('to-date').value =
            "<?= $to ?>";
    });

    function toggleDropdown(id)
    {
        document.querySelectorAll('[id$="-dropdown"]').forEach(el => {

            if (el.id !== id) {
                el.classList.add('hidden');
            }
        });

        document.getElementById(id).classList.toggle('hidden');
    }

    function updateTrend() {
        const wrapper = document.getElementById('bars-wrapper');
        wrapper.innerHTML = '';

        if (chartData.length === 0) {
            wrapper.innerHTML = '<div class="text-gray-400 text-xs w-full text-center">No data available</div>';
            return;
        }

        // Find the highest value to set as 100% height
        const maxValue = Math.max(...chartData.map(item => parseInt(item.total_imports)), 0);

        chartData.forEach(item => {
            const value = parseInt(item.total_imports);
            // Calculate height. If max is 0, height is 0. 
            // We use a minimum height of 5% if value > 0 so the bar is always visible.
            const percentage = maxValue > 0 ? (value / maxValue) * 100 : 0;

            // Update Y-Axis labels based on the real data
            const yMax = document.getElementById('y-max');
            const yMid = document.getElementById('y-mid');

            if(yMax && yMid) {
                yMax.innerText = maxValue;
                yMid.innerText = Math.floor(maxValue / 2);
            }

            const barGroup = document.createElement('div');
            barGroup.className = 'flex flex-col items-center gap-2 flex-1 min-w-[40px]';

            barGroup.innerHTML = `
                <div class="flex items-end h-24 w-full justify-center group">
                    <div
                        class="w-8 bg-red-500 hover:bg-red-700 rounded-t-sm transition-all duration-700 ease-out cursor-pointer relative"
                        style="height: 0%;" 
                        onmouseover="showTooltip(event, '${item.month_name}', ${value})"
                        onmouseout="hideTooltip()">
                        
                        <span class="absolute -top-5 left-1/2 -translate-x-1/2 text-[9px] font-bold text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity">
                            ${value}
                        </span>
                    </div>
                </div>
                <span class="text-[9px] font-bold text-gray-500 uppercase truncate w-full text-center">
                    ${item.month_name}
                </span>
            `;

            wrapper.appendChild(barGroup);

            // Trigger animation after a short timeout so the height grows from 0 to percentage
            setTimeout(() => {
                barGroup.querySelector('.bg-red-500').style.height = `${percentage}%`;
            }, 100);
        });
    }

    function showTooltip(e, label, gl)
    {
        const tooltip =
            document.getElementById('chart-tooltip');

        const content =
            `<strong>${label}</strong><br/>Imports: ${gl}`;

        tooltip.innerHTML = content;

        tooltip.style.left = (e.clientX + 15) + 'px';
        tooltip.style.top = (e.clientY - 60) + 'px';

        tooltip.classList.remove('hidden');
    }

    function hideTooltip()
    {
        document.getElementById('chart-tooltip')
            .classList.add('hidden');
    }

    function applyDate()
    {
        const fromInput =
            document.getElementById('from-date').value;

        const toInput =
            document.getElementById('to-date').value;

        if (!fromInput || !toInput) {
            return;
        }

        const url =
            new URL(window.location.href);

        url.searchParams.set('page', 'dashboard');

        url.searchParams.set('from', fromInput);

        url.searchParams.set('to', toInput);

        window.location.href =
            url.toString();
    }

    document.addEventListener('click', function(e) {

        const isClickInside =
            e.target.closest('.relative');

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

    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #D50000;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #a61e22;
    }

</style>