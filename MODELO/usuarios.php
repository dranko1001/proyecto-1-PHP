<?php


class usuarios {
    

    private $nombre;
    private $id;
    

    public function __construct() {
    }
    

    public function setNombre($nombre) {
        $this->nombre = "$nombre";
    }
    

    public function getNombre() {
        return $this->nombre;
    }
        public function setId($id){
        $this->id = "$id";
    }
    

    public function getId() {
        return $this->id;
    }


}

?>