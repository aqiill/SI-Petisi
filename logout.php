<?php 
 
session_start();
session_destroy();
 
echo "<script>alert('Logout Berhasil!')</script>";
echo "<script>window.location.href='index.php';</script>";	
 
?>