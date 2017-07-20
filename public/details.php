<?php

require '../inc/config.php';

if(!empty($_GET['movieID'])){
    $movieID = isset($_GET['movieID']) ? strip_tags(trim($_GET['movieID'])) :
}










require'../view/header.php';
require dirname(dirname(__FILE__)).'/view/details.php';

require'../view/footer.php';

 ?>
