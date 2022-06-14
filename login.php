

	<?php 
		require 'config.php';
		if (isset($_POST['simpan'])) {
			$email = $_POST['email'];
			$password = sha1($_POST['password']);

			$user = $collection->user->findOne(['email' => $email,'password'=>$password]);
			$cek = $collection->user->count(['email' => $email,'password'=>$password]);
			if ($cek > 0) {
				if ($user['level']=="admin") {
					session_start();
					$_SESSION['id'] = $user['_id'];
					$_SESSION['nama'] = $user['nama'];
					$_SESSION['email'] = $user['email'];
					$_SESSION['level'] = $user['level'];
					header("location:admin/index.php");
				}
				elseif ($user['level']=="member") {
					session_start();
					$_SESSION['id'] = $user['_id'];
					$_SESSION['nama'] = $user['nama'];
					$_SESSION['email'] = $user['email'];
					$_SESSION['level'] = $user['level'];
					header("location:member/index.php");
				}

			}
			else{
				echo "<script>alert('Email atau Password salah!')</script>";
			}
		}

	 ?>

<!-- =========================================================================================== -->
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

    <title>Login</title>
  </head>
  <body class="bg-gradient-primary">

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center mt-5">

		<div class="row">
			<h1 style="font-family: Nunito;"  class="text-center color-white"><a class="color-white" href="index.php">Petizon de'Polban</a></h1>
		</div>
        <div class="col-xl-10 col-lg-12 col-md-9">


            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">						
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 style="font-family: Nunito;" class="h4 text-gray-900 mb-4">Login</h1>
                                </div>
                                <form method="POST">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control form-control-user"
                                            id="exampleInputEmail" aria-describedby="emailHelp"
                                            placeholder="Masukan Email...">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Masukan Password...">
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label" for="customCheck">Ingat Saya</label>
                                        </div>
                                    </div>
                                    <input class="btn btn-primary btn-user btn-block" type="submit" name="simpan" value="Login">
                                    
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="register.php">Buat Akun</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

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