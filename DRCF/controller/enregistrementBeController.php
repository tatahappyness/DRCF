<?php

require_once __DIR__.'/../include/appTop.php';
require_once 'serviceSecurity.php';

class EnregistrementBeController {
   private $connexion;
    public function __construct($mysql) {
        $this->connexion = $mysql;
    }

    public function saveAction(EnregistrementBe $be = null): ?bool {

        $data = 'enreg_be_user_id_id, enreg_be_num, enreg_be_date, enreg_be_serv_titulaire, 
                 enreg_be_contenu, enreg_beobserve, enreg_be_date_crea, enreg_be_livre_num,
                 enreg_be_serv_lieu';
        //var_dump($be->getEnregBeDateCrea());die;
        $stmt = $this->connexion->prepare("INSERT INTO enregistrement_be  ($data) VALUES (?,?,?,?,?,?,?,?,?)");
        $reg = $stmt->execute(array($be->getEnregBeUserId()->id, $be->getEnregBeNum(), $be->getEnregBeDate(),
                        $be->getEnregBeServTitulaire(), $be->getEnregBeContenu(),   
                        $be->getEnregBeobserve(), $be->getEnregBeDateCrea(),
                        $be->getEnregBeLivreNum(), $be->getEnregBeServLieu()
                        ));
        $stmt = null;
        return $reg;
    }

    public function updateAction(EnregistrementBe $be = null): ?bool {

       //print_r($be->getEnregBeEtatVerifier());die;
        $data = 'enreg_be_user_id_id = ?, enreg_be_num = ?, enreg_be_date= ?,
                enreg_be_serv_titulaire = ?, enreg_be_contenu = ?, enreg_beobserve = ?, 
                enreg_be_date_crea = ?, enreg_be_livre_num = ?, enreg_be_serv_lieu = ?, 
                enreg_be_etat_lire = ?, enreg_be_etat_verifier = ?,
                enreg_be_etat_rejeter = ?, enreg_be_etat_viser = ?, enreg_be_etat_visa = ?';
            
        $stmt = $this->connexion->prepare("UPDATE enregistrement_be SET $data WHERE id = ?");
        $reg = $stmt->execute(array( $be->getEnregBeUserId()->id,  $be->getEnregBeNum(), $be->getEnregBeDate(),
                        $be->getEnregBeServTitulaire(),  $be->getEnregBeContenu(),   
                        $be->getEnregBeobserve(),  $be->getEnregBeDateCrea(),   
                        $be->getEnregBeLivreNum(), $be->getEnregBeServLieu(),$be->getEnregBeEtatLire(),
                        $be->getEnregBeEtatVerifier(), $be->getEnregBeEtatRejeter(), 
                        $be->getEnregBeEtatViser(), $be->getEnregBeEtatVisa(), $be->getId()
                        )); //$be->getId()
        $stmt = null;
        return $reg;
    }
    
    // Update Etat Be After Reject when rectification by usung livre num clause
    public function updateEtatVerifAfterRejet(EnregistrementBe $be = null): ?bool {
      // die((string) $be->getId());
        $data = 'enreg_be_etat_verif_after_rejet = ?';
        $stmt = $this->connexion->prepare("UPDATE enregistrement_be SET $data WHERE id = ?");
        $reg = $stmt->execute(array($be->getEnregBeEtatVerifAfterRejet(), 
                                    $be->getId()
                                ));
        $stmt = null;
        return $reg;
    }

    public function updateEtatViseAfterRejet(EnregistrementBe $be = null): ?bool {
        $data = 'enreg_be_etat_vise_after_rejet = ?, enreg_be_etat_rejeter = ?';
        $stmt = $this->connexion->prepare("UPDATE enregistrement_be SET $data WHERE id = ?");
        $reg = $stmt->execute(array($be->getEnregBeEtatViseAfterRejet(), $be->getEnregBeEtatRejeter(),
                                    $be->getId()
                                ));
        $stmt = null;
        return $reg;
    }

    //update etat beteen delegate and cheker
    public function updateEtatBetweenDelegateAndChek(EnregistrementBe $be = null): ?bool {
        $data = 'enreg_be_etat_between_deleg_chek = ?';
        $stmt = $this->connexion->prepare("UPDATE enregistrement_be SET $data WHERE id = ?");
        $reg = $stmt->execute(array($be->getEnregBeEtatBetweenDelegChek(),
                                    $be->getId()
                                ));
        $stmt = null;
        return $reg;
    }


