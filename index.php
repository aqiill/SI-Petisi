<?php
require 'config.php';
session_start();
?>
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
          <li><a href="buat_petisi.php" class="text-gray-100">Buat Petisi</a></li>
          <li><a href="petisi.html" class="text-gray-100">Petisi Saya</a></li>
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
        
        <a href="cari.php" class="mx-5 js-search-open"><span class="bi-search color-white"></span></a>
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

    <main id="main">

      <!-- Intro Section -->
      <section>
        <div class="container-md" data-aos="fade-in">
          <div class="row">
            <div class="col-12 text-center">
              <h1 class="fs-1 fw-bold mb-3 color-blue" style="font-size: 100px !important;">Petizone de'Polban</h1>
              <h1>Jadikan Lingkungan Polban</h1>
            </div>
            <div class="col-12 text-center">
              <h1 class="fw-bold"><span>Jadi Lebih Baik !</span></h1>
            </div>
            <div class="col-12 text-center">
            <a href="buat_petisi.php" class="btn btn-primary">Buat Petisi!</a>
            </div>
          </div>
        </div>
      </section>
      <!-- End Intro Section -->

      <main id="main">
        <section>
          <div class="container">
            <div class="row">
    
              <div class="col-md-9" data-aos="fade-up">
<?php 
      $petisi = $collection->petisi->aggregate([
         ['$lookup'=>['from' => 'user','localField' => 'id_user','foreignField' => '_id','as' => 'result']],
         ['$sort' => ['_id' => -1]],
         ['$limit' => 8],
      ]);


      foreach ($petisi as  $value) {
         foreach ($value['result'] as $pemilik) { ?>

                <div class="d-md-flex post-entry-2 half">
                  <a href="detail.php?r=<?= str_replace(' ','-', $value['judul']) ?>" class="me-4 thumbnail">
                    <img src="gambar/<?= $value['thumbnail'] ?>" alt="" class="img-fluid">
                  </a>
                  <div>
                    <div class="post-meta"><span class="text"><?= ucwords($value['kategori']) ?></span> <span class="mx-1">&bullet;</span> <span><?= date('d F y', strtotime($value['date_created'])) ?></span></div>
                    <h3><a href="detail.php?r=<?= str_replace(' ','-', $value['judul']) ?>"><?= ucwords(strtolower($value['judul'])) ?></a></h3>
                    <p>
                       <?= ucfirst(substr($value['konten'],0,244)); ?>... <a href="detail.php?r=<?= str_replace(' ','-', $value['judul']) ?>" class="text-primary">more</a>
                    </p>
                    <div class="d-flex align-items-center author">
                      <div class="photo"><img src="https://www.gravatar.com/avatar/<?= md5($pemilik['email'])  ?>?d=mm" alt="" class="img-fluid"></div>
                      <div class="name">
                        <h3 class="m-0 p-0"><?= ucwords($pemilik['nama']) ?></h3>
                      </div>
                    </div>
                  </div>
                </div>
   <?php      }
      }
   ?>    
   
              </div>
              <div class="col-md-3">
                <!-- ======= Sidebar ======= -->
                <div class="aside-block">
    
                  <ul class="nav nav-pills custom-tab-nav mb-4" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-latest-tab" data-bs-toggle="pill" data-bs-target="#pills-latest" type="button" role="tab" aria-controls="pills-latest" aria-selected="false">Popular</button>
                    </li>
                  </ul>
    
                  <div class="tab-content" id="pills-tabContent">
                  <?php 
                     $data_petisi = $collection->hasil->aggregate([
                        ['$lookup'=> ['from' => 'petisi','localField' => 'id_petisi','foreignField' => '_id','as' => 'result']],
                        ['$group' =>  ['_id' => '$result', 'count' => ['$sum' => 1]]],
                        ['$sort' => ['_id' => 1]],
                        ['$limit' => 3],
                        
                     ]);
                     foreach ($data_petisi as $value) { ?>
                     <?php foreach ($value['_id'] as $v_petisi): ?>
                    <!-- Popular -->
                    <div class="tab-pane fade show active" id="pills-popular" role="tabpanel" aria-labelledby="pills-popular-tab">
                      <div class="post-entry-1 border-bottom">
                        <div class="post-meta"><span class="date"><?= $v_petisi['kategori'] ?></span> <span class="mx-1">&bullet;</span> <span><?= date('d F y', strtotime($v_petisi['date_created'])) ?></span></div>
                        <h2 class="mb-2"><a href="detail.php?r=<?= str_replace(' ','-', $v_petisi['judul']) ?>"><?= ucwords(strtolower($v_petisi['judul'])) ?></a></h2>
                        <span class="author mb-3 d-block"><?= $value['count'] ?> orang menandatangani</span>
                      </div>
                    </div> <!-- End Popular -->
                      <?php endforeach ?> 
                  <?php   }
                   ?>  
    
                  </div>
                </div>
    
              </div>
    
            </div>
          </div>
        </section>
      </main><!-- End #main -->
  
  <!-- ======= Footer ======= -->
<footer id="footer" class="footer">

<div class="footer-content">
<div class="container">

<div class="row g-5 justify-content-center">
  <div class="col-lg-4">
    <h3 class="footer-heading">Tentang Petisi Polban</h3>
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
      © Copyright <strong><span>Kelompok B3</span></strong>. All Rights Reserved
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