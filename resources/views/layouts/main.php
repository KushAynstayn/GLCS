<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>General Ledger | M Lhuillier</title>
    <link rel="icon" type="image/png" href="../public/assets/images/mlcircle.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700;900&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../resources/assets/css/app.css">
    <link rel="stylesheet" href="../resources/assets/css/sidebar.css">
    <style>
        body { font-family: 'League Spartan', sans-serif; }
        .font-poppins { font-family: 'Poppins', sans-serif; }
    </style>

    <?php
        session_start();

        $page = $_GET['page'] ?? 'landing';
        $currentPage = $page;

        // OPTIONAL: redirect if not logged in (protect system pages)
        $protectedPages = [
            'dashboard',
            'gle-import',
            'reports-gle',
            'reports-overall',
            'user-management',
            'gl-settings'
        ];

        if (in_array($page, $protectedPages) && !isset($_SESSION['user'])) {
            header("Location: index.php?page=landing");
            exit;
        }
    ?>
</head>
<body class="flex flex-col h-screen overflow-hidden">

     <!-- HEADER -->
    <?php include __DIR__ . '/../components/header.php'; ?>

    <?php if ($page === 'landing'): ?>

        <!-- LANDING (NO SIDEBAR) -->
        <main class="flex-1 flex flex-col">
            <?php echo $content ?? ''; ?>
        </main>

    <?php else: ?>

        <!-- SYSTEM PAGES (WITH SIDEBAR) -->
        <div class="flex h-screen overflow-hidden">

            <?php if (isset($_SESSION['user'])): ?>
                <?php
                    $currentPage = $page;
                    include __DIR__ . '/../components/sidebar.php';
                ?>
            <?php endif; ?>

            <main class="flex-1 p-6 bg-gray-100 overflow-y-auto">
                <?php echo $content ?? ''; ?>
            </main>

        </div>

    <?php endif; ?>

    <!-- FOOTER (optional for landing only) -->
    <?php if ($page == 'landing'): ?>
        <div class="absolute bottom-0 left-0 w-full z-50 pointer-events-none">
            <?php include __DIR__ . '/../components/footer.php'; ?>
        </div>
    <?php endif; ?>

    
    <script>
    setTimeout(() => {
        const illustration = document.getElementById('illustration');
        if(illustration) {
            illustration.style.transition = 'opacity 1s ease-in-out';
            setTimeout(() => {
                illustration.classList.remove('opacity-0');
                illustration.classList.add('opacity-100');
            }, 100);
        }
    }, 100);
    </script>

    <?php include __DIR__ . '/../components/modals/force-change-password-modal.php'; ?>


</body>
</html>