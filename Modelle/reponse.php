<?php
class Reponse {
    private ?int $id_reponse = NULL;
    private ?string $reponse = NULL;
    private ?string $date = NULL;
    private ?int $id_reclamation = NULL; 
    public function __construct(?int $id_reponse, ?string $reponse, ?string $date, ?int $id_reclamation) {
        $this->id_reponse = $id_reponse;
        $this->reponse = $reponse;
        $this->date = $date;
        $this->id_reclamation = $id_reclamation; 
    }
    public function getIdReponse() {
        return $this->id_reponse;
    }
    public function setIdReponse(?int $id_reponse) {
        $this->id_reponse = $id_reponse;
        return $this;
    }
    public function getReponse() {
        return $this->reponse;
    }
    public function setReponse(?string $reponse) {
        $this->reponse = $reponse;
        return $this;
    }
    public function getDate() {
        return $this->date;
    }
    public function setDate(?string $date) {
        $this->date = $date;
        return $this;
    }

    public function getIdReclamation() {
        return $this->id_reclamation;
    }

    public function setIdReclamation(?int $id_reclamation) {
        $this->id_reclamation = $id_reclamation;
        return $this;
    }
}
?>
