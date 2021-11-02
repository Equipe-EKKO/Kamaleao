<?php
#Require do autoload do composer
define('ROOT_PATH', dirname(__FILE__));
require_once ROOT_PATH . "/vendor/autoload.php";
use Cloudinary\Configuration\Configuration;

date_default_timezone_set('America/Sao_Paulo');

session_start();

Configuration::instance([
    'cloud' => [
      'cloud_name' => 'kamaleaotcc', 
      'api_key' => '732428865218215', 
      'api_secret' => 'GIezSuGMw32v63QQAwVOY20MYEE'],
    'url' => [
      'secure' => true]]);
?>