    public function findByIdAction(int $id): ?EnregistrementBe {

        $stmt = $this->connexion->prepare("SELECT * FROM enregistrement_be WHERE id=?");
        $stmt->execute(array($id));
        $resArr = $stmt->fetchAll();
        if (count($resArr) == 0) {
            $stmt = null;
            return $stmt;
        }
        
        $serveSecurity = new ServiceSecurity($this->connexion);
        $user = $serveSecurity->getUserById((int) $resArr[0]['enreg_be_user_id_id']);
        $enregBe = new EnregistrementBe();
        $enregBe->setId($resArr[0]['id']);
        $enregBe->setEnregBeUserId($user);
        $enregBe->setEnregBeNum($resArr[0]['enreg_be_num']);
        $enregBe->setEnregBeDate($resArr[0]['enreg_be_date']);
        $enregBe->setEnregBeServTitulaire($resArr[0]['enreg_be_serv_titulaire']);
        $enregBe->setEnregBeContenu($resArr[0]['enreg_be_contenu']);
        $enregBe->setEnregBeobserve($resArr[0]['enreg_beobserve']);
        $enregBe->setEnregBeDateCrea($resArr[0]['enreg_be_date_crea']);
        $enregBe->setEnregBeLivreNum($resArr[0]['enreg_be_livre_num']);
        $enregBe->setEnregBeServLieu($resArr[0]['enreg_be_serv_lieu']);
        $enregBe->setEnregBeEtatlire((bool) $resArr[0]['enreg_be_etat_lire']);
        $enregBe->setEnregBeEtatVerifier((bool) $resArr[0]['enreg_be_etat_verifier']);
        $enregBe->setEnregBeEtatRejeter((bool) $resArr[0]['enreg_be_etat_rejeter']);
        $enregBe->setEnregBeEtatViser((bool) $resArr[0]['enreg_be_etat_viser']);
        $enregBe->setEnregBeEtatVisa((bool) $resArr[0]['enreg_be_etat_visa']);
        $stmt = null;
        //print_r($enregBe);die;
        return $enregBe;
    }

    //Find by numBE
    public function findByLivreNumBeAction(int $num): ?EnregistrementBe {

        $stmt = $this->connexion->prepare("SELECT * FROM enregistrement_be WHERE enreg_be_livre_num=?");
        $stmt->execute(array($num));
        $resArr = $stmt->fetchAll();
        if (count($resArr) == 0) {
            $stmt = null;
            return $stmt;
        }
        
        $serveSecurity = new ServiceSecurity($this->connexion);
        $user = $serveSecurity->getUserById((int) $resArr[0]['enreg_be_user_id_id']);
        $enregBe = new EnregistrementBe();
        $enregBe->setId($resArr[0]['id']);
        $enregBe->setEnregBeUserId($user);
        $enregBe->setEnregBeNum($resArr[0]['enreg_be_num']);
        $enregBe->setEnregBeDate($resArr[0]['enreg_be_date']);
        $enregBe->setEnregBeServTitulaire($resArr[0]['enreg_be_serv_titulaire']);
        $enregBe->setEnregBeContenu($resArr[0]['enreg_be_contenu']);
        $enregBe->setEnregBeobserve($resArr[0]['enreg_beobserve']);
        $enregBe->setEnregBeDateCrea($resArr[0]['enreg_be_date_crea']);
        $enregBe->setEnregBeLivreNum($resArr[0]['enreg_be_livre_num']);
        $enregBe->setEnregBeServLieu($resArr[0]['enreg_be_serv_lieu']);
        $enregBe->setEnregBeEtatlire((bool) $resArr[0]['enreg_be_etat_lire']);
        $enregBe->setEnregBeEtatVerifier((bool) $resArr[0]['enreg_be_etat_verifier']);
        $enregBe->setEnregBeEtatRejeter((bool) $resArr[0]['enreg_be_etat_rejeter']);
        $enregBe->setEnregBeEtatViser((bool) $resArr[0]['enreg_be_etat_viser']);
        $enregBe->setEnregBeEtatVisa((bool) $resArr[0]['enreg_be_etat_visa']);
        $stmt = null;
        return $enregBe;
    }

    public function selectAllAction():?array {

        $stmt = $this->connexion->prepare("SELECT * FROM user us
                                        INNER JOIN enregistrement_be enreg 
                                        ON us.id = enreg.enreg_be_user_id_id ORDER BY enreg.id DESC");
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