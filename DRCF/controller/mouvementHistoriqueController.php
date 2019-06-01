<?php

require_once __DIR__ . '/../include/appTop.php';
require_once 'serviceSecurity.php';

class MouvementHistoriqueController {
private $connexion;
    public function __construct($mysql) {
        $this->connexion = $mysql;
    }

    public function saveAction(MouvementHistorique $mouvHisto = null): ?bool {

        $data = 'mouv_histo_enreg_be_livre_num, mouv_histo_enreg_be_num, 
                mouv_histo_exp, mouv_histo_dest, mouv_histo_type, mouv_histo_date_envoi_crea, 
                mouv_histo_date_retour_crea, mouv_histo_date_reception_crea,
                mouv_histo_etat_envoi, mouv_histo_etat_retour, mouv_histo_etat_reception';
        $stmt = $this->connexion->prepare("INSERT INTO mouvement_historique ($data) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $reg = $stmt->execute(array($mouvHisto->getMouvHistoEnregBeLivreNum(), $mouvHisto->getMouvHistoEnregBeNum(), 
                                $mouvHisto->getMouvHistoExp()->id, $mouvHisto->getMouvHistoDest()->id,
                                $mouvHisto->getMouvHistoType(), $mouvHisto->getMouvHistoDateEnvoiCrea(), 
                                $mouvHisto->getMouvHistoDateRetourCrea(), $mouvHisto->getMouvHistoDateReceptionCrea(),
                                $mouvHisto->getMouvHistoEtatEnvoi(), $mouvHisto->getMouvHistoEtatRetour(),
                                $mouvHisto->getMouvHistoEtatReception()
                                ));
        $stmt = null;
        return $reg;
    }

    // update for mouvement SEND only
    public function updateSendMouvement(MouvementHistorique $mouvHisto = null): ?bool {

        $data = 'mouv_histo_dest= ?, mouv_histo_date_envoi_crea= ?, mouv_histo_etat_envoi= ?';
            
        $stmt = $this->connexion->prepare("UPDATE mouvement_historique SET $data 
                                        WHERE mouv_histo_enreg_be_livre_num = ?
                                        AND mouv_histo_type = ?
                                        ");

        $reg = $stmt->execute(array($mouvHisto->getMouvHistoDest()->id, $mouvHisto->getMouvHistoDateEnvoiCrea(), $mouvHisto->getMouvHistoEtatEnvoi(), 
                                $mouvHisto->getMouvHistoEnregBeLivreNum(), $mouvHisto->getMouvHistoType()
                            ));
        $stmt = null;
        return $reg;
    }

    // update for mouvement return only
    public function updateReturnMouvement(MouvementHistorique $mouvHisto = null): ?bool {

        $data = 'mouv_histo_dest= ?, mouv_histo_date_retour_crea= ?, mouv_histo_etat_retour= ?';
            
        $stmt = $this->connexion->prepare("UPDATE mouvement_historique SET $data 
                                        WHERE mouv_histo_enreg_be_livre_num = ?
                                        AND mouv_histo_type = ?
                                        ");

        $reg = $stmt->execute(array($mouvHisto->getMouvHistoDest()->id, $mouvHisto->getMouvHistoDateRetourCrea(), $mouvHisto->getMouvHistoEtatRetour(), 
                                $mouvHisto->getMouvHistoEnregBeLivreNum(), $mouvHisto->getMouvHistoType()
                            ));
        $stmt = null;
        return $reg;
    }

    // update for etat acceptation only
    public function updateEtatAcceptation(MouvementHistorique $mouvHisto = null): ?bool {

        $data = 'mouv_histo_date_reception_crea= ?, mouv_histo_etat_reception= ?';
            
        $stmt = $this->connexion->prepare("UPDATE mouvement_historique SET $data 
                                        WHERE mouv_histo_enreg_be_livre_num = ?
                                        AND mouv_histo_type = ?
                                        ");

        $reg = $stmt->execute(array($mouvHisto->getMouvHistoDateReceptionCrea(), $mouvHisto->getMouvHistoEtatReception(), 
                                $mouvHisto->getMouvHistoEnregBeLivreNum(), $mouvHisto->getMouvHistoType()
                            ));
        $stmt = null;
        return $reg;
    }

    public function findByIdAction(int $numLivre): ?MouvementHistorique {

        $stmt = $this->connexion->prepare("SELECT * FROM mouvement_historique WHERE mouv_histo_enreg_be_livre_num=?");
        $stmt->execute(array($id));
        $resArr = $stmt->fetchAll();
        if (count($resArr) == 0) {
            $stmt = null;
            return $stmt;
        }
        
        $serveSecurity = new ServiceSecurity($this->connexion);
        $userExp = $serveSecurity->getUserById((int) $resArr[0]['mouv_histo_exp']);
        $userDest = $serveSecurity->getUserById((int) $resArr[0]['mouv_histo_dest']);
        $mouvHisto = new MouvementHistorique();
        $mouvHisto->setMouvHistoEnregBeLivreNum((int) $resArr[0]['mouv_histo_enreg_be_livre_num']);
        $mouvHisto->setMouvHistoExp($userExp);
        $mouvHisto->setMouvHistoDest($userDest);
        $mouvHisto->setMouvHistoType($resArr[0]['mouv_histo_type']);
        $mouvHisto->setMouvHistoEnregBeNum($resArr[0]['mouv_histo_enreg_be_num']);
        $mouvHisto->setMouvHistoDateEnvoiCrea($resArr[0]['mouv_histo_date_envoi_crea']);
        $mouvHisto->setMouvHistoDateRetourCrea($resArr[0]['mouv_histo_date_retour_crea']);
        $mouvHisto->setMouvHistoDateReceptionCrea($resArr[0]['mouv_histo_date_reception_crea']);
        $mouvHisto->setMouvHistoEtatEnvoi( (bool) $resArr[0]['mouv_histo_etat_envoi']);
        $mouvHisto->setMouvHistoEtatRetour( (bool) $resArr[0]['mouv_histo_etat_retour']);
        $mouvHisto->setMouvHistoEtatReception( (bool) $resArr[0]['mouv_histo_etat_reception']);
        $stmt = null;
        return $enregDef;
    }

    // Find folder if it is at Verificateur
    public function findFolderIfItIsAtChecker($numLivre=''):?array {

        $stmt = $this->connexion->prepare("SELECT * FROM `mouvement_historique` mouv 
                                        RIGHT JOIN `enregistrement_be` enreg
                                        ON mouv.mouv_histo_enreg_be_livre_num = enreg.enreg_be_livre_num 
                                        WHERE mouv.mouv_histo_etat_envoi IS NULL
                                        AND mouv.mouv_histo_type = 'ENVOI_AU_DELEGUE'
                                        AND mouv.mouv_histo_enreg_be_livre_num = $numLivre
                                        OR mouv.mouv_histo_etat_envoi IS NOT NULL
                                        AND mouv.mouv_histo_etat_reception IS NULL
                                        AND mouv.mouv_histo_type = 'ENVOI_AU_DELEGUE'
                                        AND mouv.mouv_histo_enreg_be_livre_num = $numLivre
                                        OR mouv.mouv_histo_etat_retour IS NOT NULL
                                        AND mouv.mouv_histo_etat_reception IS NOT NULL
                                        AND mouv.mouv_histo_type = 'RETOUR_AU_VERIFICATEUR'
                                        AND enreg.enreg_be_etat_viser IS NULL
                                        AND mouv.mouv_histo_enreg_be_livre_num = $numLivre
                                        -- OR enreg.enreg_be_etat_lire IS NOT NULL
                                        -- AND enreg.enreg_be_etat_verifier IS NULL
                                        -- AND enreg.enreg_be_livre_num = $numLivre
                                        ");
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

    // Find folder if it is at Delegue
    public function findFolderIfItIsAtDelegue($numLivre=''):?array {

        $stmt = $this->connexion->prepare("SELECT * FROM `mouvement_historique` mouv 
                                        RIGHT JOIN `enregistrement_be` enreg
                                        ON mouv.mouv_histo_enreg_be_livre_num = enreg.enreg_be_livre_num 
                                        WHERE mouv.mouv_histo_etat_retour IS NULL
                                        AND mouv.mouv_histo_type = 'RETOUR_AU_COURIEL'
                                        AND mouv.mouv_histo_enreg_be_livre_num = $numLivre
                                        OR mouv.mouv_histo_etat_retour IS NOT NULL
                                        AND mouv.mouv_histo_etat_reception IS NULL
                                        AND mouv.mouv_histo_type = 'RETOUR_AU_COURIEL'
                                        AND mouv.mouv_histo_enreg_be_livre_num = $numLivre
                                        OR mouv.mouv_histo_etat_retour IS NOT NULL
                                        AND mouv.mouv_histo_etat_reception IS NULL
                                        AND mouv.mouv_histo_type = 'RETOUR_AU_VERIFICATEUR'
                                        AND mouv.mouv_histo_enreg_be_livre_num = $numLivre
                                        OR mouv.mouv_histo_etat_retour IS NULL
                                        AND mouv.mouv_histo_type = 'RETOUR_AU_VERIFICATEUR'
                                        AND mouv.mouv_histo_enreg_be_livre_num = $numLivre
                                        -- OR enreg.enreg_be_etat_lire IS NOT NULL
                                        -- AND enreg.enreg_be_etat_verifier IS NULL
                                        -- AND enreg.enreg_be_livre_num = $numLivre
                                        ");
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

    // Find folder if it is at Delegue
    public function findFolderIfItIsAtCouriel($numLivre=''):?array {

        $stmt = $this->connexion->prepare("SELECT * FROM `mouvement_historique` mouv 
                                        RIGHT JOIN `enregistrement_be` enreg
                                        ON mouv.mouv_histo_enreg_be_livre_num = enreg.enreg_be_livre_num 
                                        WHERE mouv.mouv_histo_etat_retour IS NOT NULL
                                        AND mouv.mouv_histo_etat_reception IS NOT NULL
                                        AND mouv.mouv_histo_type = 'RETOUR_AU_COURIEL'
                                        AND mouv.mouv_histo_enreg_be_livre_num = $numLivre
                                        OR enreg.enreg_be_etat_lire IS NULL
                                        AND enreg.enreg_be_livre_num = $numLivre
                                        OR  enreg.enreg_be_etat_rejeter IS NOT NULL
                                        AND enreg.enreg_be_etat_viser IS NOT NULL
                                        AND mouv.mouv_histo_etat_retour IS NOT NULL
                                        AND mouv.mouv_histo_etat_reception IS NOT NULL
                                        AND mouv.mouv_histo_type = 'RETOUR_AU_COURIEL'
                                        AND enreg.enreg_be_livre_num = $numLivre
                                        ");
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

    // FIND FOLDER IF IT IS AT DELEGATE WHEN WAS READEN no PASSSED OR NO Access/ enreg_be_etat_between_deleg_chek
    public function findFolderIfItIsAtDelegueWhenAffectation($numLivre=''):?array {

        $stmt = $this->connexion->prepare("SELECT * FROM `affectation_dossier` affect 
                                        INNER JOIN `enregistrement_be` enreg
                                        ON affect.affect_dos_enreg_be_livre_num = enreg.enreg_be_livre_num 
                                        WHERE affect.affect_dos_etat IS NOT NULL
                                        AND affect.affect_dos_etat_acceptation IS NULL
                                        AND affect.affect_dos_enreg_be_livre_num = $numLivre
                                        OR enreg.enreg_be_etat_lire IS NOT NULL
                                        AND enreg.enreg_be_etat_between_deleg_chek IS NOT NULL
                                        AND enreg.enreg_be_livre_num = $numLivre
                                        ");
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
    // FIND FOLDER IF IT IS AT DELEGATE WHEN WAS READEN no PASSSED OR NO Access/ enreg_be_etat_between_deleg_chek
    public function findFolderIfItIsAtChekerWhenAffectation($numLivre=''):?array {

        $stmt = $this->connexion->prepare("SELECT * FROM `affectation_dossier` affect 
                                        INNER JOIN `enregistrement_be` enreg
                                        ON affect.affect_dos_enreg_be_livre_num = enreg.enreg_be_livre_num 
                                        WHERE affect.affect_dos_etat IS NOT NULL
                                        AND affect.affect_dos_etat_acceptation IS NOT NULL
                                        AND enreg.enreg_be_etat_between_deleg_chek IS NULL
                                        AND affect.affect_dos_enreg_be_livre_num = $numLivre
                                        ");
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


    // select mouvement historique for hitory folowing by join enregistrement BE
    public function selectMouvementHistoriques():?array {

        $stmt = $this->connexion->prepare("SELECT * FROM `enregistrement_be` enreg 
                                        INNER JOIN `mouvement_historique` mouv
                                        ON enreg.enreg_be_livre_num = mouv.mouv_histo_enreg_be_livre_num
                                        ORDER BY mouv.mouv_histo_enreg_be_livre_num DESC");
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
    
    // select mouvement historique only
    public function selectAllMouvementOnly():?array {

        $stmt = $this->connexion->prepare("SELECT * FROM `mouvement_historique` 
                                        ORDER BY mouv_histo_enreg_be_livre_num DESC");
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