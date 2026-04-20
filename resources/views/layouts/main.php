<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>General Ledger | M Lhuillier</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700;900&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <style>
        body { font-family: 'League Spartan', sans-serif; }
        .font-poppins { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="flex flex-col min-h-screen relative">

    <?php include __DIR__ . '/../components/header.php'; ?>

    <main class="flex-grow flex flex-col min-h-0">
        <?php echo $content ?? ''; ?>
    </main>

    <footer class="absolute bottom-0 left-0 p-5 text-xs text-white">
        &copy; 2026 M Lhuillier Financial Services, Inc.
    </footer>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const illustration = document.getElementById('illustration');
        if(illustration) {
            illustration.style.transition = 'opacity 1s ease-in-out';
            setTimeout(() => {
                illustration.classList.remove('opacity-0');
                illustration.classList.add('opacity-100');
            }, 100);
        }
    });
    </script>
</body>
</html>