<?php


class ImageModel
{
    private $image_id;
    private $user_id;
    private $status;
    private $ext;

    public function findByUserID($userId)
    {
        $sql = 'SELECT * FROM image WHERE user_id = ?;';

        $stmt = DB_Connector::connect()->prepare($sql);

        $stmt->execute(array($userId));
        $row = $stmt->fetch();
        if($stmt->rowCount() > 0){
            $this->image_id = $row['image_id'];
            $this->user_id = $row['user_id'];
            $this->status = $row['status'];
            $this->ext = $row['ext'];
            return $this->image_id;
        }
        return -1;
    }

    public function update($user_id, $status){
        $sql = 'UPDATE image SET status = ? WHERE user_id = ?;';

        $stmt = DB_Connector::connect()->prepare($sql);
        $stmt->execute(array($status, $user_id));

        if($stmt->rowCount() > 0){
            header('Location:profile.php');
        }else{
            header('Location:logout.php');
        }
    }

    public function add($user_id, $status = 0 , $ext = " "){
        $sql = 'INSERT INTO image (user_id,status,ext) VALUES (:usr, :st, :ex);';

        $stmt = DB_Connector::connect()->prepare($sql);
        $stmt->execute(array('usr' => $user_id,
            'st' =>$status,
            'ex' =>$ext));

        if($stmt->rowCount() > 0){
            header('Location:profile.php');
        }else{
            header('Location:registration.php');
        }
    }

    public function getImageId(){
        return $this->image_id;
    }
    public function getUserId(){
        return $this->user_id;
    }
    public function getStatus(){
        return $this->status;
    }
    public function getExt(){
        return $this->ext;
    }

}