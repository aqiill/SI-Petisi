<?php 
	session_start();
	require 'config.php';
	$slug = str_replace('-', ' ', @$_GET['r']);

	$cek = $collection->petisi->count(['judul' => $slug]);
	if ($cek>0) {
		$data = $collection->petisi->findOne(['judul' => $slug]);
		$pemilik = $collection->user->findOne(['_id' => $data['id_user']]);
	}
	else{
		header("location:404.php");
	}
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

    <title><?= ucwords($data['judul']) ?> - Petizon de'Polban</title>
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

    <section class="single-post-content">
      <div class="container">
        <div class="row">
          <div class="col-md-9 post-content" data-aos="fade-up">

            <!-- ======= Single Post Content ======= -->
            <div class="single-post">
              <div class="post-meta"><span class="date"><?= strtoupper($data['kategori']) ?></span> <span class="mx-1">&bullet;</span> <span><?php date('d F y', strtotime($data['date_created'])) ?></span></div>
              <h1><?= ucwords($data['judul']) ?></h1>
              <div class="post-meta mb-5"><span><?= ucwords($pemilik['nama']) ?></span></div>
              <img src="gambar/<?= $data['thumbnail']; ?>" alt="" class="img-fluid mb-5" style="max-width: 500px">
              <p><?= ucfirst($data['konten']) ?></p>
            </div><!-- End Single Post Content -->

            <!-- ======= Comments ======= -->
            <div class="comments">
              
				<h5 class="comment-title py-4">Alasan:</h5>
	<?php

		if (isset($data['alasan'])) {

      $data_alasan = $collection->petisi->aggregate([
         ['$lookup'=>['from' => 'user','localField' => 'alasan.user_id','foreignField' => '_id','as' => 'result']],
         ['$match' => ['judul' => $slug]],
         ['$sort' => ['_id' => -1]],
         ['$limit' => 8],
      ]);

      foreach ($data_alasan as $value) { ?>
      	<?php foreach ($value['alasan'] as $apa): ?>
         	<?php 
   			$siapa = $collection->user->find(['_id' => $apa['user_id']]);
   			foreach ($siapa as $v_siapa) { ?>

              <div class="comment d-flex mb-4">
                <div class="flex-shrink-0">
                  <div class="avatar avatar-sm rounded-circle">
                    <img class="avatar-img" src="https://www.gravatar.com/avatar/<?= md5($v_siapa['email'])  ?>?d=mm" alt="" class="img-fluid">
                  </div>
                </div>
                <div class="flex-grow-1 ms-2 ms-sm-3">
                  <div class="comment-meta d-flex align-items-baseline">
                    <h6 class="me-2"><?= ucwords($v_siapa['nama']) ?></h6>
                    <span class="text-muted"><?= date('d F y', strtotime($apa['date_alasan'])) ?></span>
                  </div>
                  <div class="comment-body">
                    <?= $apa['isi'] ?>
                  </div>
                </div>
              </div>
      		<?php	}
      		 ?>
      	<?php endforeach ?>
    <?php  }
		} else{ ?>
			<h5 class="comment-title py-4">Belum ada alasan</h5>
	<?php	}
	 ?>

            </div><!-- End Comments -->


          </div>
          <div class="col-md-3">

            <div class="aside-block">
                <h3 class="aside-title">Tanda Tangan</h3>
                <div class="post-entry-1 border-bottom">
                    <h2 class="mb-2"><span><strong><?php if (isset($data['alasan'])) { echo count($data['alasan']); }else{ echo "0"; }  ?> orang telah mendatangani.</strong> Mari Menuju <strong class="fw-bold text-danger"><?= $data['target'] ?></strong> Tandatangan!</span></h2>
						<?php if (isset($_SESSION['email'])){ ?>

							<?php 
							$cek_penandatanganan = $collection->hasil->count(['id_user' => $_SESSION['id'],'id_petisi' => $data['_id']]);
							
							if ($cek_penandatanganan>0) {
								echo "<h4 class='text-warning'>Anda Sudah Menandatangani Petisi ini!</h4>";
							}
							else{ ?>

							

                    <div class="form">
                        <form action="" method="post" role="form" class="">
                            <div class="form-group">
                                <textarea class="form-control my-3" name="alasan" rows="5" placeholder="Alasan kamu mendatangani petisi ini?" required></textarea>
                                
                                <!-- POLLING -->
                                <div class="border p-4 my-3">
                                    <h5 class="fw-bold">Pilih Solusi</h5>
                                    <span class="form-text small mb-3">Pilih satu solusi sesuai yang kamu setujui!</span>
												<?php 
													$solusi = $collection->solusi->find(['id_petisi' => $data['_id']]);
													foreach ($solusi as $value) { ?>
                                    <div class="form-check">
                                        <input class="form-check-input" value="<?= $value['_id'] ?>" type="radio" name="solusi" id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                        <?= ucwords($value['opsi']) ?>
                                        </label>
                                    </div>

												<?php } ?>
                                </div>
                                <!-- END POLLING -->

                                <input type="submit" name="simpan" class="btn btn-primary btn-user btn-block" value="Tandatangani !">
                            </div>
                        </form>
                    </div>

                    <?php 
								if (isset($_POST['simpan'])) {
									$alasan = $_POST['alasan'];
									$id_solusi = $_POST['solusi'];

							        $collection->petisi->updateOne(
							             ['_id' => $data['_id']],
							             ['$push' => [
							               'alasan' => [
							               	'isi' => $alasan,
							               	'user_id' => $_SESSION['id'],
							               	'date_alasan' => date('Y-m-d H:i:s')
							               ]
							               ]
							             ]
							         );
							        $hasil = [
							        	'id_solusi' => new MongoDB\BSON\ObjectId($id_solusi),
							        	'id_user' => $_SESSION['id'],
							        	'id_petisi' => $data['_id'],
							        ];
							        $collection->hasil->insertOne($hasil);

						    		echo "<script>alert('Terimakasih telah menandatangani petisi!')</script>";
									echo "<script>window.location.href='detail.php?r=".$_GET['r']."';</script>";	
								}
							 ?>

						<?php	}
						?>

					<?php } else{ ?>
						<a href="login.php" class="btn btn-primary btn-block">Tandatangan Petisi!</a>
					<?php } ?>

                  </div>
            </div><!-- End Form Tandatangan -->

            <div class="aside-block">
                <h3 class="aside-title">Kategori</h3>
                <ul class="aside-tags list-unstyled">
                  <li><a href="kategori.php?q=finansial">Finansial</a></li>
                  <li><a href="kategori.php?q=pembelajaran">Pembelajaran</a></li>
                  <li><a href="kategori.php?q=fasilitas">Fasilitas</a></li>
                  <li><a href="kategori.php?q=pelecehan">Pelecehan</a></li>
                </ul>
            </div><!-- End Tags -->



          </div>
        </div>
      </div>
    </section>
  </main><!-- End #main -->


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