<?php

$subpage = 'main';

if(isset($_GET['page'])) {

    if(file_exists("app/views/pages/".$_GET['page'].".view.php")) {
        $subpage = $_GET['page'];
    }
    
}

include("app/views/index.view.php");