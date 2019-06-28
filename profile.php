<?php
    session_start();
    include 'init.php';

   if(isset($_SESSION['userid'])){

       $usrmodel = new UserModel();
       $imgmodel = new ImageModel();

       $exist = $usrmodel->findByID($_SESSION['userid']);
       //there exist an account for this user
       if($exist) {

          $imageId = $imgmodel->findByUserID($usrmodel->getId());

         if($_SERVER['REQUEST_METHOD'] == "POST"){
             $id = $_SESSION['userid'];
             $name = $_POST['name'];
             $email = $_POST['email'];
             $pass = (empty($_POST['newPass']))? $_POST['oldPass'] : sha1($_POST['newPass']);

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
                
                // print out the errors 
                foreach ($formErrors as $error) {
                    echo $error . "<br>";
                }

                // update frofile info
                if(empty($formErrors)){
                    
                  if($image->imageExists()){ // user uploaded new image
                    $image->upload($imgmodel->getImageId());
                    $ext = $image->getImageActualExt();
                    $imgmodel->update(1, $ext);
                  }

                  $usrmodel->update($id, $name, $email, $pass);
                }

                  // reload the profile page
                  header('Location:profile.php');
          }else{}
           
           ?>

           <a href="logout.php">logout</a>

           <h1>Your Profile</h1>

           <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">


              <img src="uploads/<?php echo ($imgmodel->getStatus() == 1) ?($imageId . "." . $imgmodel->getExt()) : 'profile.png'; ?>" width="100" height="100">
              <br>
              <label>Chang profile image</label>
              <input type="file" name="image">

              <br>
              
               <label>FullName</label>
               <input type="text" name="name" value="<?php echo $usrmodel->getName(); ?>">
               <br>
               <label>Email</label>
               <input type="email" name="email" value="<?php echo $usrmodel->getEmail(); ?>">
               <br>
               <label>password</label>
               <input type="hidden" name="oldPass" value="<?php echo $usrmodel->getPassword()?>">
               <input type="password" name="newPass" placeholder="blank means no change" autocomplete="new-password"> 
               <br>
               <input type="submit" value="Update">

           </form>


           <?php

       }else{}
   }else{
        header('Location:index.php');
        exit();
   }

    include $temp . 'footer.inc.php';
