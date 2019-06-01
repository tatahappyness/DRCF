<?php

require_once __DIR__ . '/../include/appTop.php';
require_once 'serviceSecurity.php';

Class SituationController {

    function __construct($mysql) {
        $this->connexion = $mysql;
    }
     
    //Listest of couriel REJECT fitering
    function TotalCourielRejectFilter($date1='', $date2=''): ?array {
        if ( $date2 == '') {
            $stmt = $this->connexion->prepare("SELECT enreg_be_contenu, COUNT(enreg_be_contenu) total_designation 
            FROM enregistrement_be
            WHERE enreg_be_date_crea LIKE '$date1%'
            AND enreg_be_etat_rejeter IS NOT NULL
            GROUP BY enreg_be_contenu");

        }
        else {
            $stmt = $this->connexion->prepare("SELECT enreg_be_contenu, COUNT(enreg_be_contenu) total_designation 
            FROM enregistrement_be
            WHERE enreg_be_date_crea BETWEEN '$date1' AND '$date2'
            AND enreg_be_etat_rejeter IS NOT NULL
            GROUP BY enreg_be_contenu");
        }
            
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

    //Listest of couriel VISER fitering 
    function TotalCourielViseFilter($date1='', $date2=''): ?array {
        
        if ($date2 == '') {
            $stmt = $this->connexion->prepare("SELECT enreg_be_contenu, COUNT(enreg_be_contenu) total_designation 
            FROM enregistrement_be
            WHERE enreg_be_date_crea LIKE '$date1%'
            AND enreg_be_etat_viser IS NOT NULL
            GROUP BY enreg_be_contenu");
        }
        else {
            $stmt = $this->connexion->prepare("SELECT enreg_be_contenu, COUNT(enreg_be_contenu) total_designation 
            FROM enregistrement_be
            WHERE enreg_be_date_crea BETWEEN '$date1' AND '$date2' 
            AND enreg_be_etat_viser IS NOT NULL
            GROUP BY enreg_be_contenu");
        }
           
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

    //Select count DEF viser Group by livre num
    public function totalDefViser($date1='', $date2=''): ?array {
    
        if ($date2 == '') {
            $stmt = $this->connexion->prepare("SELECT COUNT(enreg_def_enreg_be_livre_num) total_def_vise
                                            FROM enregistrement_def
                                            WHERE enreg_def_date_crea LIKE '$date1%'
                                            AND enreg_def_etat_viser IS NOT NULL
                                        ");
        }
        else {
            $stmt = $this->connexion->prepare("SELECT COUNT(enreg_def_enreg_be_livre_num) total_def_vise
                                            FROM enregistrement_def
                                            WHERE enreg_def_date_crea BETWEEN '$date1' AND '$date2' 
                                            AND enreg_def_etat_viser IS NOT NULL
                                        ");
        }
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

    //Select count DEF rejet Group by livre num
    public function totalDefRejeter($date1='', $date2=''): ?array  {

        if ($date2 == '') {
            $stmt = $this->connexion->prepare("SELECT COUNT(enreg_def_enreg_be_livre_num) total_def_rejet
                                            FROM enregistrement_def
                                            WHERE enreg_def_date_crea LIKE '$date1%'
                                            AND enreg_def_etat_rejeter IS NOT NULL
                                        ");
        }
        else {
            $stmt = $this->connexion->prepare("SELECT COUNT(enreg_def_enreg_be_livre_num) total_def_rejet
                                            FROM enregistrement_def
                                            WHERE enreg_def_date_crea BETWEEN '$date1' AND '$date2' 
                                            AND enreg_def_etat_rejeter IS NOT NULL
                                        ");
        }
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

    //List MOTIF DEF
    public function motifDefRejeter($date1='', $date2=''): ?array  {

        if ($date2 == '') {
            $stmt = $this->connexion->prepare("SELECT enreg_def_motif_type, enreg_def_motif_desc
                                            FROM enregistrement_def
                                            WHERE enreg_def_date_crea LIKE '$date1%'
                                            AND enreg_def_etat_rejeter IS NOT NULL
                                        ");
        }
        else {
            $stmt = $this->connexion->prepare("SELECT enreg_def_motif_type, enreg_def_motif_desc
                                            FROM enregistrement_def
                                            WHERE enreg_def_date_crea BETWEEN '$date1' AND '$date2' 
                                            AND enreg_def_etat_rejeter IS NOT NULL
                                        ");
        }
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

    //Select count Couries Enregistrer 
    public function totalCourieEnregistrer($date1='', $date2=''): ?array  {
        
        if ($date2 == '') {
            $stmt = $this->connexion->prepare("SELECT COUNT(id) total_be 
                                        FROM `enregistrement_be`
                                        WHERE enreg_be_date_crea LIKE '$date1%'
                                    ");
        }
        else {
            $stmt = $this->connexion->prepare("SELECT COUNT(id) total_be 
                                            FROM `enregistrement_be` 
                                            WHERE enreg_be_date_crea BETWEEN '$date1' AND '$date2' 
                                        ");
        }
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

    //Select count Couries Enregistrer (rejet_dos_enreg_be_id_id, rejet_dos_motif_type, rejet_dos_motif_desc )
    public function listCourieRejet($date1 = '', $date2 = ''): ?array  {
        if ($date2 == '') {
            $stmt = $this->connexion->prepare("SELECT * 
                                        FROM `enregistrement_be` enreg
                                        INNER JOIN rejeter_dossier rejet
                                        ON enreg.id = rejet.rejet_dos_enreg_be_id_id
                                        WHERE enreg.enreg_be_date_crea LIKE '$date1%'
                                    ");
        }
        else {
            $stmt = $this->connexion->prepare("SELECT *
                                            FROM `enregistrement_be` enreg
                                            INNER JOIN rejeter_dossier rejet
                                            ON enreg.id = rejet.rejet_dos_enreg_be_id_id
                                            WHERE enreg.enreg_be_date_crea BETWEEN '$date1' AND '$date2' 
                                        ");
        }
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


    /// RAPPORT DE SITUATION D'ENGAGEMENT
    public function listRapportEngagementByDistrict($district = '', $date = ''): ?array {
        $stmt = $this->connexion->prepare(" SELECT verif.verif_dos_mode_pass, verif.verif_dos_date_et_num,
                                                    verif.verif_dos_num_compt, verif.verif_dos_intitule_activ_prest,
                                                    verif.verif_dos_realise_pysique, verif.verif_dos_montant, 
                                                    verif.verif_dos_montant, 
                                                    verif.verif_dos_visa_cf, enreg.enreg_be_serv_lieu
                                             FROM `verification_dossier` verif
                                             INNER JOIN `enregistrement_be` enreg
                                             ON verif_dos_enreg_be_id_id = enreg.id
                                             WHERE enreg.enreg_be_serv_lieu = '$district' 
                                             AND  verif.verif_dos_date_et_num LIKE '%$date%'

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

    /// TOTAL MODE PASSATION DE SITUATION D'ENGAGEMENT GROUP BY MODE PASS
    public function totalModPassByDistrict($district = '', $date = ''): ?array {
        $stmt = $this->connexion->prepare(" SELECT verif.verif_dos_mode_pass, COUNT(verif.verif_dos_mode_pass) total_modpass
                                            FROM `verification_dossier` verif
                                            INNER JOIN `enregistrement_be` enreg
                                            ON verif_dos_enreg_be_id_id = enreg.id
                                            WHERE enreg.enreg_be_serv_lieu = '$district'
                                            AND  verif.verif_dos_date_et_num LIKE '%$date%'
                                            GROUP BY verif.verif_dos_mode_pass
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

}