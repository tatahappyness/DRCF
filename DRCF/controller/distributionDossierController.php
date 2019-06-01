<?php

require_once __DIR__.'/../include/appTop.php';
require_once 'serviceSecurity.php';
require_once 'enregistrementBeController.php';

class DistributionDossierController {
private $connexion;
    public function __construct($mysql) {
        $this->connexion = $mysql;
    }

    public function saveAction(DistributionDossier $distrib = null): ?bool {

        $data = 'dist_dos_enreg_be_id_id, dist_dos_user_id_id,
                 dist_dos_date_crea, dist_dos_action, dist_dos_date_envoi';
        $stmt = $this->connexion->prepare("INSERT INTO distribution_dossier  ($data) VALUES (?,?,?,?,?)");
        $reg = $stmt->execute(array($distrib->getDistDosEnregBeId()->id, $distrib->getDistDosUserId()->id,
                        $distrib->getDistDosDateCrea(), $distrib->getDistDosAction(), 
                        $distrib->getDistDosDateEnvoi()
                        ));
        $stmt = null;   
        return $reg;
    }

    public function updateAction(DistributionDossier $distrib = null): ?bool {

        $data = 'dist_dos_enreg_be_id_id = ?, dist_dos_user_id_id = ?, dist_dos_date_crea= ?,
                dist_dos_action = ?, dist_dos_date_envoi = ?';
            
        $stmt = $this->connexion->prepare("UPDATE distribution_dossier SET $data WHERE id = ?");
                        $reg = $stmt->execute(array($distrib->getDistDosEnregBeId()->id, $distrib->getDistDosUserId(),
                        $distrib->getDistDosDateCrea(), $distrib->getDistDosAction(), 
                        $distrib->getDistDosDateEnvoi(), 1
                        )); //$distrib->getId()
        $stmt = null;
        return $reg;
    }

    public function findByIdAction(int $id): ?DistributionDossier {

        $stmt = $this->connexion->prepare("SELECT * FROM distribution_dossier WHERE id=?");
        $stmt->execute(array($id));
        $resArr = $stmt->fetchAll();
        if (count($resArr) == 0) {
            $stmt = null;
            return $stmt;
        }
        
        $serveSecurity = new ServiceSecurity($this->connexion);
        $enregBeControl = new EnregistrementBeController($this->connexion);
        $user = $serveSecurity->getUserById((int) $resArr[0]['dist_dos_user_id_id']);
        $enregBe = $enregBeControl->findByIdAction((int) $resArr[0]['dist_dos_enreg_be_id_id']);

        $distrib = new DistributionDossier();
        $distrib->setId((int) $id);
        $distrib->setDistDosUserId($user);
        $distrib->setDistDosEnregBeId($enregBe);
        $distrib->setDistDosDateCrea($resArr[0]['dist_dos_date_crea']);
        $distrib->setDistDosAction($resArr[0]['dist_dos_action']);
        $distrib->setDistDosDateEnvoi($resArr[0]['dist_dos_date_envoi']);
        $stmt = null;
        return $distrib;
    }

    public function selectAllAction():?array {

        $stmt = $this->connexion->prepare("SELECT * FROM `enregistrement_be` enreg 
                                        INNER JOIN `distribution_dossier` distrib
                                        INNER JOIN `user` us 
                                        ON enreg.id = distrib.dist_dos_enreg_be_id_id 
                                        AND distrib.dist_dos_user_id_id = us.id 
                                        ORDER BY distrib.dist_dos_enreg_be_id_id DESC");
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