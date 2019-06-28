<?php


class ImageModel
{
    private $image_id;
    private $user_id;
    private $status;

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

    public function add($user_id, $status){
        $sql = 'INSERT INTO image (user_id,status) VALUES (:usr, :st);';

        $stmt = DB_Connector::connect()->prepare($sql);
        $stmt->execute(array('usr' => $user_id,
            'st' =>$status));

        if($stmt->rowCount() > 0){
            header('Location:profile.php');
        }else{
            header('Location:registration.php');
        }
    }


}