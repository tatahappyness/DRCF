<?php

require_once __DIR__.'/../include/appTop.php';
require_once 'serviceSecurity.php';
require_once 'enregistrementBeController.php';

class ViserDossierController {
private $connexion;
    public function __construct($mysql) {
        $this->connexion = $mysql;
    }

    public function saveAction(ViserDossier $viseDos = null): ?bool {

        $data = 'vise_dos_user_id_id, vise_dos_enreg_be_id_id, vise_dos_date_crea';

        $stmt = $this->connexion->prepare("INSERT INTO viser_dossier  ($data) VALUES (?,?,?)");
        $reg = $stmt->execute(array($viseDos->getViseDosUserId()->id, $viseDos->getViseDosEnregBeId()->id, 
                                    $viseDos->getViseDosDateCrea()
                                ));
        $stmt = null;
        return $reg;
    }

    public function updateAction(ViserDossier $lectureDos = null): ?bool {

        $data = 'vise_dos_user_id_id = ?, vise_dos_enreg_be_id_id = ?, vise_dos_date_crea = ?';
            
        $stmt = $this->connexion->prepare("UPDATE viser_dossier SET $data WHERE id = ?");
        $reg = $stmt->execute(array($viseDos->getViseDosUserId()->id, $viseDos->getViseDosEnregBeId()->id, 
            $viseDos->getViseDosDateCrea(), 1
        )); //$lectureDos->getId()
        $stmt = null;
        return $reg;
    }

    public function findByIdAction(int $id): ?ViserDossier {

        $stmt = $this->connexion->prepare("SELECT * FROM viser_dossier WHERE id=?");
        $stmt->execute(array($id));
        $resArr = $stmt->fetchAll();
        if (count($resArr) == 0) {
            $stmt = null;
            return $stmt;
        }
        
        $serveSecurity = new ServiceSecurity($this->connexion);
        $enregBeControl = new EnregistrementBeController($this->connexion);
        $user = $serveSecurity->getUserById((int) $resArr[0]['vise_dos_user_id_id']);
        $enregBe = $enregBeControl->findByIdAction((int) $resArr[0]['vise_dos_enreg_be_id_id']);

        $viseDos = new ViserDossier();
        $viseDos->setId((int) $id);
        $viseDos->setViseDosUserId($user);
        $viseDos->setViseDosEnregBeId($enregBe);
        $viseDos->setViseDosDateCrea($resArr[0]['vise_dos_date_crea']);
        $stmt = null;
        return $viseDos;
    }

    public function selectAllAction():?array {

        $stmt = $this->connexion->prepare("SELECT * FROM `enregistrement_be` enreg 
                                            INNER JOIN `viser_dossier` vise
                                            INNER JOIN `user` us 
                                            ON enreg.id = vise.vise_dos_enreg_be_id_id 
                                            AND vise.vise_dos_user_id_id = us.id 
                                            WHERE enreg.enreg_be_etat_viser IS NOT NULL ORDER BY vise.vise_dos_enreg_be_id_id DESC ");
        $stmt->execute();
        $resArr = $stmt->fetchAll();
        if (count($resArr) == 0) {
            $stmt = null;
            return $stmt;
        }
        $stmt = null;
        //print_r($resArr);die;
        return $resArr;
    }
    
}