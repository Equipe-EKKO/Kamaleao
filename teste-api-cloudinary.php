<?php
require_once ('config.php');
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

//  Or configure programatically

Configuration::instance([
    'cloud' => [
      'cloud_name' => 'kamaleaotcc', 
      'api_key' => '732428865218215', 
      'api_secret' => 'GIezSuGMw32v63QQAwVOY20MYEE'],
    'url' => [
      'secure' => true]]);


      
      if ((new UploadApi())->upload('https://upload.wikimedia.org/wikipedia/commons/a/ae/Olympic_flag.jpg')) {
          echo true;
      } else {
          echo false;
      }