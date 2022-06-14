

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Vendor CSS Files -->
    <link href="assets/js/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/js/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/js/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/js/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/js/vendor/aos/aos.css" rel="stylesheet">

    <!-- Template Main CSS Files -->
    <link href="assets/css/sb-admin-2.css" rel="stylesheet">
    <link href="assets/css/variables.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

    <title>Beranda</title>
  </head>
  <body>

    <!-- ======= Header ======= -->
    <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="text-gray-100">Petizon de'Polban</h1>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="v_buat_petisi.html" class="text-gray-100">Buat Petisi</a></li>
          <li><a href="v_petisi_saya.html" class="text-gray-100">Petisi Saya</a></li>
          <li class="dropdown"><a href="#" class="text-gray-100"><span class="text-gray-100">Kategori</span> <i class="bi bi-chevron-down dropdown-indicator text-gray-100"></i></a>
            <ul>
              <li><a href="kategori.php?q=finansial">Finansial</a></li>
              <li><a href="kategori.php?q=pembelajaran">Pembelajaran</a></li>
              <li><a href="kategori.php?q=fasilitas">Fasilitas</a></li>
              <li><a href="kategori.php?q=pelecehan">Pelecehan</a></li>
            </ul>
          </li>
        </ul>
      </nav><!-- .navbar -->

      <div class="position-relative">
        
        <a href="#" class="mx-5 js-search-open"><span class="bi-search color-white"></span></a>
        <i class="bi bi-list mobile-nav-toggle color-white"></i>

        
        <?php if (isset($_SESSION['email'])){ ?>
         <a href="logout.php" class="btn btn-login btn-user">Logout</a>
        <?php }else{ ?>
         <a href="login.php" class="btn btn-login btn-user">Login</a>
        <?php } ?>
      </div>

    </div>

  </header><!-- End Header -->

<main id="main">

    <!-- ======= Search Results ======= -->
    <section id="search-result" class="search-result">
      <div class="container">
        
        <!-- Inputan Search -->
        <div class="row mb-5">
            <form method="POST">
            <div class="col-md-12 text-center">
                <h2>Cari Petisi</h2>
                <div class="input-group input-group-lg">
                    <span class="input-group-text icon bi-search"></span>
                        <input type="text" class="form-control border border-5" name="search" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                    </div>
                </div>
            </form>
        </div>

        <!-- Hasil Search -->
        <div class="row">

         <?php
            require 'config.php';

            if (isset($_POST['search'])) {
               $cari = $_POST['search'];
               $petisi = $collection->petisi->find(['$or' => [
                  ['judul' => new \MongoDB\BSON\Regex($cari)],
                  ['kategori' => new \MongoDB\BSON\Regex($cari)]
               ]]);


               foreach ($petisi as  $value) { ?>
         

          <div class="col-md-9">
            <h3 class="category-title">Search Results</h3>

            <div class="d-md-flex post-entry-2 small-img">
              <a href="detail.php?r=<?= str_replace(' ','-', $value['judul']) ?>" class="me-4 thumbnail">
                <img src="gambar/<?= $value['thumbnail'] ?>" alt="" class="img-fluid">
              </a>
              <div>
                <div class="post-meta"><span class="date"><?= strtoupper($value['kategori']) ?></span> <span class="mx-1">&bullet;</span> <span><?= date('d F y', strtotime($value['date_created'])) ?></span></div>
                <h3><a href="detail.php?r=<?= str_replace(' ','-', $value['judul']) ?>"><?= ucwords($value['judul']) ?></a></h3>
                <p><?= ucfirst(substr($value['konten'],0,244)); ?>...<a href="detail.php?r=<?= str_replace(' ','-', $value['judul']) ?>" class="text-primary">more</a></p>
              </div>
            </div>
          </div>
         <?php      }
            }
         ?>
        </div>
      </div>
    </section> <!-- End Search Result -->

  </main><!-- End #main -->


 <!-- ======= Footer ======= -->
 <footer id="footer" class="footer">

    <div class="footer-content">
    <div class="container">
    
    <div class="row g-5 justify-content-center">
      <div class="col-lg-4">
        <h3 class="footer-heading">Tentang Petizon de'Polban</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam ab, perspiciatis beatae autem deleniti voluptate nulla a dolores, exercitationem eveniet libero laudantium recusandae officiis qui aliquid blanditiis omnis quae. Explicabo?</p>
      </div>
      <div class="col-6 col-lg-2">
        <h3 class="footer-heading">Categories</h3>
        <ul class="footer-links list-unstyled">
          <li><a href="kategori.php?q=finansial"><i class="bi bi-chevron-right"></i> Finansial</a></li>
          <li><a href="kategori.php?q=pembelajaran"><i class="bi bi-chevron-right"></i> Pembelajaran</a></li>
          <li><a href="kategori.php?q=fasilitas"><i class="bi bi-chevron-right"></i> Fasilitas</a></li>
          <li><a href="kategori.php?q=pelecehan"><i class="bi bi-chevron-right"></i> Pelecehan</a></li>
        </ul>
      </div>
    </div>
    </div>
    </div>
    
    <div class="footer-legal">
    <div class="container">
    
    <div class="row justify-content-between">
      <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
        <div class="copyright">
          © Copyright <strong><span>ZenBlog</span></strong>. All Rights Reserved
        </div>
    
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/herobiz-bootstrap-business-template/ -->
          Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    
      </div>
    
      <div class="col-md-6">
        <div class="social-links mb-3 mb-lg-0 text-center text-md-end">
          <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
          <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="google-plus"><i class="bi bi-skype"></i></a>
          <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>
    
      </div>
    
    </div>
    
    </div>
    </div>
    
    </footer>
    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <!-- Optional JavaScript; choose one of the two! -->
    
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    
    <!-- Bootstrap core JavaScript-->
    <script src="assets/js/vendor/jquery/jquery.min.js"></script>
    
    <!-- Core plugin JavaScript-->
    <script src="assets/js/vendor/jquery-easing/jquery.easing.min.js"></script>
    
    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>   
    
    <!-- Vendor JS Files -->
    <script src="assets/js/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/js/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/js/vendor/aos/aos.js"></script>
    <script src="assets/js/vendor/php-email-form/validate.js"></script>
    
    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    
    </body>
    </html>