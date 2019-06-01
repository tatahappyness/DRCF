<?php

require_once __DIR__.'/../include/appTop.php';
require_once 'serviceSecurity.php';
require_once 'enregistrementBeController.php';

class LectureDossierController {
private $connexion;
    public function __construct($mysql) {
        $this->connexion = $mysql;
    }

    public function saveAction(LectureDossier $lectureDos = null): ?bool {

        $data = 'lect_dos_enreg_be_id_id, lect_dos_user_id_id, lect_dos_situation, lect_dos_paraphe_date_crea';

        $stmt = $this->connexion->prepare("INSERT INTO lecture_dossier  ($data) VALUES (?,?,?,?)");
        $reg = $stmt->execute(array($lectureDos->getLectDosEnregBeId()->id, $lectureDos->getLectDosUserId()->id, 
                                $lectureDos->getLectDosSituation(), $lectureDos->getLectDosParapheDateCrea()
                              ));
        $stmt = null;
        return $reg;
    }

    public function updateAction(LectureDossier $lectureDos = null): ?bool {

        $data = 'lect_dos_enreg_be_id_id = ?, lect_dos_user_id_id = ?, lect_dos_situation = ?, lect_dos_paraphe_date_crea = ?';
            
        $stmt = $this->connexion->prepare("UPDATE lecture_dossier SET $data WHERE id = ?");
        $reg = $stmt->execute(array($lectureDos->getLectDosEnregBeId()->id, $lectureDos->getLectDosUserId()->id, 
            $lectureDos->getLectDosSituation(), $lectureDos->getLectDosParapheDateCrea(), 1
        )); //$lectureDos->getId()
        $stmt = null;
        return $reg;
    }

    public function getLectureDossierById(int $id): ?LectureDossier {

        $stmt = $this->connexion->prepare("SELECT * FROM lecture_dossier WHERE id=?");
        $stmt->execute(array($id));
        $resArr = $stmt->fetchAll();
        if (count($resArr) == 0) {
            $stmt = null;
            return $stmt;
        }
        
        $serveSecurity = new ServiceSecurity($this->connexion);
        $enregBeControl = new EnregistrementBeController($this->connexion);
        $user = $serveSecurity->getUserById((int) $resArr[0]['lect_dos_user_id_id']);
        $enregBe = $enregBeControl->findByIdAction((int) $resArr[0]['lect_dos_enreg_be_id_id']);

        $lectureDos = new LectureDossier();
        $lectureDos->setId((int) $id);
        $lectureDos->setLectDosUserId($user);
        $lectureDos->setLectDosEnregBeId($enregBe);
        $lectureDos->setLectDosSituation($resArr[0]['lect_dos_situation']);
        $lectureDos->setLectDosParapheDateCrea($resArr[0]['lect_dos_paraphe_date_crea']);
        $stmt = null;
        return $lectureDos;
    }

    public function selectAllAction():?array {

        $stmt = $this->connexion->prepare("SELECT * FROM `user` us
                                            INNER JOIN `lecture_dossier` lect
                                            INNER JOIN `enregistrement_be` enreg 
                                            ON us.id = lect.lect_dos_user_id_id
                                            AND lect.lect_dos_enreg_be_id_id = enreg.id
                                            WHERE enreg.enreg_be_etat_lire IS NOT NULL ORDER BY lect.lect_dos_enreg_be_id_id DESC ");
        $stmt->execute();
        $resArr = $stmt->fetchAll();
        if (count($resArr) == 0) {
            $stmt = null;
            return $stmt;
        }
        $stmt = null;
        //print_r($resArr[0]);die;
        return $resArr;
    }
    
}