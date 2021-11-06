<?php
spl_autoload_register(function ($className) {
    if (str_contains($className, "Validator")  || str_contains($className, "UploadApi")  || str_contains($className, "PHPMailer")) {
        require_once dirname(__FILE__, 6)  . '/Kamaleao/vendor/composer/autoload_real.php';
    } else {
        require_once __DIR__ . "/cl" . $className . ".php";
    }
})
?>
