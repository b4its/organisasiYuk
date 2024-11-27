<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Organizations</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="templates/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="templates/lib/animate/animate.min.css" rel="stylesheet">
    <link href="templates/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="templates/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="templates/css/style.css" rel="stylesheet">
</head>

<body>
    <?php
    $pages_dir='dashboard';
    if (!empty($_GET['p'])) {
        $pages = scandir($pages_dir);
        unset($pages[0], $pages[1]);
        $p = $_GET['p'];
        if (in_array($p . '.php', $pages)) {
            // Ambil slug dari URL
            $slug = isset($_SERVER['QUERY_STRING']) ? str_replace("p=$p&", "", $_SERVER['QUERY_STRING']) : '';
            include($pages_dir . '/' . $p . '.php');
        } else {
            echo 'Halaman Tidak dapat Ditemukan';
        }
    } else {
        include($pages_dir . '/halamanDashboard.php');
    }
    ?>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="templates/lib/wow/wow.min.js"></script>
    <script src="templates/lib/easing/easing.min.js"></script>
    <script src="templates/lib/waypoints/waypoints.min.js"></script>
    <script src="templates/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="templates/js/main.js"></script>
</body>

</html>