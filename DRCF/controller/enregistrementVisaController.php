<?php

require_once __DIR__.'/../include/appTop.php';
require_once 'serviceSecurity.php';
require_once 'enregistrementBeController.php';

class EnregistrementVisaController {
private $connexion;
    public function __construct($mysql) {
        $this->connexion = $mysql;
    }

    public function saveAction(EnregistrementVisa $enregVisa = null): ?bool 
    {

        $data = 'enreg_visa_user_id_id, enreg_visa_enreg_be_id_id, enreg_visa_livre_num, 
                enreg_visa_livre_date_crea, enreg_visa_num, enreg_visa_date';

        $stmt = $this->connexion->prepare("INSERT INTO enregistrement_visa  ($data) VALUES (?,?,?,?,?,?)");
        $reg = $stmt->execute(array($enregVisa->getEnregVisaUserId()->id, $enregVisa->getEnregVisaEnregBeId()->id, 
                        $enregVisa->getEnregVisaLivreNum(), $enregVisa->getEnregVisaLivreDateCrea(), 
                        $enregVisa->getEnregVisaNum(), $enregVisa->getEnregVisaDate()
                        ));
        $stmt = null;
        return $reg;
    }

    public function updateAction(EnregistrementVisa $enregVisa = null): ?bool
    {

        $data = 'enreg_visa_user_id_id = ?, enreg_visa_enreg_be_id_id = ?, enreg_visa_livre_num = ?, 
        enreg_visa_livre_date_crea = ?, enreg_visa_num, enreg_visa_date = ?';
            
        $stmt = $this->connexion->prepare("UPDATE enregistrement_visa SET $data WHERE id = ?");
        $reg = $stmt->execute(array($enregVisa->getEnregVisaUserId()->id, $enregVisa->getEnregVisaEnregBeId()->id, 
        $enregVisa->getEnregVisaLivreNum(), $enregVisa->getEnregVisaLivreDateCrea(), 
        $enregVisa->getEnregVisaNum(), $enregVisa->getEnregVisaDate(), 1
        )); //$enregVisa->getId()
        $stmt = null;
        return $reg;
    }

    public function findByIdAction(int $id): ?EnregistrementVisa {

        $stmt = $this->connexion->prepare("SELECT * FROM enregistrement_visa WHERE id=?");
        $stmt->execute(array($id));
        $resArr = $stmt->fetchAll();
        if (count($resArr) == 0) {
            $stmt = null;
            return $stmt;
        }
        
        $serveSecurity = new ServiceSecurity($this->connexion);
        $enregBeControl = new EnregistrementBeController($this->connexion);
        $user = $serveSecurity->getUserById((int) $resArr[0]['enreg_visa_user_id_id']);
        $enregBe = $enregBeControl->findByIdAction((int) $resArr[0]['enreg_visa_enreg_be_id_id']);

        $enregVisa = new EnregistrementVisa();
        $enregVisa->setId((int) $id);
        $enregVisa->setEnregVisaEnregBeId($enregBe);
        $enregVisa->setEnregVisaUserId($user);
        $enregVisa->setEnregVisaLivreNum($resArr[0]['enreg_visa_livre_num']);
        $enregVisa->setEnregVisaLivreDateCrea($resArr[0]['enreg_visa_livre_date_crea']);
        $enregVisa->setEnregVisaNum($resArr[0]['enreg_visa_num']);
        $enregVisa->setEnregVisaDate($resArr[0]['enreg_visa_date']);
        $stmt = null;
        return $enregVisa;
    }

    public function selectAllAction():?array {

        $stmt = $this->connexion->prepare("SELECT * FROM `enregistrement_be` enreg 
                                        INNER JOIN `enregistrement_visa` enregvisa
                                        INNER JOIN `user` us 
                                        ON enreg.id = enregvisa.enreg_visa_enreg_be_id_id 
                                        AND enregvisa.enreg_visa_user_id_id = us.id 
                                        WHERE enreg.enreg_be_etat_visa IS NOT NULL ORDER BY enregvisa.enreg_visa_enreg_be_id_id DESC");
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