<?php

require_once __DIR__ . '/../include/appTop.php';
require_once 'serviceSecurity.php';

class EnregistrementDefController {
private $connexion;
    public function __construct($mysql) {
        $this->connexion = $mysql;
    }

    public function saveAction(EnregistrementDef $enregDef = null): ?bool {

        $data = 'enreg_def_user_id_id, enreg_def_enreg_be_livre_num, enreg_def_num, enreg_def_objet, 
                enreg_def_titulaire, enreg_def_montant, enreg_def_service,
                enreg_def_date_crea, enreg_def_visa';
        $stmt = $this->connexion->prepare("INSERT INTO enregistrement_def  ($data) VALUES (?,?,?,?,?,?,?,?,?)");
        $reg = $stmt->execute(array($enregDef->getEnregDefUserId()->id, $enregDef->getEnregDefEnregBeLivreNum(), $enregDef->getEnregDefNum(), 
                                $enregDef->getEnregDefObjet(), $enregDef->getEnregDefTitulaire(), 
                                $enregDef->getEnregDefMontant(), $enregDef->getEnregDefService(), 
                                $enregDef->getEnregDefDateCrea(), $enregDef->getEnregDefVisa()
                                ));
        $stmt = null;
        return $reg;
    }

    public function updateAction(EnregistrementDef $enregDef = null): ?bool {

        $data = 'enreg_def_user_id_id = ?, enreg_def_enreg_be_livre_num=?, enreg_def_num = ?, enreg_def_objet = ?, 
                enreg_def_titulaire = ?, enreg_def_montant = ?, enreg_def_service = ?,
                enreg_def_date_crea = ?, enreg_def_visa = ?';
            
        $stmt = $this->connexion->prepare("UPDATE enregistrement_def SET $data WHERE enreg_def_enreg_be_livre_num= ?");
        $reg = $stmt->execute(array($enregDef->getEnregDefUserId()->id, $enregDef->getEnregDefEnregBeLivreNum(), $enregDef->getEnregDefNum(), 
                            $enregDef->getEnregDefObjet(), $enregDef->getEnregDefTitulaire(), 
                            $enregDef->getEnregDefMontant(), $enregDef->getEnregDefService(), 
                            $enregDef->getEnregDefDateCrea(), $enregDef->getEnregDefVisa(), $enregDef->getEnregDefEnregBeLivreNum()
                            ));
        $stmt = null;
        return $reg;
    }

    //Update DEF when reject
    public function updateDefWhenReject(EnregistrementDef $enregDef = null): ?bool {
        $data = 'enreg_def_motif_type= ?, enreg_def_motif_desc= ?, enreg_def_etat_rejeter= ?'; 
        $stmt = $this->connexion->prepare("UPDATE enregistrement_def SET $data WHERE enreg_def_enreg_be_livre_num= ?");
        $reg = $stmt->execute(array($enregDef->getEnregDefMotifType(), $enregDef->getEnregDefMotifDesc(),
                            $enregDef->getEnregDefEtatRejeter(), $enregDef->getEnregDefEnregBeLivreNum()
                            ));
        $stmt = null;
        return $reg;
    }

    //Update DEF when Vise
    public function updateDefWhenVise(EnregistrementDef $enregDef = null): ?bool {
        $data = 'enreg_def_etat_viser= ?, enreg_def_date_paraphe= ?'; 
        $stmt = $this->connexion->prepare("UPDATE enregistrement_def SET $data WHERE enreg_def_enreg_be_livre_num= ?");
        $reg = $stmt->execute(array($enregDef->getEnregDefEtatViser(), $enregDef->getEnregDefDateDaraphe(),
                            $enregDef->getEnregDefEnregBeLivreNum()
                            ));
        $stmt = null;
        return $reg;
    }

    //Update DEF when Etat vise after reject
    public function updateDefWhenViseAfterReject(EnregistrementDef $enregDef = null): ?bool {
        $data = 'enreg_def_etat_vise_after_reject= ?'; 
        $stmt = $this->connexion->prepare("UPDATE enregistrement_def SET $data WHERE enreg_def_enreg_be_livre_num= ?");
        $reg = $stmt->execute(array($enregDef->getEnregDefEtatViseAfterReject(), 
                            $enregDef->getEnregDefEnregBeLivreNum()
                            ));
        $stmt = null;
        return $reg;
    }

    //Update visa of DEF when add Tef
    public function updateVisaOfDefWhenAddTef(EnregistrementDef $enregDef = null): ?bool {
        $data = 'enreg_def_visa= ?'; 
        $stmt = $this->connexion->prepare("UPDATE enregistrement_def SET $data WHERE enreg_def_enreg_be_livre_num= ?");
        $reg = $stmt->execute(array($enregDef->getEnregDefVisa(), 
                            $enregDef->getEnregDefEnregBeLivreNum()
                            ));
        $stmt = null;
        return $reg;
    }

    public function findByIdAction(int $id): ?EnregistrementDef {

        $stmt = $this->connexion->prepare("SELECT * FROM enregistrement_def WHERE enreg_def_enreg_be_livre_num=?");
        $stmt->execute(array($id));
        $resArr = $stmt->fetchAll();
        if (count($resArr) == 0) {
            $stmt = null;
            return $stmt;
        }
        
        $serveSecurity = new ServiceSecurity($this->connexion);
        $user = $serveSecurity->getUserById((int) $resArr[0]['enreg_def_user_id_id']);
        $enregDef = new EnregistrementDef();
        $enregDef->setId($resArr[0]['id']);
        $enregDef->setEnregDefUserId($user);
        $enregDef->setEnregDefNum($resArr[0]['enreg_def_num']);
        $enregDef->setEnregDefEnregBeLivreNum($resArr[0]['enreg_def_enreg_be_livre_num']);
        $enregDef->setEnregDefObjet($resArr[0]['enreg_def_objet']);
        $enregDef->setEnregDefTitulaire($resArr[0]['enreg_def_titulaire']);
        $enregDef->setEnregDefMontant($resArr[0]['enreg_def_montant']);
        $enregDef->setEnregDefService($resArr[0]['enreg_def_service']);
        $enregDef->setEnregDefDateCrea($resArr[0]['enreg_def_date_crea']);
        $enregDef->setEnregDefVisa($resArr[0]['enreg_def_visa']);
        $stmt = null;
        return $enregDef;
    }

    // select Def by specific livre num
    public function selectAllAction():?array {

        $stmt = $this->connexion->prepare("SELECT * FROM `enregistrement_be` enreg INNER JOIN `enregistrement_def` enregdef  
                                        ON enreg.enreg_be_livre_num = enregdef.enreg_def_enreg_be_livre_num
                                        ORDER BY enregdef.enreg_def_enreg_be_livre_num DESC");
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