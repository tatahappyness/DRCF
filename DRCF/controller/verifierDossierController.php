<?php

require_once __DIR__.'/../include/appTop.php';
require_once 'serviceSecurity.php';
require_once 'enregistrementBeController.php';

class VerifierDossierController {
private $connexion;
    public function __construct($mysql) {
        $this->connexion = $mysql;
    }

    public function saveAction(VerificationDossier $verfDos = null): ?bool 
    {

        $data = 'verif_dos_enreg_be_id_id, verif_dos_user_id_id, verif_dos_mode_pass, 
                verif_dos_date_et_num, verif_dos_num_compt, verif_dos_intitule_activ_prest, 
                verif_dos_realise_pysique, verif_dos_montant, verif_dos_visa_cf, 
                verif_dos_cas_possible, verif_dos_date_crea';

        $stmt = $this->connexion->prepare("INSERT INTO verification_dossier  ($data) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $reg = $stmt->execute(array($verfDos->getVerifDosEnregBeId()->id, $verfDos->getVerifDosUserId()->id, 
                        $verfDos->getVerifDosModePass(), $verfDos->getVerifDosDateEtNum(), 
                        $verfDos->getVerifDosNumCompt(), $verfDos->getVerifDosIntituleActivPrest(), 
                        $verfDos->getVerifDosRealisePysique(), $verfDos->getVerifDosMontant(), 
                        $verfDos->getVerifDosVisaCf(), $verfDos->getVerifDosCasPossible(), 
                        $verfDos->getVerifDosDateCrea()
                        ));
        $stmt = null;
        //die($reg);
        return $reg;
    }

    public function updateAction(VerificationDossier $verfDos = null): ?bool
    {

        $data = 'verif_dos_user_id_id = ?, verif_dos_mode_pass = ?, 
        verif_dos_date_et_num = ?, verif_dos_num_compt = ?, verif_dos_intitule_activ_prest = ?, 
        verif_dos_realise_pysique = ?, verif_dos_montant = ?, 
        verif_dos_cas_possible = ?, verif_dos_date_crea = ?';
            
        $stmt = $this->connexion->prepare("UPDATE verification_dossier SET $data WHERE verif_dos_enreg_be_id_id = ?");
        $reg = $stmt->execute(array($verfDos->getVerifDosUserId()->id, 
        $verfDos->getVerifDosModePass(), $verfDos->getVerifDosDateEtNum(), 
        $verfDos->getVerifDosNumCompt(), $verfDos->getVerifDosIntituleActivPrest(), 
        $verfDos->getVerifDosRealisePysique(), $verfDos->getVerifDosMontant(), 
        $verfDos->getVerifDosCasPossible(), 
        $verfDos->getVerifDosDateCrea(), $verfDos->getVerifDosEnregBeId()->id
        )); //$verfDos->getId()
        $stmt = null;
        return $reg;
    }

    //Upadate visa verifie after viser to add Tef
    public function updateVisaVerifie(VerificationDossier $verfDos = null): ?bool
    {
        $data = 'verif_dos_visa_cf = ?';
        $stmt = $this->connexion->prepare("UPDATE verification_dossier SET $data WHERE verif_dos_enreg_be_id_id = ?");
        $reg = $stmt->execute(array($verfDos->getVerifDosVisaCf(),  
                            $verfDos->getVerifDosEnregBeId()->id
                        ));
        $stmt = null;
        return $reg;
    }

    public function findByIdAction($id): ?VerificationDossier {

        $stmt = $this->connexion->prepare("SELECT * FROM verification_dossier WHERE verif_dos_enreg_be_id_id=?");
        $stmt->execute(array($id));
        $resArr = $stmt->fetchAll();
        if (count($resArr) == 0) {
            $stmt = null;
            return $stmt;
        }
        
        $serveSecurity = new ServiceSecurity($this->connexion);
        $enregBeControl = new EnregistrementBeController($this->connexion);
        $user = $serveSecurity->getUserById((int) $resArr[0]['verif_dos_user_id_id']);
        $enregBe = $enregBeControl->findByIdAction((int) $resArr[0]['verif_dos_enreg_be_id_id']);

        $verfDos = new VerificationDossier();
        $verfDos->setId($id);
        $verfDos->setVerifDosEnregBeId($enregBe);
        $verfDos->setVerifDosUserId($user);
        $verfDos->setVerifDosModePass($resArr[0]['verif_dos_mode_pass']);
        $verfDos->setVerifDosDateEtNum($resArr[0]['verif_dos_date_et_num']);
        $verfDos->setVerifDosNumCompt($resArr[0]['verif_dos_num_compt']);
        $verfDos->setVerifDosIntituleActivPrest($resArr[0]['verif_dos_intitule_activ_prest']);
        $verfDos->setVerifDosRealisePysique($resArr[0]['verif_dos_realise_pysique']);
        $verfDos->setVerifDosMontant($resArr[0]['verif_dos_montant']);
        $verfDos->setVerifDosVisaCf($resArr[0]['verif_dos_visa_cf']);
        $verfDos->setVerifDosCasPossible($resArr[0]['verif_dos_cas_possible']);
        $verfDos->setVerifDosDateCrea($resArr[0]['verif_dos_date_crea']);
        $stmt = null;
        return $verfDos;
    }

    public function selectAllAction():?array {

        $data = '';
        $stmt = $this->connexion->prepare("SELECT * FROM `enregistrement_be` enreg 
                                            INNER JOIN `verification_dossier` verif
                                            INNER JOIN `user` us 
                                            ON enreg.id = verif.verif_dos_enreg_be_id_id
                                            AND verif.verif_dos_user_id_id = us.id 
                                            WHERE enreg.enreg_be_etat_verifier IS NOT NULL ORDER BY verif.verif_dos_enreg_be_id_id DESC");
        $stmt->execute();
        $resArr = $stmt->fetchAll();
        if (count($resArr) == 0) {
            $stmt = null;
            //print_r($resArr);die;
            return $stmt;
        }
        $stmt = null;
        //print_r($resArr);die;
        return $resArr;
    }
    
}