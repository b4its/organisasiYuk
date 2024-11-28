<button?php 
session_start();
?>

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>Organisasi</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.html" class="nav-item nav-link active">Home</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Gabung bersama kami</a>

                    <div class="dropdown-menu fade-down m-0">
                        <?php
                        require_once('../database/connection.php');
                        $sql = "SELECT namaOrganisasi FROM organisasi";
                        if ($hasilQuery = mysqli_query($db, $sql)) {
                            if (mysqli_num_rows($hasilQuery) > 0) {
                                while ($kolom = mysqli_fetch_array($hasilQuery)) {
                                    // var_dump($kolom['namaOrganisasi']);
                                    if(empty($_SESSION['idUser'])){
                                        echo '<a class="dropdown-item" href="authenticate/login.php">'.$kolom['namaOrganisasi'].'</a>';
                                    }else{
                                        echo '<button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#'. str_replace(' ', '_', (strtolower($kolom['namaOrganisasi']))).'">'.$kolom['namaOrganisasi'].'</button>';
                                        
                                    }
                                ?>
                            
                        <?php
                                }
                            }
                        }

                                
                        ?>
                    </div>

                </div>
                <?php
                if(empty($_SESSION['idUser'])){
                    
                ?>
                <a href="authenticate/login.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Login</a>
                <?php
                } else {

    
                ?>
                <a href="authenticate/proses/prosesLogout.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Logout</a>
                <?php
                }
                ?>
            </div>
            
        </div>
    </nav>
    <!-- Navbar End -->






    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">

                <?php
            $sqlBanner = "SELECT * FROM organisasi";
            if ($hasilBanner = mysqli_query($db, $sqlBanner)) {
                if (mysqli_num_rows($hasilBanner) > 0) {
                    while ($rows = mysqli_fetch_array($hasilBanner)) {
                        // var_dump($rows['namaOrganisasi']);
                    ?>
            <div class="owl-carousel-item position-relative">
                <?php
                    if($rows['foto']){
                        echo '<img class="img-fluid" src="../'.$rows['foto'].'" alt="">';
                    }else{
                        echo '<img class="img-fluid" src="../assets/img/error.jpg" alt="">';
                    }
                ?>
                
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-primary text-uppercase mb-3 animated slideInDown"><?php echo $rows['jenis'] ?></h5>
                                <h1 class="display-3 text-white animated slideInDown"><?php echo $rows['namaOrganisasi']?></h1>
                                <p class="fs-5 text-white mb-4 pb-2"><?php echo $rows['deskripsi']?></p>
                        <?php 
                                if(empty($_SESSION['idUser'])){

                                    echo '<a class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft" href="authenticate/login.php">Gabung Bersama Kami</a>';
                                }else{
                                    echo '<button class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft" data-bs-toggle="modal" data-bs-target="#'. str_replace(' ', '_', (strtolower($rows['namaOrganisasi']))).'">Gabung Bersama Kami</button>';

                                }
                        ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                    }
                }
            }
            ?>
                        
        </div>
    </div>
    <!-- Carousel End -->



    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100" src="../assets/img/about.jpg" alt="" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">About Us</h6>
                    <h1 class="mb-4">Organisasi</h1>
                    <p class="mb-4">Organisasi adalah sekelompok individu yang bekerja sama secara terstruktur dan terkoordinasi untuk mencapai tujuan tertentu.</p>
                    <p class="mb-4">Struktur organisasi melibatkan pembagian tugas, peran, dan tanggung jawab yang dirancang untuk memaksimalkan efisiensi dan hasil.</p>
                    <a class="btn btn-primary py-3 px-5 mt-2" href="">Read More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->
    <?php
                        $sql = "SELECT namaOrganisasi FROM organisasi";
                        if ($hasilQuery = mysqli_query($db, $sql)) {
                            if (mysqli_num_rows($hasilQuery) > 0) {
                                while ($kolom = mysqli_fetch_array($hasilQuery)) {
                                    ?>
                            <div class="modal fade" id="<?php echo str_replace(' ', '_', (strtolower($kolom['namaOrganisasi']))) ?>" tabindex="-1" aria-labelledby="<?php echo str_replace(' ', '_', (strtolower($kolom['namaOrganisasi']))) ?>Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="<?php echo str_replace(' ', '_', (strtolower($kolom['namaOrganisasi']))) ?>Label">Pendaftaran <?php echo $kolom['namaOrganisasi'] ?></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="masukkan nama anda">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Alasan</label><br>
                                        <textarea name="alasan" cols="30" class="form-control" placeholder="masukkan alasan anda"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Daftar</button>
                                </div>
                                </div>
                            </div>
                            </div>
                        <?php
                                }
                            }
                        }
                        ?>






        

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">2024 copyright </a>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="">Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>