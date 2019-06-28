<?php


class UserController{

	private $model;

	public function __construct(){
		$this->model = new UserModel();
	}

    public function get_profile($email , $pass){
        $id = $this->model->login($email , $pass);
        if($id == -1){
            header('Location:index.php');
        }else {
            $_SESSION['userid'] = $id;
            header('Location:profile.php');
        }
    }


}