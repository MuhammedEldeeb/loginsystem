<?php

class UserModel 
{
    private $id;
    private $name;
    private $password;
    private $email;

 
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getPassword()
    {
        return $this->password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function findByID($id)
    {
        $sql = 'SELECT * FROM user WHERE user_id = ?;';

        $stmt = DB_Connector::connect()->prepare($sql);

        $stmt->execute(array($id));
        $row = $stmt->fetch();
        if($stmt->rowCount() > 0){
            $this->id = $row['user_id'];
            $this->name = $row['user_name'];
            $this->password = $row['user_password'];
            $this->email = $row['user_email'];
            return true;
        }
        return false;
    }

    public function findID($email)
    {
        $sql = 'SELECT user_id FROM user WHERE user_email = ?;';

        $stmt = DB_Connector::connect()->prepare($sql);

        $stmt->execute(array($email));
        $row = $stmt->fetch();
        if($stmt->rowCount() > 0){
            return $row['user_id'];
        }
        return -1;
    }

    public function update($id, $name, $email, $pass){
        $sql = 'UPDATE user SET user_name = ?, user_email = ?, user_password = ? WHERE user_id = ?;';

        $stmt = DB_Connector::connect()->prepare($sql);
        $stmt->execute(array($name, $email, $pass, $id));

        if($stmt->rowCount() > 0){
            header('Location:profile.php');
        }else{
            header('Location:logout.php');
        }
    }

    public function add($name, $email, $pass , $image){
        $sql = 'INSERT INTO user (user_name,user_email,user_password) VALUES (:usr, :mail,:pwd);';

        $stmt = DB_Connector::connect()->prepare($sql);
        $stmt->execute(array('usr' => $name,
            'mail' =>$email,
            'pwd' => $pass));

        if($stmt->rowCount() > 0){
            MailSender::send($email , $name);
            $userId = $this->findID($email);
            if($userId != -1){
               $imgModel = new ImageModel();
               if($image->imageExists() && $image->isAllowed()){
                   $imgModel->add($userId, 1 , $image->getImageActualExt());
                   $imgName = $imgModel->findByUserID($userId);
                   $image->upload($imgName);
               }else{
                   $imgModel->add($userId);
               }

            }
            session_start();
            $_SESSION['userid'] = $userId;
            
            header('Location:profile.php');
        }else{
            header('Location:registration.php');
        }
    }


    public function login($email, $password){
        $hashedPass = sha1($password);
        $sql = 'SELECT user_id FROM user WHERE user_email = ? AND user_password = ?;';

        $stmt = DB_Connector::connect()->prepare($sql);
        $stmt->execute(array($email, $hashedPass));
        $row = $stmt->fetch();
        if($stmt->rowCount() > 0){
            return $row['user_id']; // user_id;
        }else{
            return -1;
        }
    }

}