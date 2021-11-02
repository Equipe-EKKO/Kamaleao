<?php
require_once ('config.php');
use Cloudinary\Api\Upload\UploadApi;

//  Or configure programatically
if ($objeto = (new UploadApi())->upload('app/public/View/assets/img/EKKO.png', ["folder" => "img_service", "use_filename" => true, "unique_filename" => true, "overwrite" => false])){
  $array = (array) $objeto;
  print_r($array);
  echo "<br>";
  echo $array['url']; 
} else {
  echo false;
}