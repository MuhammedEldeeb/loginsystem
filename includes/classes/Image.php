<?php

class Image{
    private $name;
    private $tmp_name;
    private $size;
    private $error;
    private $type;
    private $imageActualExt;

    public function __construct($name, $tmp_name, $size, $error, $type)
    {
        $this->name = $name;
        $this->tmp_name = $tmp_name;
        $this->size = $size;
        $this->error = $error;
        $this->type = $type;

        $imageExt = explode('.' , $this->name);
        $this->imageActualExt = strtolower(end($imageExt));

    }


    public function isAllowed(){
        $allowed = array('jpg', 'jpeg', 'png');
        if(in_array($this->imageActualExt , $allowed)){
            return true;
        }else{
            return false;
        }
    }

    public function imageExists(){
        if($this->error == 4){
            return false;
        }else{
            return true;
        }
    }

    public function upload($imgId){
        $newName = $imgId . "." . $this->imageActualExt;
        $destination = 'uploads/'. $newName;
        move_uploaded_file($this->tmp_name, $destination);      
    }

    public function getName()
    {
        return $this->name;
    }

    public function getImageActualExt()
    {
        return $this->imageActualExt;
    }

    public function getTmpName()
    {
        return $this->tmp_name;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setName($name)
    {
        $this->name = $name;
    }


}