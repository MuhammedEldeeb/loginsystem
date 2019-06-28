<?php


include 'init.php';

    $model = new UserModel();

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        // get info form the form
        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $hashedPass = sha1($_POST['pass']);

        /** image info */
        $file = $_FILES['image'];

        $imageName = $file['name'];
        $imageTmpName = $file['tmp_name'];
        $imageSize = $file['size'];
        $imageError = $file['error'];
        $imageType = $file['type'];

        $image = new Image($imageName, $imageTmpName, $imageSize, $imageError, $imageType);

        //validation
        $formErrors = array();


        if($image->imageExists() && !($image->isAllowed())){
            $formErrors[] = "image can't be of this type";
        }
        if(empty($name)){
            $formErrors[] = "FullName can't be empty";
        }
        if(empty($email)){
            $formErrors[] = "Email can't be empty"; 
        }
        if(empty($pass)){
            $formErrors[] = "Password can't be empty"; 
        }
        
        // print out the errors 
        foreach ($formErrors as $error) {
            echo $error . "<br>";
        }

        // insert into database
        if(empty($formErrors)){
            $model->add($name, $email, $hashedPass , $image);
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
