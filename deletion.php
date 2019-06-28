<?php

session_start();

include 'init.php';

$action = '';

if(isset($_GET['action'])){

    $action = $_GET['action'];

    if($action == 'account'){
        if(isset($_SESSION['userid'])){
            $usrmodle = new UserModel();

            $usrmodle->delete($_SESSION['userid']);

            header('Location:logout.php');
        }
    }elseif ($action == 'image'){
        $imgmodel = new ImageModel();
        $imgId = $imgmodel->findByUserID($_SESSION['userid']);
        $imgmodel->update();
        header('Location:profile.php');
    }



}

include $temp . 'footer.inc.php';