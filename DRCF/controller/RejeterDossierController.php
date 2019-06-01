<?php

require_once __DIR__.'/../include/appTop.php';
require_once 'serviceSecurity.php';
require_once 'enregistrementBeController.php';

class RejeterDossierController {
private $connexion;
    public function __construct($mysql) {
        $this->connexion = $mysql;
    }

    public function saveAction(RejeterDossier $rejetDos = null): ?bool {

        $data = 'rejet_dos_enreg_be_id_id, rejet_dos_user_id, rejet_dos_date_crea,
                 rejet_dos_motif_desc, rejet_dos_motif_type';

        $stmt = $this->connexion->prepare("INSERT INTO rejeter_dossier  ($data) VALUES (?,?,?,?,?)");
        $reg = $stmt->execute(array($rejetDos->getRejetDosEnregBeId()->id, $rejetDos->getRejetDosUserId()->id, 
                                    $rejetDos->getRejetDosDateCrea(), $rejetDos->getRejetDosMotifDesc(),
                                    $rejetDos->getRejetDosMotifType()
                                ));
        $stmt = null;
        return $reg;
    }

    public function updateAction(RejeterDossier $rejetDos = null): ?bool {

        $data = 'rejet_dos_enreg_be_id_id = ?, rejet_dos_user_id = ?, rejet_dos_date_crea = ?,
                    rejet_dos_motif_desc, rejet_dos_motif_type';
            
        $stmt = $this->connexion->prepare("UPDATE rejeter_dossier SET $data WHERE id = ?");
        $reg = $stmt->execute(array($rejetDos->getRejetDosEnregBeId()->id, $rejetDos->getRejetDosUserId()->id, 
            $rejetDos->getRejetDosDateCrea(), $rejetDos->getRejetDosMotifDesc(),
            $rejetDos->getRejetDosMotifType(), 1
        )); //$rejetDos->getId()
        $stmt = null;
        return $reg;
    }

    public function findByIdAction(int $id): ?RejeterDossier {

        $stmt = $this->connexion->prepare("SELECT * FROM rejeter_dossier WHERE id=?");
        $stmt->execute(array($id));
        $resArr = $stmt->fetchAll();
        if (count($resArr) == 0) {
            $stmt = null;
            return $stmt;
        }
        
        $serveSecurity = new ServiceSecurity($this->connexion);
        $enregBeControl = new EnregistrementBeController($this->connexion);
        $user = $serveSecurity->getUserById((int) $resArr[0]['rejet_dos_user_id']);
        $enregBe = $enregBeControl->findByIdAction((int) $resArr[0]['rejet_dos_enreg_be_id_id']);

        $rejetDos = new RejeterDossier();
        $rejetDos->setId((int) $id);
        $rejetDos->setRejetDosUserId($user);
        $rejetDos->setRejetDosEnregBeId($enregBe);
        $rejetDos->setRejetDosDateCrea($resArr[0]['rejet_dos_date_crea']);
        $rejetDos->setRejetDosMotifDesc($resArr[0]['rejet_dos_motif_desc']);
        $rejetDos->setRejetDosMotifType($resArr[0]['rejet_dos_motif_type']);
        $stmt = null;
        return $rejetDos;
    }

    public function selectAllAction():?array {

        $stmt = $this->connexion->prepare("SELECT * FROM `user` us
                                            INNER JOIN `rejeter_dossier` rejet
                                            INNER JOIN  `enregistrement_be` enreg 
                                            ON us.id =  rejet.rejet_dos_user_id 
                                            AND rejet.rejet_dos_enreg_be_id_id = enreg.id
                                            WHERE enreg.enreg_be_etat_rejeter IS NOT NULL ORDER BY rejet.rejet_dos_enreg_be_id_id DESC ");
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