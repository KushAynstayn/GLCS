<?php
$currentPage = $_GET['page'] ?? 'dashboard';
?>

<div id="sidebar" class="w-16 hover:w-64 group transition-all duration-300 sidebar-bg text-white h-full flex flex-col overflow-x-hidden relative">
    <div class="h-16 flex items-center justify-start px-5 border-b border-white/10 gap-3">
        <i class="fas fa-university text-xl shrink-0"></i>
        <h2 class="text-lg font-bold tracking-wider opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">GLCS</h2>
    </div>

    <div class="flex-1 overflow-y-auto overflow-x-hidden p-3">
        <ul class="space-y-2">
            
            <li>
                <a href="index.php?page=dashboard" 
                   class="nav-item p-3 rounded-lg flex items-center justify-start gap-3 <?= $currentPage == 'dashboard' ? 'nav-active' : '' ?>">
                    <i class="fas fa-th-large w-5 shrink-0"></i>
                    <span class="opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap w-0 group-hover:w-auto overflow-hidden">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="index.php?page=gle-import" 
                   class="nav-item p-3 rounded-lg flex items-center justify-start gap-3 <?= $currentPage == 'gle-import' ? 'nav-active' : '' ?>">
                    <i class="fas fa-file-import w-5 shrink-0"></i>
                    <span class="opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap w-0 group-hover:w-auto overflow-hidden">GLE Import</span>
                </a>
            </li>

            <li>
                <button onclick="toggleDropdown('reports-menu', 'reports-arrow')" 
                        class="w-full nav-item p-3 rounded-lg flex items-center justify-start gap-3 focus:outline-none">
                    <i class="fas fa-chart-line w-5 shrink-0"></i>
                    <span class="flex-1 text-left opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap w-0 group-hover:w-auto overflow-hidden">Reports</span>
                    <i id="reports-arrow" class="fas fa-chevron-down text-xs chevron-icon opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                </button>
                <ul id="reports-menu" class="submenu rounded-lg mt-1 ml-2 space-y-1 overflow-x-hidden">
                    <li>
                        <a href="index.php?page=reports-gle" class="block p-3 pl-10 rounded-lg hover:bg-white/10 text-sm whitespace-nowrap">
                            <i class="fas fa-file-invoice mr-2"></i> 
                            <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">GLE Reports</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?page=reports-overall" class="block p-3 pl-10 rounded-lg hover:bg-white/10 text-sm whitespace-nowrap">
                            <i class="fas fa-globe mr-2"></i> 
                            <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">Overall Reports</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <button onclick="toggleDropdown('admin-menu', 'admin-arrow')" 
                        class="w-full nav-item p-3 rounded-lg flex items-center justify-start gap-3 focus:outline-none">
                    <i class="fas fa-user-cog w-5 shrink-0"></i>
                    <span class="flex-1 text-left opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap w-0 group-hover:w-auto overflow-hidden">Admin Settings</span>
                    <i id="admin-arrow" class="fas fa-chevron-down text-xs chevron-icon opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                </button>
                <ul id="admin-menu" class="submenu rounded-lg mt-1 ml-2 space-y-1 overflow-x-hidden">
                    <li>
                        <a href="index.php?page=user-management" class="block p-3 pl-10 rounded-lg hover:bg-white/10 text-sm whitespace-nowrap">
                            <i class="fas fa-users mr-2"></i> 
                            <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">User Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?page=gl-settings" class="block p-3 pl-10 rounded-lg hover:bg-white/10 text-sm whitespace-nowrap">
                            <i class="fas fa-cogs mr-2"></i> 
                            <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">GL Code Settings</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="p-4 border-t border-white/10 flex items-center justify-start gap-3 bg-black/10">
        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center shrink-0">
            <i class="fas fa-user"></i>
        </div>
        <div class="opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap w-0 group-hover:w-auto overflow-hidden">
            <p class="text-sm font-bold leading-none">Admin User</p>
            <small class="text-xs opacity-70">GLCS Administrator</small>
        </div>
    </div>
</div>

<style>
    /* Ensure submenus are hidden when sidebar is not being hovered */
    #sidebar:not(:hover) .submenu {
        display: none !important;
    }
</style>

<script>
function toggleDropdown(menuId, arrowId) {
    const menu = document.getElementById(menuId);
    const arrow = document.getElementById(arrowId);
    
    menu.classList.toggle('show');
    arrow.classList.toggle('rotate-180');
    
    if (!menu.classList.contains('show')) {
        menu.style.display = 'none';
    } else {
        menu.style.display = 'block';
    }
}
</script>