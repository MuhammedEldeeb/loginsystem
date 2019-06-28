<?php 

	session_start();
	if(isset($_SESSION['userid'])){
		header('Location:profile.php');
	}

    include 'init.php';

	if($_SERVER['REQUEST_METHOD'] == "POST"){

	    $email = $_POST['email'];
	    $pass = $_POST['pass'];

        //save this user and pass as cookie if remeber checked start
        if (isset($_REQUEST['remember']))
            $escapedRemember = mysqli_real_escape_string(DB_Connector::connect(),$_REQUEST['remember']);

        $cookie_time = 60 * 60 * 24 * 30; // 30 days
        $cookie_time_Onset=$cookie_time+ time();
        if (isset($escapedRemember)) {
            // Set Cookie from here for one hour
            setcookie("email", $email, $cookie_time_Onset);
            setcookie("pass", $pass, $cookie_time_Onset);

        } else {

            $cookie_time_fromOffset=time() -$cookie_time;
            setcookie("email", '',$cookie_time_fromOffset );
            setcookie("pass", '', $cookie_time_fromOffset);

        }
        //save this user and pass as cookie if remember checked end

	    $controller = new UserController();
	    $controller->get_profile($email , $pass);

    }
 ?>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
	<input type="email" name="email" placeholder="Emial" autocomplete="off" value="<?php if(isset($_COOKIE['email'])) echo $_COOKIE['email']; ?>" required>
    <br>
	<input type="password" name="pass" placeholder="Password" autocomplete="new-password" value="<?php if(isset($_COOKIE['pass'])) echo $_COOKIE['pass']; ?>" required>
    <br>
    <div>
        <input name="remember" type="checkbox"
            <?php if(isset($_COOKIE['email'])){echo "checked='checked'"; } ?> value="1">
        <label for="remember">
            Remember Me
        </label>
    </div>
    <input type="submit" value="Login">
</form>
<br>
<a href="registration.php">Register</a>
<?php include $temp . 'footer.inc.php' ?>
