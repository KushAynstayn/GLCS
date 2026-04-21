<?php
$currentPage = $_GET['page'] ?? 'dashboard';
?>

<div class="w-64 sidebar-bg text-white h-full flex flex-col">
    <div class="p-6 border-b border-white/10 flex items-center gap-3">
        <i class="fas fa-university text-2xl"></i>
        <h2 class="text-xl font-bold tracking-wider">GLCS</h2>
    </div>

    <div class="flex-1 overflow-y-auto p-4">
        <ul class="space-y-1">
            
            <li>
                <a href="index.php?page=dashboard" 
                   class="nav-item p-3 rounded-lg <?= $currentPage == 'dashboard' ? 'nav-active' : '' ?>">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-th-large w-5"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>

            <li>
                <a href="index.php?page=gle-import" 
                   class="nav-item p-3 rounded-lg <?= $currentPage == 'gle-import' ? 'nav-active' : '' ?>">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-file-import w-5"></i>
                        <span>GLE Import</span>
                    </div>
                </a>
            </li>

            <li>
                <button onclick="toggleDropdown('reports-menu', 'reports-arrow')" 
                        class="w-full nav-item p-3 rounded-lg focus:outline-none">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-chart-line w-5"></i>
                        <span>Reports</span>
                    </div>
                    <i id="reports-arrow" class="fas fa-chevron-down text-xs chevron-icon"></i>
                </button>
                <ul id="reports-menu" class="submenu rounded-lg mt-1 ml-2 space-y-1">
                    <li>
                        <a href="index.php?page=reports-gle" class="block p-3 pl-10 rounded-lg hover:bg-white/10 text-sm">
                            <i class="fas fa-file-invoice mr-2"></i> GLE Reports
                        </a>
                    </li>
                    <li>
                        <a href="index.php?page=reports-overall" class="block p-3 pl-10 rounded-lg hover:bg-white/10 text-sm">
                            <i class="fas fa-globe mr-2"></i> Overall Reports
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <button onclick="toggleDropdown('admin-menu', 'admin-arrow')" 
                        class="w-full nav-item p-3 rounded-lg focus:outline-none">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-user-cog w-5"></i>
                        <span>Admin Settings</span>
                    </div>
                    <i id="admin-arrow" class="fas fa-chevron-down text-xs chevron-icon"></i>
                </button>
                <ul id="admin-menu" class="submenu rounded-lg mt-1 ml-2 space-y-1">
                    <li>
                        <a href="index.php?page=user-management" class="block p-3 pl-10 rounded-lg hover:bg-white/10 text-sm">
                            <i class="fas fa-users mr-2"></i> User Management
                        </a>
                    </li>
                    <li>
                        <a href="index.php?page=gl-settings" class="block p-3 pl-10 rounded-lg hover:bg-white/10 text-sm">
                            <i class="fas fa-cogs mr-2"></i> GL Code Settings
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="p-4 border-t border-white/10 flex items-center gap-3 bg-black/10">
        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
            <i class="fas fa-user"></i>
        </div>
        <div>
            <p class="text-sm font-bold leading-none">Admin User</p>
            <small class="text-xs opacity-70">GLCS Administrator</small>
        </div>
    </div>
</div>

<script>
function toggleDropdown(menuId, arrowId) {
    const menu = document.getElementById(menuId);
    const arrow = document.getElementById(arrowId);
    
    menu.classList.toggle('show');
    arrow.classList.toggle('rotate-180');
}
</script>