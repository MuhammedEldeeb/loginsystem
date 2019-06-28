<?php
    session_start();
    include 'init.php';

   if(isset($_SESSION['userid'])){

       $model = new UserModel();

       $test = $model->findByID($_SESSION['userid']);

       if($test == 1) {

           if($_SERVER['REQUEST_METHOD'] == "POST"){
               $id = $_SESSION['userid'];
               $name = $_POST['name'];
               $email = $_POST['email'];
               $pass = (empty($_POST['newPass']))? $_POST['oldPass'] : sha1($_POST['newPass']);

                $model->update($id, $name, $email, $pass);

           }else{}


           ?>

           <a href="logout.php">logout</a>

           <h1>Your Profile</h1>

           <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">


              <img src="uploads/eldeeb.jpg" width="100" height="100">
              <br>

              <input type="file" name="image" value="change Profile image">

              <br>
              
               <label>FullName</label>
               <input type="text" name="name" value="<?php echo $model->getName(); ?>">
               <br>
               <label>Email</label>
               <input type="email" name="email" value="<?php echo $model->getEmail(); ?>">
               <br>
               <label>password</label>
               <input type="hidden" name="oldPass" value="<?php echo $model->getPassword()?>">
               <input type="password" name="newPass" placeholder="blank means no change" autocomplete="new-password">
               <br>
               <input type="submit" value="Update">

           </form>


           <?php

       }else{

       }
   }else{
        header('Location:index.php');
        exit();
   }

    include $temp . 'footer.inc.php';
