<?php 
	session_start();
	require 'config.php';
	if (!isset($_SESSION['email'])) {
		echo "<script>alert('Silahkan Login Terlebih dahulu!')</script>";
		echo "<script>window.location.href='login.php';</script>";	
	}
 
		if (isset($_POST['simpan'])) {
			$judul = $_POST['judul'];
			$date_expired = $_POST['date_expired'];
			$target = $_POST['target'];
			$isi = $_POST['isi'];
			$kategori = $_POST['kategori'];
			$solusi = $_POST['solusi'];

			$rand = rand();
			$ekstensi =  array('png','jpg','jpeg');
			$filename = $_FILES['thumbnail']['name'];
			$ukuran = $_FILES['thumbnail']['size'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(!in_array($ext,$ekstensi) ) {
				echo "<script>alert('Ekstensi gambar tidak diizinkan!')</script>";
			}else{
				if($ukuran < 1044070){
					$rename = $rand.'_'.$filename;
					move_uploaded_file($_FILES['thumbnail']['tmp_name'], './gambar/'.$rename);

					$data = [
						'judul' 		=> $judul,
						'konten' 		=> $isi,
						'thumbnail' 	=> $rename,
						'date_created' 	=> date('Y-m-d'),
						'id_user' 		=> $_SESSION['id'],
						'status' 		=> 'pending',
						'status_akhir' 	=> 'pending',
						'date_expired' 	=> $date_expired,
						'target' 		=> $target,
						'kategori' 		=> $kategori
					];

					$collection->petisi->insertOne($data);

					$data_petisi = $collection->petisi->findOne([],['sort' => ['_id' => -1]]);
					$last_id = $data_petisi['_id'];
					
					for ($i=0; $i < count($solusi) ; $i++) { 
						// $opsi = $_POST['solusi'][$i];
						$data_solusi = [
							'opsi'		=> $_POST['solusi'][$i],
							'id_petisi'	=> $last_id
						];
						$collection->solusi->insertOne($data_solusi);
					}

					echo "<script>alert('Petisi berhasil dibuat, hubungi admin untuk verifikasi!')</script>";
					echo "<script>window.location.href='index.php';</script>";	

				}
				else{
					echo "<script>alert('Ukuran gambar tidak valid!')</script>";
				}
			}

		}

	 ?>

<!-- ================================================================================================ -->
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

    <title>Buat Petisi</title>
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
          <li><a href="petisi_saya.php" class="text-gray-100">Petisi Saya</a></li>
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
    <section id="contact" class="contact mb-5">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="offset-md-3 col-xl-9">
            <h1 class="page-title fw-bold">Apa Nama Petisimu?</h1>
            <h4>Ceritakan Masalah Yang Ingin Kamu Sampaikan</h4>
          </div>  
        </div>

      <div class="row">
        <div class="offset-md-3 col-md-6">
          <div class="form">
            <form method="POST" role="form" class="" enctype="multipart/form-data">
              <div class="row">

                <!-- Judul -->
                <div class="form-group col-md-6">
                  <span>Judul Petisi</span>
                  <input type="text" class="form-control" name="judul" id="email" placeholder="" required>
                </div>

              </div>

              <!-- Target -->
              <div class="form-group">
                <span>Target Petisi</span>
                <input type="number" class="form-control" name="target" id="subject" placeholder="" required>
              </div>

              <!-- Kategori -->
              <div class="form-group">
                <span>Kategori</span>
                <select name="kategori" class="form-select" aria-label="Default select example">
                  <option selected>Pilih Kategori</option>
                  <option value="pembelajaran">Pembelajaran</option>
                  <option value="fasilitas">Fasilitas</option>
                  <option value="finansial">Finansial</option>
                  <option value="pelecehan">Pelecehan</option>
                </select>
              </div>

              <!-- Durasi -->
              <div class="form-group">
                <span>Durasi Petisi</span>
                <input type="date" class="form-control" name="date_expired" id="subject" placeholder="" required>
              </div>

              <!-- Isi -->
              <div class="form-group">
                <span>Konten (Isi Petisi)</span>
                <textarea class="form-control" name="isi" rows="5" placeholder="" required></textarea>
              </div>

              <!-- Thumbnail -->
              <div class="form-group">
                <span>Thumbnail</span>
                <input class="form-control" type="file" name="thumbnail" id="">
              </div>

              <!-- Solusi -->
              <div class="form-group">
                <span>Solusi</span>
                <div class="border p-3 mb-3">
                <div class="form-check">
                  <span>Solusi 1</span>
                  <input type="text" name="solusi[]" class="form-control">
                </div>
                <div class="form-check field_wrapper">
                </div>
                <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm my-2 add_button">Tambah Solusi</a>
              </div>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center">
                <input type="submit" name="simpan" value="Terbitkan Petisi" class="btn btn-primary" >
              </div>
            </form>
          </div><!-- End Contact Form -->
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
    
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<script>
	   $(document).ready(function(){
	      var maxField = 5; //maksimal field
	      var addButton = $('.add_button'); //button tambah
	      var wrapper = $('.field_wrapper'); //lokasi/wrapper field
	      var x = 1; //mulai field ke 1
	      var y = 0; //mulai field ke 1

	      // var fieldHTML = '<div class="form-group"><a href="javascript:void(0);" class="remove_button" title="Klik untuk hapus genre"><strong>Genre:</strong></a><input type="text" name="genre[]" class="form-control" placeholder="Genre" value=""/></div>'; //tambah field html 
	      $(addButton).click(function(){ 
	         if(x < maxField){ 
	            x++; 
	            $(wrapper).append('<div class="form-group"><a href="javascript:void(0);" class="remove_button" title="Klik untuk hapus solusi"><strong>Hapus:</strong></a><input type="text" name="solusi[]" class="form-control" placeholder="Solusi '+x+'" value=""/></div>');
	         }
	      });
	      $(wrapper).on('click', '.remove_button', function(e){ 
	         e.preventDefault();
	         $(this).parent('div').remove(); //hapus field html
	         x--; 
	      });

	   });
	</script>
    </body>
    </html>