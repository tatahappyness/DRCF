<?php

require_once __DIR__ . '/../include/appTop.php';
require_once 'serviceSecurity.php';

class AffectationDossierController {
private $connexion;
    public function __construct($mysql) {
        $this->connexion = $mysql;
    }

    public function saveAction(AffectationDossier $affectDos = null): ?bool {

        $data = 'affect_dos_enreg_be_livre_num, affect_dos_enreg_be_num, affect_dos_date_crea,
         affect_dos_user_id, affect_dos_user_id_exp, affect_dos_etat, affect_dos_etat_acceptation';
        $stmt = $this->connexion->prepare("INSERT INTO affectation_dossier  ($data) VALUES (?,?,?,?,?,?,?)");
        $reg = $stmt->execute(array($affectDos->getAffectDosEnregBeLivreNum(), 
                               $affectDos->getAffectDosEnregBeNum(), $affectDos->getAffectDosDateCrea(),
                                $affectDos->getAffectDosUserId()->id, $affectDos->getAffectDosUserIdExp()->id, 
                                $affectDos->getAffectDosEtat(), $affectDos->getAffectDosEtatAcceptation()
                                ));
        $stmt = null;
        return $reg;
    }

    public function updateAction(AffectationDossier $affectDos = null): ?bool {

        $data = 'affect_dos_enreg_be_livre_num = ?, affect_dos_enreg_be_num = ?, 
                 affect_dos_date_crea = ?, affect_dos_user_id = ?, affect_dos_user_id_exp = ?, 
                 affect_dos_etat = ?, affect_dos_etat_acceptation = ?';
            
        $stmt = $this->connexion->prepare("UPDATE affectation_dossier SET $data WHERE affect_dos_enreg_be_livre_num= ?");
        $reg = $stmt->execute(array($affectDos->getAffectDosEnregBeLivreNum(), 
        $affectDos->getAffectDosEnregBeNum(), $affectDos->getAffectDosDateCrea(), 
        $affectDos->getAffectDosUserId(), $affectDos->getAffectDosUserIdExp(),
        $affectDos->getAffectDosEtat(),  $affectDos->getAffectDosEtatAcceptation(), $affectDos->getAffectDosEnregBeLivreNum()
                            ));
        $stmt = null;
        return $reg;
    }
    // update for etat only
    public function updateAffectEtatAcceptation(AffectationDossier $affectDos = null): ?bool {

        $data = 'affect_dos_etat_Acceptation= ?';
            
        $stmt = $this->connexion->prepare("UPDATE affectation_dossier SET $data WHERE affect_dos_enreg_be_livre_num= ?");
        $reg = $stmt->execute(array($affectDos->getAffectDosEtatAcceptation(), 
                            $affectDos->getAffectDosEnregBeLivreNum()
                            ));
        $stmt = null;
        return $reg;
    }

    public function findByIdAction(int $id): ?AffectationDossier {

        $stmt = $this->connexion->prepare("SELECT * FROM affectation_dossier WHERE affect_dos_enreg_be_livre_num=?");
        $stmt->execute(array($id));
        $resArr = $stmt->fetchAll();
        if (count($resArr) == 0) {
            $stmt = null;
            return $stmt;
        }
        
        $serveSecurity = new ServiceSecurity($this->connexion);
        $user = $serveSecurity->getUserById((int) $resArr[0]['affect_dos_user_id']);
        $userExp = $serveSecurity->getUserById((int) $resArr[0]['affect_dos_user_id_exp']);
        $affectDos = new AffectationDossier();
        $affectDos->setId((int) $id);
        $affectDos->setAffectDosUserId($user);
        $affectDos->setAffectDosUserIdExp($userExp);
        $affectDos->setAffectDosEnregBeLivreNum($resArr[0]['affect_dos_enreg_be_livre_num']);
        $affectDos->setAffectDosEnregBeNum($resArr[0]['affect_dos_enreg_be_num']);
        $affectDos->setAffectDosDateCrea($resArr[0]['affect_dos_date_crea']);
        $affectDos->setAffectDosEtat((bool) $resArr[0]['affect_dos_etat']);
        $stmt = null;
        return $enregDef;
    }

    // select Def by specific livre num
    public function selectAllAction():?array {

        $stmt = $this->connexion->prepare("SELECT * FROM `user` us INNER JOIN `enregistrement_be` enreg
                                            INNER JOIN `affectation_dossier` affect
                                            ON us.id = enreg.enreg_be_user_id_id
                                            AND  enreg.enreg_be_livre_num = affect.affect_dos_enreg_be_livre_num
                                            ORDER BY enreg.enreg_be_livre_num DESC;");
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

    // select Def by specific livre num
    public function selectAllAffectationOnly():?array {

        $stmt = $this->connexion->prepare("SELECT * FROM affectation_dossier
                                            ORDER BY affect_dos_enreg_be_livre_num ASC");
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