<?php

require_once __DIR__ . '/../include/appTop.php';
require_once 'serviceSecurity.php';

class TefController {
private $connexion;
    public function __construct($mysql) {
        $this->connexion = $mysql;
    }

    public function saveAction(EnregistrementTef $enregTef = null): ?bool {

        $data = 'enreg_tef_user_id, enreg_tef_enreg_be_livre_num, enreg_tef_enreg_be_num, enreg_tef_num, 
        enreg_tef_objet, enreg_tef_num_visa, enreg_tef_date, enreg_tef_date_crea, enreg_tef_etat';
        $stmt = $this->connexion->prepare("INSERT INTO `enregistrement_tef` ($data) VALUES (?,?,?,?,?,?,?)");
        $reg = $stmt->execute(array($enregTef->getEnregTefUserId()->id, $enregTef->getEnregTefEnregBeLivreNum(),
                                $enregTef->getEnregTefEnregBeNum(), $enregTef->getEnregTefNum(), 
                                $enregTef->getEnregTefObjet(), $enregTef->getEnregTtefNumVisa(), 
                                $enregTef->getEnregTefDate(), $enregTef->getEnregTefDateCrea(), 
                                $enregTef->getEnregTefEtat()
                                ));
        $stmt = null;
        return $reg;
    }

    public function updateAction(EnregistrementTef $enregTef = null): ?bool {

        $data = 'enreg_tef_user_id = ?, enreg_tef_enreg_be_livre_num =?, enreg_tef_enreg_be_num = ?, enreg_tef_num = ?, 
        enreg_tef_objet = ?, enreg_tef_date_crea = ?, enreg_tef_etat = ?';
            
        $stmt = $this->connexion->prepare("UPDATE `enregistrement_tef` SET $data WHERE enreg_tef_enreg_be_livre_num= ?");
        $reg = $stmt->execute(array($enregTef->getEnregTefUserId()->id, $enregTef->getEnregTefEnregBeLivreNum(), $enregTef->getEnregDefNum(), 
                        $enregTef->getEnregTefEnregBeNum(), $enregTef->getEnregTefObjet(), 
                        $enregTef->getEnregTefDateCrea(), $enregTef->getEnregTefEtat(),
                        $enregTef->getEnregTefEnregBeLivreNum()
                        ));
        $stmt = null;
        return $reg;
    }
    // update for etat only
    public function updateEtatDef(EnregistrementTef $enregTef = null): ?bool {

        $data = 'enreg_tef_etat= ?';
            
        $stmt = $this->connexion->prepare("UPDATE `enregistrement_tef` SET $data WHERE enreg_tef_enreg_be_livre_num= ?");
        $reg = $stmt->execute(array($enregTef->getEnregTefEtat(),
                            $enregDef->getEnregTefEnregBeLivreNum()
                            ));
        $stmt = null;
        return $reg;
    }

    public function findByIdAction(int $id): ?EnregistrementTef {

        $stmt = $this->connexion->prepare("SELECT * FROM `enregistrement_tef` WHERE enreg_tef_enreg_be_livre_num=?");
        $stmt->execute(array($id));
        $resArr = $stmt->fetchAll();
        if (count($resArr) == 0) {
            $stmt = null;
            return $stmt;
        }
        
        $serveSecurity = new ServiceSecurity($this->connexion);
        $user = $serveSecurity->getUserById((int) $resArr[0]['enreg_tef_user_id']);
        $enregTef = new EnregistrementTef();
        $enregTef->setEnregTefEnregBeLivreNum((int) $resArr[0]['enreg_def_enreg_be_livre_num']);
        $enregTef->setEnregTefUserId($user);
        $enregTef->setEnregTefEnregBeNum($resArr[0]['enreg_tef_enreg_be_num']);
        $enregTef->setEnregTefNum($resArr[0]['enreg_tef_num']);
        $enregTef->setEnregTefObjet($resArr[0]['enreg_tef_objet']);
        $enregTef->setEnregTefDateCrea($resArr[0]['enreg_tef_date_crea']);
        $enregTef->setEnregTefEtat( (bool) $resArr[0]['enreg_tef_etat']);
        $stmt = null;
        return $enregDef;
    }

    // select Tef by specific livre num
    public function selectAllAction():?array {

        $stmt = $this->connexion->prepare("SELECT * FROM `enregistrement_be` enreg INNER JOIN `enregistrement_tef` enregtef
                                        ON enreg.enreg_be_livre_num = enregtef.enreg_tef_enreg_be_livre_num
                                        ORDER BY enregtef.enreg_tef_enreg_be_livre_num DESC");
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