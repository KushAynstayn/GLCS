<?php
require_once __DIR__ . '/../../../app/Helpers/RBAC.php';

$currentPage = $_GET['page'] ?? 'dashboard';

$user = $_SESSION['user'] ?? null;

$username = $user['username'] ?? 'Guest User';
$role = $user['role_name'] ?? 'User';

// 1. Logic to determine if a dropdown group is active
$isReportsActive = in_array($currentPage, ['reports-gle', 'reports-overall']);
$isAdminActive = in_array($currentPage, ['user-management', 'gl-settings']);
?>

<div id="sidebar" class="w-16 hover:w-64 group transition-all duration-300 sidebar-bg text-white h-full flex flex-col overflow-x-hidden relative">
    
    <div class="h-16 flex items-center justify-start px-4 border-b border-white/10 gap-3">
        <img src="assets/images/logo1.png" alt="Logo" class="w-8 h-8 object-contain shrink-0">
        <h2 class="text-xs font-bold tracking-wider opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
            GL CONSOLIDATED SYSTEM
        </h2>
    </div>


    <div class="flex-1 overflow-y-auto overflow-x-hidden p-3">
        <ul class="space-y-2">

            <!-- DASHBOARD (ALWAYS AVAILABLE) -->
            <li>
                <a href="index.php?page=dashboard" 
                   class="nav-item p-3 rounded-lg flex items-center justify-start gap-3 <?= $currentPage == 'dashboard' ? 'nav-active' : '' ?>">
                    <i class="fas fa-th-large w-5 shrink-0"></i>
                    <span class="opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap w-0 group-hover:w-auto overflow-hidden">
                        Dashboard
                    </span>
                </a>
            </li>

            <!-- GLE IMPORT -->
            <?php if (RBAC::hasPermission('gle_import.access')): ?>
            <li>
                <a href="index.php?page=gle-import" 
                   class="nav-item p-3 rounded-lg flex items-center justify-start gap-3 <?= $currentPage == 'gle-import' ? 'nav-active' : '' ?>">
                    <i class="fas fa-file-import w-5 shrink-0"></i>
                    <span class="opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap w-0 group-hover:w-auto overflow-hidden">
                        GLE Import
                    </span>
                </a>
            </li>
            <?php endif; ?>

            <!-- REPORTS -->
            <?php if (RBAC::hasPermission('reports.access')): ?>
            <li>
                 <button onclick="toggleSidebarDropdown('reports-menu', 'reports-arrow')" 
                        class="w-full nav-item p-3 rounded-lg flex items-center justify-start gap-3 focus:outline-none <?= $isReportsActive ? 'nav-active' : '' ?>">
                    <i class="fas fa-chart-line w-5 shrink-0"></i>
                    <span class="flex-1 text-left opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap w-0 group-hover:w-auto overflow-hidden">
                        Reports
                    </span>
                    <i id="reports-arrow" class="fas fa-chevron-down text-xs chevron-icon opacity-0 group-hover:opacity-100 transition-opacity duration-300 <?= $isReportsActive ? 'rotate-180' : '' ?>"></i>
                </button>

                <ul id="reports-menu" class="submenu rounded-lg mt-1 ml-2 space-y-1 overflow-x-hidden <?= $isReportsActive ? 'show' : '' ?>" style="<?= $isReportsActive ? 'display: block;' : 'display: none;' ?>">


                    <?php if (RBAC::hasPermission('reports.gle_reports.view')): ?>
                    <li>
                        <a href="index.php?page=reports-gle" 
                           class="block p-3 pl-10 rounded-lg hover:bg-white/10 text-sm whitespace-nowrap">
                            <i class="fas fa-file-invoice mr-2"></i> 
                            <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                GLE Reports
                            </span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <li>
                        <a href="index.php?page=reports-overall" 
                           class="block p-3 pl-10 rounded-lg hover:bg-white/10 text-sm whitespace-nowrap">
                            <i class="fas fa-globe mr-2"></i> 
                            <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Overall Reports
                            </span>
                        </a>
                    </li>

                </ul>
            </li>
            <?php endif; ?>

            <!-- ADMIN SETTINGS -->
            <?php if (RBAC::isAdmin()): ?>
            <li>
                <button onclick="toggleSidebarDropdown('admin-menu', 'admin-arrow')" 
                        class="w-full nav-item p-3 rounded-lg flex items-center justify-start gap-3 focus:outline-none <?= $isAdminActive ? 'nav-active' : '' ?>">
                    <i class="fas fa-user-cog w-5 shrink-0"></i>
                    <span class="flex-1 text-left opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap w-0 group-hover:w-auto overflow-hidden">
                        Admin Settings
                    </span>
                    <i id="admin-arrow" class="fas fa-chevron-down text-xs chevron-icon opacity-0 group-hover:opacity-100 transition-opacity duration-300 <?= $isAdminActive ? 'rotate-180' : '' ?>"></i>
                </button>

                <ul id="admin-menu" class="submenu rounded-lg mt-1 ml-2 space-y-1 overflow-x-hidden <?= $isAdminActive ? 'show' : '' ?>" style="<?= $isAdminActive ? 'display: block;' : 'display: none;' ?>">
                    <li>
                        <a href="index.php?page=user-management" 
                           class="block p-3 pl-10 rounded-lg hover:bg-white/10 text-sm whitespace-nowrap">
                            <i class="fas fa-users mr-2"></i> 
                            <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                User Management
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?page=gl-settings" 
                           class="block p-3 pl-10 rounded-lg hover:bg-white/10 text-sm whitespace-nowrap">
                            <i class="fas fa-cogs mr-2"></i> 
                            <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                GL Settings
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>

            <!-- LOGOUT -->
            <li>
                <a href="index.php?logout=1"
                class="nav-item p-3 rounded-lg flex items-center justify-start gap-3">
                    <i class="fas fa-sign-out-alt w-5 shrink-0"></i>
                    <span class="opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap w-0 group-hover:w-auto overflow-hidden">
                        Logout
                    </span>
                </a>
            </li>

        </ul>
    </div>

    <!-- USER FOOTER -->
    <div class="p-4 border-t border-white/10 flex items-center justify-start gap-3 bg-black/10">
        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center shrink-0">
            <i class="fas fa-user"></i>
        </div>
        <div class="opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap w-0 group-hover:w-auto overflow-hidden">
            <p class="text-sm font-bold leading-none">
                <?= htmlspecialchars($username) ?>
            </p>
            <small class="text-xs opacity-70">
                <?= htmlspecialchars($role) ?>
            </small>
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
    
function toggleSidebarDropdown(menuId, arrowId) {
    const targetMenu = document.getElementById(menuId);
    const targetArrow = document.getElementById(arrowId);
    
    // Check if the menu we clicked is currently hidden
    const isHidden = targetMenu.style.display === 'none';

    // 1. Close all submenus and reset all arrows
    document.querySelectorAll('.submenu').forEach(menu => {
        menu.style.display = 'none';
        menu.classList.remove('show');
    });
    
    document.querySelectorAll('.chevron-icon').forEach(arrow => {
        arrow.classList.remove('rotate-180');
    });

    // 2. If it was hidden, open the target menu
    if (isHidden) {
        targetMenu.style.display = 'block';
        targetMenu.classList.add('show');
        targetArrow.classList.add('rotate-180');
    }
}

</script>