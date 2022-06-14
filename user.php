   <?php


      require 'config.php';


      $user = $collection->user->find([]);


      foreach ($user as  $value) {
         echo "<pre>";
         print_r($value);
      }