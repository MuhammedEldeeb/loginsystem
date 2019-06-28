<?php 

	session_start();
	if(isset($_SESSION['userid'])){
		header('Location:profile.php');
	}

    include 'init.php';

	if($_SERVER['REQUEST_METHOD'] == "POST"){
	    $email = $_POST['email'];
	    $pass = $_POST['pass'];

	    $controller = new UserController();
	    $controller->get_profile($email , $pass);

    }
 ?>


<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
	<input type="email" name="email" placeholder="Emial" autocomplete="off">
    <br>
	<input type="password" name="pass" placeholder="Password" autocomplete="new-password">
    <br>
    <input type="submit" value="Login">
</form>
<br>
<a href="registration.php">Register</a>
<?php include $temp . 'footer.inc.php' ?>