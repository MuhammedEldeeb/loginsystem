<?php
session_start();
include 'init.php';

    $controller = new UserController();

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = sha1($_POST['pass']);


        /** image info */
        $file = $_FILES['image'];

        $imageName = $file['name'];
        $imageTmpName = $file['tmp_name'];
        $imageSize = $file['size'];
        $imageError = $file['error'];
        $imageType = $file['type'];

        $image = new Image($imageName, $imageTmpName, $imageSize, $imageError, $imageType);
        if($image->isAllowed() === "Done"){
            $controller->add($name, $email, $pass , $image);
        }


    }

    ?>

    <h1>Registration Page</h1>

    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">

        <label>profile image</label>
        <input type="file" , name="image">
        <br>
        <label>FullName</label>
        <input type="text" name="name">
        <br>
        <label>Email</label>
        <input type="email" name="email">
        <br>
        <label>password</label>
        <input type="password" name="pass"autocomplete="new-password">
        <br>
        <input type="submit" value="Sign Up">

    </form>


        <?php

include $temp . 'footer.inc.php';
