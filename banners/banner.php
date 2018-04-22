<?php 
    header('Content-Type: image/png');
    $image=imagecreatefrompng('default.png');
    $black=imagecolorallocate($image, 0, 0, 0);
    imagepng($image);
    imagedestroy($image);
?>