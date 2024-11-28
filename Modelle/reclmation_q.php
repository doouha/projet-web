<?php
class Reclamation {
    private ?int $id_reclamation = NULL;
    private ?int $id_client = NULL;
    private ?string $contenue = NULL;
    private ?string $date = NULL;

    
    public function __construct(?int $id_reclamation, ?int $id_client, ?string $contenue, ?string $date) {
        $this->id_reclamation = $id_reclamation;
        $this->id_client = $id_client;
        $this->contenue = $contenue;
        $this->date = $date;
    }

    public function getIdReclamation() {
        return $this->id_reclamation;
    }

    public function setIdReclamation($id_reclamation) {
        $this->id_reclamation = $id_reclamation;
        return $this;
    }

    public function getIdClient(){
        return $this->id_client;
    }

    public function setIdClient($id_client) {
        $this->id_client = $id_client;
        return $this;
    }

    public function getContenue() {
        return $this->contenue;
    }

    public function setContenue($contenue) {
        $this->contenue = $contenue;
        return $this;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date){
        $this->date = $date;
        return $this;
    }
 
}




?>