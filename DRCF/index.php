<?php
//session_destroy();
ini_set('display_errors', 1);
// error_reporting(E_ALL);
 error_reporting(-1);
 ini_set('error_reporting', E_ALL);

// require_once 'config/menu.php';
require_once 'env/database.php';
require_once 'vendor/autoload.php';

$options = [
    PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
    ];
    try {
        $pdo = new PDO(CONNEXION, USERNAME, PASSWORD, $options);
        } catch (Exception $e) {
        error_log($e->getMessage());
        exit('Something weird happened'); //something a user can understand
    }
        
require_once 'controller/serviceSecurity.php';
require_once 'controller/enregistrementBeController.php';
require_once 'controller/lectureDossierController.php';
require_once 'controller/verifierDossierController.php';
require_once 'controller/viserDossierController.php';
require_once 'controller/rejeterDossierController.php';
require_once 'controller/enregistrementDefController.php';
require_once 'controller/enregistrementVisaController.php';
require_once 'controller/distributionDossierController.php';
require_once 'controller/affectationDossierController.php';
require_once 'controller/tefController.php';
require_once 'controller/mouvementHistoriqueController.php';
require_once 'controller/situationController.php';



$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, [
    'debug' => true,
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());
$twig->addExtension(new Twig_Extensions_Extension_Date());


/**
* METHODE POST BIGIN HERE
* 
**/

    // Post Login user
if (isset($_POST['login']) && isset($_POST['password'])) {
    $user = new User();
    $servSecurity = new ServiceSecurity($pdo);
    $user->setUsername($_POST['login']);
    $user->setPassword($_POST['password']);
    try {
      
        $logsec = $servSecurity->loginAction($user);
        //var_dump(count($logsec));die;
        if (count($logsec) == 0) {
            //die('DISO');
            echo $twig->render('index.html.twig', ['showLoginPage'=> true, 'class'=> 'active', 
                            'message' => 'Votre login ou votre mot de passe incorect!'
                            ]);
            exit();
        }

        session_start();
        $_SESSION['id'] = $logsec['id'];
        $_SESSION['username'] = $logsec['username'];
        $_SESSION['password'] = $logsec['password'];
        $_SESSION['role'] = $logsec['roles']; // get roles in array of array
        //get List couriels after loged
        $enregBeControl = new EnregistrementBeController($pdo);
        $listsbe = $enregBeControl->selectAllAction();

        echo $twig->render('index.html.twig', ['showListsCouriels'=> true, 
                        'logsecurity'=> $_SESSION['username'], 'listsBe'=> $listsbe,
                        'showFormAddCouriel'=> true, 'loged'=>true , 'role'=> $_SESSION['role']
                        ]);
        exit();
    } catch (\Throwable $th) {
        throw $th;
        die('Error during the selector');
    }
}

session_start();

if (isset($_SESSION) && isset($_SESSION['username'])) {
    
    //Post registrator the user
    if (isset($_POST['username']) && isset($_POST['im']) && isset($_POST['password'])) {
        ///$roles = 'membre';
        $user = new User();
        $servSecurity = new ServiceSecurity($pdo);
        $user->setUsername($_POST['username']);
        //$user->setRoles( (array) $roles);
        $user->setIm($_POST['im']);
        $user->setPassword($_POST['password']);
        try {
        if (!$servSecurity->registratorAction($user)) {
            exit('Bad resgistrator');
        } 
            echo $twig->render('index.html.twig', ['showLoginPage'=> true, 'class'=> 'active', 
                            'message' => 'Vous etes inscrit!, Veuillez s\'authentifier',
                            'loged'=>true
                            ]);
            exit();
        } catch (\Throwable $th) {
            throw $th;
            die('Error during the resitrator');
        }
    }
    //print_r($_POST['enregBeNum']);die;
    //Post enregistrement BE
    if (isset($_POST['enregBeNum']) && isset($_POST['enregBeDate']) && isset($_POST['enregBeServTitulaire']) && isset($_POST['enregBeContenu']) && isset($_POST['enregBeobserve']) && isset($_POST['enregBeLivreNum']) && isset($_POST['enregBeServLieu'])) {
    session_start();
    //print_r('$enregBe');die;
    $servSecurity = new ServiceSecurity($pdo);
    $enregBe = new EnregistrementBe();
    $enregBeControl = new EnregistrementBeController($pdo);

    $userId = $servSecurity->getUserById( (int) $_SESSION['id']);
    $enregBe->setEnregBeUserId($userId);
    $enregBe->setEnregBeContenu($_POST['enregBeContenu']);
    $enregBe->setEnregBeLivreNum($_POST['enregBeLivreNum']);
    $enregBe->setEnregBeNum($_POST['enregBeNum']);
    $enregBe->setEnregBeobserve($_POST['enregBeobserve']);
    $enregBe->setEnregBeServTitulaire($_POST['enregBeServTitulaire']);
    $enregBe->setEnregBeDate(date_format(date_create($_POST['enregBeDate']), 'Y-m-d'));
    $enregBe->setEnregBeDateCrea(date('y-m-d H:i:s'));
    $enregBe->setEnregBeServLieu($_POST['enregBeServLieu']);
    $message = '';

    try {

        // $pdo->beginTransaction();

        if (isset($_POST['action']) && $_POST['action'] == 'Corriger') {
            $message= 'Mise en jour a été effectuée!';
            if (!$enregBeControl->updateAction($enregBe)) {
                exit('Bad update');
            } 
        }
        else {

            $pdo->beginTransaction();
            $message = 'Enregistrement a été effectuée!';
            $status = $enregBeControl->saveAction($enregBe);
            if (!$status) {
                exit('Bad resgistrator');
            } 
            // Add def in table database
            if (!empty($_POST['enregDefNum']) && !empty($_POST['enregDefObjet']) && !empty($_POST['enregDefTitulaire']) && !empty($_POST['enregDefMontant']) && !empty($_POST['enregDefService']) && !empty($_POST['enregDefVisa'])) {
                
                $enregDef = new EnregistrementDef();
                $enregDefControl = new EnregistrementDefController($pdo);
                $enregDef->setEnregDefUserId($userId);
                $enregDef->setEnregDefEnregBeLivreNum($_POST['enregBeLivreNum']);
                $enregDef->setEnregDefNum($_POST['enregDefNum']);
                $enregDef->setEnregDefObjet($_POST['enregDefObjet']);
                $enregDef->setEnregDefTitulaire($_POST['enregDefTitulaire']);
                $enregDef->setEnregDefMontant($_POST['enregDefMontant']);
                $enregDef->setEnregDefService($_POST['enregDefService']);
                $enregDef->setEnregDefVisa(null);
                $enregDef->setEnregDefDateCrea(date('y-m-d H:i:s'));
                $status = $enregDefControl->saveAction($enregDef);
                                                if (!$status) {
                                                    exit('Bad resgistrator');
                                                }
            }
            $pdo->commit();
        }
        // $listsbe = $enregBeControl->selectAllAction();

        header('location:http://drcf.dev.com?listsBeRecord');
        exit();
        } catch (\Throwable $th) {
            throw $th;
            die('Error during the resitrator BE');
        }
    }

    //POST UPDATE DEF by vise
    if (isset($_POST['enregDefEnregBeLivreNum']) && isset($_POST['enregDefDateDaraphe']) &&  $_POST['action'] == 'actionDefVise' || isset($_POST['action']) && $_POST['action'] == 'actionDefRevise') {
        $enregDefControl = new EnregistrementDefController($pdo);
        try {
            $pdo->beginTransaction();
            $enregDef = $enregDefControl->findByIdAction($_POST['enregDefEnregBeLivreNum']);
            $enregDef->setEnregDefEtatViser(true);
            $enregDef->setEnregDefDateDaraphe(date_format(date_create($_POST['enregDefDateDaraphe']), 'y-m-d'));
            
            if (!$enregDefControl->updateDefWhenVise($enregDef)) {
                exit('Bad update def when vise');
            }
            //Update etat vise after reject to null
            if($_POST['action'] == 'actionDefRevise') {
                //$enregDef->setEnregDefEtatViseAfterReject();
                if (!$enregDefControl->updateDefWhenViseAfterReject($enregDef)) {
                    exit('Bad update def when vise');
                }
            }

            $pdo->commit();
            header('location:http://drcf.dev.com?listsDefRecorded');
            exit();

        } catch(\Throwable $th) {
            throw $th;
            die('Error during update Def by vise!');
        }
        
    }

    //POST UPDATE DEF by  Reject 
    if (isset($_POST['enregDefEnregBeLivreNum']) && isset($_POST['enregDefMotifType']) && isset($_POST['enregDefMotifDesc']) && $_POST['action'] == 'actionDefReject' ) {

        $enregDefControl = new EnregistrementDefController($pdo);
        try {
            $pdo->beginTransaction();
            $enregDef = $enregDefControl->findByIdAction($_POST['enregDefEnregBeLivreNum']);
            $enregDef->setEnregDefMotifType($_POST['enregDefMotifType']);
            $enregDef->setEnregDefMotifDesc($_POST['enregDefMotifDesc']);
            $enregDef->setEnregDefEtatRejeter(true);
            
            if (!$enregDefControl->updateDefWhenReject($enregDef)) {
                exit('Bad update def when vise');
            }

            $pdo->commit();
            header('location:http://drcf.dev.com?listsDefRecorded');
            exit();

        } catch(\Throwable $th) {
            throw $th;
            die('Error during update Def by vise!');
        }

    }

    //POST Control DEF by  after Reject
    if (isset($_POST['enregDefEnregBeLivreNum']) && $_POST['action'] == 'reviseDefAfterReject') {
        $enregDefControl = new EnregistrementDefController($pdo);
        try {
            $pdo->beginTransaction();
            $enregDef = $enregDefControl->findByIdAction($_POST['enregDefEnregBeLivreNum']);
            $enregDef->setEnregDefEtatViseAfterReject(true);
            
            if (!$enregDefControl->updateDefWhenViseAfterReject($enregDef)) {
                exit('Bad update def when vise');
            }

            $pdo->commit();
            header('location:http://drcf.dev.com?listsDefRecorded');
            exit();

        } catch(\Throwable $th) {
            throw $th;
            die('Error during update Def by vise!');
        }
    }


    //Post Lecture couriels
    if (isset($_POST['lectDosSituation']) && isset($_POST['lectDosParapheDateCrea']) && isset($_POST['lectDosEnregBeId'])) {
       // session_start();
        $servSecurity = new ServiceSecurity($pdo);
        $lectDosControl = new LectureDossierController($pdo);
        $enregBeControl = new EnregistrementBeController($pdo);
        //$enregBe EnregistrementBe();
        $lectDos = new LectureDossier();
        $distrib = new DistributionDossier();
        $distribControl = new DistributionDossierController($pdo);

        try {

            $pdo->beginTransaction();

            $user = $servSecurity->getUserById( (int) $_SESSION['id']);
            $enregBe = $enregBeControl->findByIdAction($_POST['lectDosEnregBeId']);
            $distrib->setDistDosUserId($user);
            $distrib->setDistDosEnregBeId($enregBe);
            $distrib->setDistDosDateCrea(date('y-m-d H:i:s'));
            $distrib->setDistDosAction('Lire');
            $distribControl->saveAction($distrib);
            //update bE status
            $enregBe->setId($_POST['lectDosEnregBeId']);
            $enregBe->setEnregBeEtatlire(true);
            $enregBe->setEnregBeEtatVerifier(null);
            $enregBe->setEnregBeEtatViser(null);
            $enregBe->setEnregBeEtatRejeter(null);
            $enregBe->setEnregBeEtatVisa(null);
            $enregBe->setEnregBeEtatVerifAfterRejet(null);
            $enregBe->setEnregBeEtatViseAfterRejet(null);

            $enregBeControl->updateAction($enregBe);

            $lectDos->setLectDosUserId($user);
            $lectDos->setLectDosEnregBeId($enregBe);
            
            $lectDos->setLectDosSituation($_POST['lectDosSituation']);
            $lectDos->setLectDosParapheDateCrea(date_format(date_create($_POST['lectDosParapheDateCrea']), 'y-m-d'));
        
            if (!$lectDosControl->saveAction($lectDos)) {
                exit('Bad resgistrator');
            } 
            //update Be etat between delegate and chek when readed
            $enregBe->setEnregBeEtatBetweenDelegChek(true);
            if (!$enregBeControl->updateEtatBetweenDelegateAndChek($enregBe)) {
                exit('Bad update status between delegate and chek when readed!');
            } 

            $pdo->commit();

            header('location:http://drcf.dev.com?listsBeRecord&&sendReaded');
            exit();

        } catch (\Throwable $th) {
            throw $th;
        }
            
    }


    //Post verifier dossier
    if (isset($_POST['verifDosModePass']) && isset($_POST['verifDosDateEtNum']) && isset($_POST['verifDosNumCompt']) && isset($_POST['verifDosIntituleActivPrest']) &&  isset($_POST['verifDosRealisePysique']) && isset($_POST['verifDosMontant']) && isset($_POST['verifDosVisaCf']) && isset($_POST['verifDosCasPossible']) && isset($_POST['verifDosEnregBeId'])) {
       //die($_POST['verifDosCasPossible']);
        try {
            
            $servSecurity = new ServiceSecurity($pdo);
            $verifDos = new VerificationDossier();
            $enregBeControl = new EnregistrementBeController($pdo);
            $verifDosControl  = new VerifierDossierController($pdo);
            $distrib = new DistributionDossier();
            $distribControl = new DistributionDossierController($pdo);

            // Instance to insert FromcheckToDeleguate in mouvement
            $mouvHistoControl = new MouvementHistoriqueController($pdo);
            $mouvHisto = new MouvementHistorique();

            $pdo->beginTransaction();

            $user = $servSecurity->getUserById( (int) $_SESSION['id']);
            //print_r($user);die;
            $enregBe = $enregBeControl->findByIdAction($_POST['verifDosEnregBeId']);
            // print_r($enregBe);die;
            $distrib->setDistDosUserId($user);
            $distrib->setDistDosEnregBeId($enregBe);
            $distrib->setDistDosDateCrea(date('y-m-d H:i:s'));
            $distrib->setDistDosAction('Verifier');
            $distribControl->saveAction($distrib);

            $verifDos->setVerifDosUserId($user);
            $verifDos->setVerifDosEnregBeId($enregBe);
            $verifDos->setVerifDosModePass($_POST['verifDosModePass']);
            $verifDos->setVerifDosDateEtNum($_POST['verifDosDateEtNum']);
            $verifDos->setVerifDosNumCompt($_POST['verifDosNumCompt']);
            $verifDos->setVerifDosIntituleActivPrest($_POST['verifDosIntituleActivPrest']);
            $verifDos->setVerifDosRealisePysique($_POST['verifDosRealisePysique']);
            $verifDos->setVerifDosMontant( (float) $_POST['verifDosMontant']);
            $verifDos->setVerifDosVisaCf($_POST['verifDosVisaCf']);
            $verifDos->setVerifDosCasPossible($_POST['verifDosCasPossible']);
            $verifDos->setVerifDosDateCrea(date('y-m-d H:i:s'));

                if (isset($_POST['action']) && $_POST['action'] == 'Corriger') {
                  
                    //Verify dos update after reject
                    $verifDos = $verifDosControl->findByIdAction($_POST['verifDosEnregBeId']);
                    $verifDos->setVerifDosUserId($user);
                    $verifDos->setVerifDosEnregBeId($enregBe);
                    $verifDos->setVerifDosModePass($_POST['verifDosModePass']);
                    $verifDos->setVerifDosDateEtNum($_POST['verifDosDateEtNum']);
                    $verifDos->setVerifDosNumCompt($_POST['verifDosNumCompt']);
                    $verifDos->setVerifDosIntituleActivPrest($_POST['verifDosIntituleActivPrest']);
                    $verifDos->setVerifDosRealisePysique($_POST['verifDosRealisePysique']);
                    $verifDos->setVerifDosMontant( (float) $_POST['verifDosMontant']);
                    $verifDos->setVerifDosCasPossible($_POST['verifDosCasPossible']);
                    $verifDos->setVerifDosDateCrea(date('y-m-d H:i:s'));

                    if (!$verifDosControl->updateAction($verifDos)) {
                        exit('Bad when update verify');
                    } 
                    $enregBe->setEnregBeEtatViseAfterRejet(true);
                    $enregBe->setEnregBeEtatVerifAfterRejet(null);
                    $enregBeControl->updateEtatVerifAfterRejet($enregBe);
                    $enregBeControl->updateEtatViseAfterRejet($enregBe);
                    
                }
                else {

                    //update bE status
                    //$enregBe->setId($_POST['verifDosEnregBeId']);
                    $enregBe->setEnregBeEtatVerifier(true);
                    $enregBe->setEnregBeEtatViser(null);
                    $enregBe->setEnregBeEtatRejeter(null);
                    $enregBe->setEnregBeEtatVisa(null);
                    $enregBe->setEnregBeEtatVerifAfterRejet(null);
                    $enregBe->setEnregBeEtatViseAfterRejet(null);
                    $enregBeControl->updateAction($enregBe);

                    if (!$verifDosControl->saveAction($verifDos)) {
                        exit('Bad when check Folder');
                    } 
                    // SET Object to mouvement FromcheckToDeleguate here
                    $mouvHisto->setMouvHistoExp($user);
                    $mouvHisto->setMouvHistoDest(null);
                    $mouvHisto->setMouvHistoEnregBeLivreNum($enregBe->getEnregBeLivreNum());
                    $mouvHisto->setMouvHistoEnregBeNum($enregBe->getEnregBeNum());
                    $mouvHisto->setMouvHistoType('ENVOI_AU_DELEGUE');
                    $mouvHisto->setMouvHistoEtatEnvoi(null);
                    $mouvHisto->setMouvHistoEtatRetour(null);
                    $mouvHisto->setMouvHistoEtatReception(null);
                    $mouvHisto->setMouvHistoDateEnvoiCrea(null);
                    if (!$mouvHistoControl->saveAction($mouvHisto)) {
                        exit('Bad when saving Mouvement history!');
                    } 

                }
                   

            $pdo->commit();
            header('location:http://drcf.dev.com?listsReadedFolder&&sendChecked');
            exit();

        } catch (\Throwable $th) {
            throw $th;
        }

    }


    //Post enregistrement VISA
    if (isset($_POST['enregVisaLivreNum']) && isset($_POST['enregVisaNum']) && isset($_POST['enregVisaDate']) && isset($_POST['enregVisaEnregBeId']) && $_POST['action'] == 'Créer' ) {
    //$_POST['enregVisaLivreDateCrea']
    try {
            
        $servSecurity = new ServiceSecurity($pdo);
        $enregVisa = new EnregistrementVisa();
        $enregBeControl = new EnregistrementBeController($pdo);
        $enregVisaControl = new EnregistrementVisaController($pdo);
        $distrib = new DistributionDossier();
        $distribControl = new DistributionDossierController($pdo);
        $verifDosControl  = new VerifierDossierController($pdo);

        $pdo->beginTransaction();

        $user = $servSecurity->getUserById( (int) $_SESSION['id']);
        $enregBe = $enregBeControl->findByIdAction($_POST['enregVisaEnregBeId']);
        $distrib->setDistDosUserId($user);
        $distrib->setDistDosEnregBeId($enregBe);
        $distrib->setDistDosDateCrea(date('y-m-d H:i:s'));
        $distrib->setDistDosAction('créer visa');
        $distribControl->saveAction($distrib);

        //update bE status
        // $enregBe->setId($_POST['verifDosEnregBeId']);
        $enregBe->setEnregBeEtatVisa(true);
        $enregBe->setEnregBeEtatRejeter(null);
        $enregBe->setEnregBeEtatVerifAfterRejet(null);
        $enregBe->setEnregBeEtatViseAfterRejet(null);
        $enregBeControl->updateAction($enregBe);

        $enregVisa->setEnregVisaUserId($user);
        $enregVisa->setEnregVisaEnregBeId($enregBe);
        $enregVisa->setEnregVisaLivreNum($_POST['enregVisaLivreNum']);
        $enregVisa->setEnregVisaNum($_POST['enregVisaNum']);
        $enregVisa->setEnregVisaDate(date_format(date_create($_POST['enregVisaDate']),'y-m-d'));
        $enregVisa->setEnregVisaLivreDateCrea(date('y-m-d H:i:s'));
        
        if (!$enregVisaControl->saveAction($enregVisa)) {
            exit('Bad when check Folder');
        } 
        // Update visa in verify folder when record visa
        $verifDos =  $verifDosControl->findByIdAction($_POST['enregVisaEnregBeId']);
        $numDate = $_POST['enregVisaNum'] . ' du ' .date('d/m/Y', strtotime($_POST['enregVisaDate']));
        $verifDos->setVerifDosVisaCf($numDate);
        if (!$verifDosControl->updateVisaVerifie($verifDos)) {
            exit('Bad when update cheking Folder its visa!');
        } 

        $pdo->commit();

        header('location:http://drcf.dev.com?listsSeenFolder&&sendVisa');
        exit();

        } catch (\Throwable $th) {
            throw $th;
        }

    }

    //Post Viser Dossier
    if (isset($_POST['viseDosEnregBeId']) && $_POST['action'] == 'Viser' || isset($_POST['viseDosEnregBeId']) && $_POST['action'] == 'ViserAfterReject' ) {
        // die($_POST['viseDosEnregBeNum']);
        $servSecurity = new ServiceSecurity($pdo);
        $viseDos = new ViserDossier();
        $enregBeControl = new EnregistrementBeController($pdo);
        $viseDosControl = new ViserDossierController($pdo);
        $distrib = new DistributionDossier();
        $distribControl = new DistributionDossierController($pdo);

        // Instance to insert FromcheckToDeleguate in mouvement
        $mouvHistoControl = new MouvementHistoriqueController($pdo);
        $mouvHisto = new MouvementHistorique();

        try {
            $pdo->beginTransaction();

            $user = $servSecurity->getUserById( (int) $_SESSION['id']);
            $enregBe = $enregBeControl->findByIdAction($_POST['viseDosEnregBeId']);
            $distrib->setDistDosUserId($user);
            $distrib->setDistDosEnregBeId($enregBe);
            $distrib->setDistDosDateCrea(date('y-m-d H:i:s'));
            $distrib->setDistDosAction('Viser');
            $distribControl->saveAction($distrib);

            //update bE status
            //$enregBe->setId($_POST['viseDosEnregBeId']);
            $enregBe->setEnregBeEtatViser(true);
            $enregBe->setEnregBeEtatRejeter(null);
            $enregBe->setEnregBeEtatVisa(null);
            $enregBe->setEnregBeEtatVerifAfterRejet(null);
            $enregBe->setEnregBeEtatViseAfterRejet(null);
            $enregBeControl->updateAction($enregBe);

            $viseDos->setViseDosUserId($servSecurity->getUserById( (int) $_SESSION['id']));
            $viseDos->setViseDosEnregBeId($enregBe);
            $viseDos->setViseDosDateCrea(date('y-m-d H:i:s'));
            
                
            if( $_POST['action'] == 'ViserAfterReject') {

                $enregBe->setEnregBeEtatViseAfterRejet(null);
                $enregBe->setEnregBeEtatVerifAfterRejet(null);
                $enregBe->setEnregBeEtatRejeter(true);
                $enregBeControl->updateEtatVerifAfterRejet($enregBe);
                $enregBeControl->updateEtatViseAfterRejet($enregBe);

            }

            if (!$viseDosControl->saveAction($viseDos)) {
                exit('Bad when see Folder');
            } 
           

            // INSERT TO MOUVEMENT AFTER SEEN FromDelegueToCouriel
            $mouvHisto->setMouvHistoExp($user);
            $mouvHisto->setMouvHistoDest(null);
            $mouvHisto->setMouvHistoEnregBeLivreNum($enregBe->getEnregBeLivreNum());
            $mouvHisto->setMouvHistoEnregBeNum($enregBe->getEnregBeNum());
            $mouvHisto->setMouvHistoType('RETOUR_AU_COURIEL');
            $mouvHisto->setMouvHistoEtatEnvoi(null);
            $mouvHisto->setMouvHistoEtatRetour(null);
            $mouvHisto->setMouvHistoEtatReception(null);
            $mouvHisto->setMouvHistoDateRetourCrea(null);
            if (!$mouvHistoControl->saveAction($mouvHisto)) {
                exit('Bad when saving Mouvement history!');
            } 

            $pdo->commit();

            header('location:http://drcf.dev.com?listsCheckedFolderAfterSeen');
            exit();

        } catch (\Throwable $th) {
            throw $th;
        }

    }

    //Post Rejeter Dossier
    if (isset($_POST['viseDosEnregBeId']) && isset($_POST['rejetDosMotif']) && $_POST['action'] == 'Rejeter' ) {
     
        $arrayMotif = explode('###', $_POST['rejetDosMotif']);
        $rejetDosMotifType =  $arrayMotif[0];
        $rejetDosMotifContent =  $arrayMotif[1];
        //die($rejetDosMotifType . '  ' . $rejetDosMotifContent);
        $servSecurity = new ServiceSecurity($pdo); 
        $rejetDos = new RejeterDossier();
        $enregBeControl = new EnregistrementBeController($pdo);
        $rejetDosControl = new RejeterDossierController($pdo);
        $distrib = new DistributionDossier();
        $distribControl = new DistributionDossierController($pdo);

        // Instance to insert FromcheckToDeleguate in mouvement
        $mouvHistoControl = new MouvementHistoriqueController($pdo);
        $mouvHisto = new MouvementHistorique();

        try {
            $pdo->beginTransaction();
            $user = $servSecurity->getUserById( (int) $_SESSION['id']);
            $enregBe = $enregBeControl->findByIdAction($_POST['viseDosEnregBeId']);
            $distrib->setDistDosUserId($user);
            $distrib->setDistDosEnregBeId($enregBe);
            $distrib->setDistDosDateCrea(date('y-m-d H:i:s'));
            $distrib->setDistDosAction('Rejeter');
            $distribControl->saveAction($distrib);

            //update bE status
            // $enregBe->setId($_POST['rejetDosEnregBeId']);
            $enregBe->setEnregBeEtatRejeter(true);
            $enregBe->setEnregBeEtatViser(null);
            $enregBe->setEnregBeEtatVisa(null);
            $enregBe->setEnregBeEtatVerifAfterRejet(null);
            $enregBe->setEnregBeEtatViseAfterRejet(null);
            $enregBeControl->updateAction($enregBe);

            $rejetDos->setRejetDosUserId($user);
            $rejetDos->setRejetDosEnregBeId($enregBe);
            $rejetDos->setRejetDosDateCrea(date('y-m-d H:i:s'));
            $rejetDos->setRejetDosMotifDesc($rejetDosMotifContent);
            $rejetDos->setRejetDosMotifType($rejetDosMotifType);
            
            if (!$rejetDosControl->saveAction($rejetDos)) {
                exit('Bad when see Folder');
            } 

            //INSERT into Muvement when reject FromDelegueToVericateur
            $mouvHisto->setMouvHistoExp($user);
            $mouvHisto->setMouvHistoDest(null);
            $mouvHisto->setMouvHistoEnregBeLivreNum($enregBe->getEnregBeLivreNum());
            $mouvHisto->setMouvHistoEnregBeNum($enregBe->getEnregBeNum());
            $mouvHisto->setMouvHistoType('RETOUR_AU_VERIFICATEUR');
            $mouvHisto->setMouvHistoEtatEnvoi(null);
            $mouvHisto->setMouvHistoEtatRetour(null);
            $mouvHisto->setMouvHistoEtatReception(null);
            $mouvHisto->setMouvHistoDateRetourCrea(null);
            if (!$mouvHistoControl->saveAction($mouvHisto)) {
                exit('Bad when saving Mouvement history!');
            } 

            $pdo->commit();

            header('location:http://drcf.dev.com?listsCheckedFolderAfterReject');
            exit();

        } catch (\Throwable $th) {
            throw $th;
        }

    }

    //RECORD Affectation 
    if (isset($_POST['affectDosUserId']) && isset($_POST['affectDosEnregBeLivreNum']) && isset($_POST['affectDosEnregBeNum'])) {
            
            $servSecurity = new ServiceSecurity($pdo);
            $affectDosControl = new AffectationDossierController($pdo);
            $affectDos = new AffectationDossier();

        try {
            $pdo->beginTransaction();
            $userAffect = $servSecurity->getUserById( (int) $_POST['affectDosUserId']);
            $user = $servSecurity->getUserById( (int) $_SESSION['id']);
            //bigin affect
            $affectDos->setAffectDosUserIdExp($user);
            $affectDos->setAffectDosUserId($userAffect);
            $affectDos->setAffectDosEnregBeLivreNum($_POST['affectDosEnregBeLivreNum']);
            $affectDos->setAffectDosEnregBeNum($_POST['affectDosEnregBeNum']);
            $affectDos->setAffectDosDateCrea(date('y-m-d H:i:s'));
            $affectDos->setAffectDosEtat(true);
            if (!$affectDosControl->saveAction($affectDos)) {
                exit('Bad when save affectation!');
            } 
            $pdo->commit();
            header('location:http://drcf.dev.com?showAffectAfterSave');
            exit();  
          
        }catch (\Throwable $th) {
            throw $th;
        }
    }
    //UPDATE Affectation BY ACCEPTATION FOLDER
    if (isset($_POST['affectDosEtatAcceptation']) && isset($_POST['affectDosEnregBeLivreNum'])) {
       
        $affectDosControl = new AffectationDossierController($pdo);
        $affectDos = new AffectationDossier();
        try {
            $affectDos->setAffectDosEnregBeLivreNum($_POST['affectDosEnregBeLivreNum']);
            $affectDos->setAffectDosEtatAcceptation(true);
            if (!$affectDosControl->updateAffectEtatAcceptation($affectDos)) {
                exit('Bad when update affectation!');
            } 

            $enregBeControl = new EnregistrementBeController($pdo);
            $enregBe = $enregBeContol->findByLivreNumBeAction($_POST['affectDosEnregBeLivreNum']);
            if (!$enregBeControl->updateEtatBetweenDelegateAndChek($enregBe)) {
                exit('Bad update status between delegate and chek when affected!');
            }                 

            header('location:http://drcf.dev.com?showListsAffect');
            exit();  
          
        }catch (\Throwable $th) {
            throw $th;
        }
        
    }    

    //FIND VERIFY BE AFTER REJECT
        if (isset($_POST['findEnregBeIdAfteReject'])) {
            $servSecurity = new ServiceSecurity($pdo);
            $enregBeControl = new EnregistrementBeController($pdo);
            try {
                $pdo->beginTransaction();
                $enregBe =  $enregBeControl->findByIdAction((int) $_POST['findEnregBeIdAfteReject']);
                $enregBe->setEnregBeEtatVerifAfterRejet(true);
                    //var_dump( $enregBe);die;
                if (!$enregBeControl->updateEtatVerifAfterRejet($enregBe)) {
                exit('Bad request when update after reject!');
                }
                $pdo->commit();
                header('location:http://drcf.dev.com?listsCheckedFolder');
                exit();
            
            }catch (\Throwable $th) {
                throw $th;
            }

        }

    //RECORD Mouvement  History
     if (isset($_POST['mouvHistoEnregBeLivreNum']) || isset($_POST['mouvHistoEnregBeNum']) || isset($_POST['mouvHistoDest']) || isset($_POST['mouvHistoDateEnvoiCrea']) || isset($_POST['mouvHistoDateRetourCrea']) || isset($_POST['mouvHistoDateReceptionCrea']) || isset($_POST['mouvHistoEtatEnvoi']) || isset($_POST['mouvHistoEtatRetour']) || isset($_POST['mouvHistoEtatReception'])) {
        
        //die($_POST['mouvHistoEnregBeLivreNum']);
        $servSecurity = new ServiceSecurity($pdo);
        $mouvHistoControl = new MouvementHistoriqueController($pdo);
        $mouvHisto = new MouvementHistorique();

        try {
           
            //To Record SENDED Folder Between to each Agent here(From vericateur, to Delegue)
            if (isset($_POST['mouvHistoDest']) && !empty($_POST['mouvHistoDest']) && isset($_POST['ENVOI_AU_DELEGUE']) && !empty($_POST['ENVOI_AU_DELEGUE'])) {
                $pdo->beginTransaction();
                $userDest = $servSecurity->getUserById( (int) $_POST['mouvHistoDest']);
                $mouvHisto->setMouvHistoDest($userDest);
                $mouvHisto->setMouvHistoEnregBeLivreNum($_POST['mouvHistoEnregBeLivreNum']);
                $mouvHisto->setMouvHistoType('ENVOI_AU_DELEGUE');
                $mouvHisto->setMouvHistoEtatEnvoi(true);
                $mouvHisto->setMouvHistoDateEnvoiCrea(date('y-m-d H:i:s'));
                if (!$mouvHistoControl->updateSendMouvement($mouvHisto)) {
                    exit('Bad when saving Mouvement history!');
                } 
                $pdo->commit();
                header('location:http://drcf.dev.com?listsReadedFolder');
                exit(); 

            }

            //To Record RETURN Folder Between to each Agent here( FROM Delegue,to Courie)
            if (isset($_POST['mouvHistoDest']) && !empty($_POST['mouvHistoDest']) && isset($_POST['RETOUR_AU_COURIEL']) && !empty($_POST['RETOUR_AU_COURIEL'])) {
                $pdo->beginTransaction();
                $userDest = $servSecurity->getUserById( (int) $_POST['mouvHistoDest']);
                $mouvHisto->setMouvHistoDest($userDest);
                $mouvHisto->setMouvHistoEnregBeLivreNum($_POST['mouvHistoEnregBeLivreNum']);
                $mouvHisto->setMouvHistoType('RETOUR_AU_COURIEL');
                $mouvHisto->setMouvHistoEtatRetour(true);
                $mouvHisto->setMouvHistoDateRetourCrea(date('y-m-d H:i:s'));
                if (!$mouvHistoControl->updateReturnMouvement($mouvHisto)) {
                    exit('Bad when updating Mouvement history!');
                }
                $pdo->commit();
                header('location:http://drcf.dev.com?listsCheckedFolder');
                exit(); 
            }
            //To Record RETURN Folder Between to each Agent here( FROM Delegue, to Verificateur)
            if (isset($_POST['mouvHistoDest']) && !empty($_POST['mouvHistoDest']) && isset($_POST['RETOUR_AU_VERIFICATEUR']) && !empty($_POST['RETOUR_AU_VERIFICATEUR'])) {
                $pdo->beginTransaction();
                $userDest = $servSecurity->getUserById( (int) $_POST['mouvHistoDest']);
                $mouvHisto->setMouvHistoDest($userDest);
                $mouvHisto->setMouvHistoEnregBeLivreNum($_POST['mouvHistoEnregBeLivreNum']);
                $mouvHisto->setMouvHistoType('RETOUR_AU_VERIFICATEUR');
                $mouvHisto->setMouvHistoEtatRetour(true);   
                $mouvHisto->setMouvHistoDateRetourCrea(date('y-m-d H:i:s'));
                if (!$mouvHistoControl->updateReturnMouvement($mouvHisto)) {
                    exit('Bad when updating Mouvement history!');
                } 
                $pdo->commit();
                header('location:http://drcf.dev.com?listsCheckedFolder');
                exit(); 
            }
            
            //To Confirm Acceptation Folder Between to each Agent here( to vericateur, Delegue, courilleur)
            if (isset($_POST['mouvType']) && isset($_POST['mouvHistoEnregBeLivreNum']) && isset($_POST['mouvHistoEtatReception']) && !empty($_POST['mouvHistoEtatReception']) || isset($_POST['mouvType']) && isset($_POST['mouvHistoEnregBeLivreNum']) && isset($_POST['mouvHistoCourielEtatReception']) && !empty($_POST['mouvHistoCourielEtatReception']) || isset($_POST['mouvType']) && isset($_POST['mouvHistoEnregBeLivreNum']) && isset($_POST['mouvHistoCheckEtatReception']) && !empty($_POST['mouvHistoCheckEtatReception'])) {
                $pdo->beginTransaction();
                $mouvHisto->setMouvHistoType($_POST['mouvType']);
                $mouvHisto->setMouvHistoEnregBeLivreNum($_POST['mouvHistoEnregBeLivreNum']);
                $mouvHisto->setMouvHistoEtatReception(true);
                $mouvHisto->setMouvHistoDateReceptionCrea(date('y-m-d H:i:s'));
                if (!$mouvHistoControl->updateEtatAcceptation($mouvHisto)) {
                    exit('Bad when updating Mouvement history!');
                } 
                $pdo->commit();
                //To go verifier folrder when accept it
                if (isset($_POST['mouvHistoEtatReception']) && !empty($_POST['mouvHistoEtatReception'])) {
                    header('location:http://drcf.dev.com?listsCheckedFolder');
                    exit(); 
                }
                //To go viser folrder when accept it
                if(isset($_POST['mouvHistoCourielEtatReception']) && !empty($_POST['mouvHistoCourielEtatReception'])){
                    header('location:http://drcf.dev.com?listsSeenFolder');
                    exit();
                }
                //To go reject folrder when accept it
                if(isset($_POST['mouvHistoCheckEtatReception']) && !empty($_POST['mouvHistoCheckEtatReception'])){
                    header('location:http://drcf.dev.com?listsRejectFolder');
                    exit();
                }
            } 
        }catch (\Throwable $th) {
            throw $th;
        }

     }


    //RECORD TEF TEF TEF TEF
    if (isset($_POST['enregTefEnregBeLivreNum']) && isset($_POST['enregTefEnregBeNum']) && isset($_POST['enregTefNum']) && isset($_POST['enregTefObjet'])) {
        $servSecurity = new ServiceSecurity($pdo);  
        $enregTef = new EnregistrementTef();
        $tefControl = new TefController($pdo);
        try {  
            $pdo->beginTransaction();
            $user = $servSecurity->getUserById( (int) $_SESSION['id']);
            $enregTef->setEnregTefUserId($user);
            $enregTef->setEnregTefEnregBeLivreNum($_POST['enregTefEnregBeLivreNum']);
            $enregTef->setEnregTefEnregBeNum($_POST['enregTefEnregBeNum']);
            $enregTef->setEnregTefNum($_POST['enregTefNum']);
            $enregTef->setEnregTefObjet($_POST['enregTefObjet']);
            $enregTef->setEnregTtefNumVisa($_POST['enregTtefNumVisa']);
            $enregTef->setEnregTefDate($_POST['enregTefDate']);
            $enregTef->setEnregTefEtat(true);
            $enregTef->setEnregTefDateCrea(date('y-m-d H:i:s'));
            $status = $tefControl->saveAction($enregTef);
            if (!$status) {
                exit('Bad resgistrator');
            }
            //Update Def visa by num livre
            $enregDefControl = new EnregistrementDefController($pdo);
            $enregDef = $enregDefControl->findByIdAction($_POST['enregTefEnregBeLivreNum']);
            $enregDef->setEnregDefVisa($_POST['enregTtefNumVisa']);
            if (!$enregDefControl->updateVisaOfDefWhenAddTef($enregDef)) {
                exit('Bad update visa def after add tef !');
            }

            $pdo->commit();
            header('location:http://drcf.dev.com?listsTefRecorded');
            exit();
        } catch (\Throwable $th) {
            throw $th;
            die('Error during the resitrator BE');
        }

    }


    /**
     * 
     * GET ALL LISTS BEGIN HERE
     * 
     */
    //Get all lists BE 
    if (isset($_GET['listsBeRecord']) || isset($_GET['listsBeRecord']) && isset($_GET['sendReaded'])) {
        $enregBe = new EnregistrementBe();
        $enregBeControl = new EnregistrementBeController($pdo);
        $listsbe = $enregBeControl->selectAllAction();
        try {
            if ($listsbe == null) {
                exit('No BE lists in record!');
            }

            if (!isset($_GET['sendReaded'])) {
                $message = '';
            }
            else {
                $message = 'Information de lecture a été bien enregistrée';
            }
            
            //print_r($listsbe);die;
        
            echo $twig->render('index.html.twig', ['showListsCouriels'=> true, 'listsBe'=> $listsbe,
                            'showFormLecture'=> true,  'showFormAddCouriel'=> true, 'loged'=>true,
                            'message'=> $message, 'logsecurity'=> $_SESSION['username']
                            ]);
            exit();



        } catch (\Throwable $th) {
            throw $th;
        }
            
    }

    //Get all Lists of readed Folder
    if (isset($_GET['listsReadedFolder']) || isset($_GET['listsReadedFolder']) && isset($_GET['sendChecked'])) {

        $lectDosControl = new lectureDossierController($pdo);
        $listsLects = $lectDosControl->selectAllAction();
        $userSecurity = new ServiceSecurity($pdo);
        $users = $userSecurity->listeUsers();
        $affectDosControl = new AffectationDossierController($pdo);
        $affectsDos = $affectDosControl->selectAllAffectationOnly();
        $mouvHistoControl = new MouvementHistoriqueController($pdo);
        $mouvHistos = $mouvHistoControl-> selectAllMouvementOnly();

        try {
            if ($listsLects == null) {
                exit('No Lecture yet lists record!');
            }

            if (isset($_GET['sendChecked'])) {
                $message = 'Validation de votre verification a été enregistrée';
            }
            else {
                $message = '';
            }

            //print_r($listsLect);die;
            echo $twig->render('index.html.twig', ['showListsCourielsReaded'=> true, 'listsBe'=> $listsLects, 
                                'showFormCheckFolder' => true, 'message'=> $message, 'loged'=>true,
                                'logsecurity'=> $_SESSION['username'], 'role'=> $_SESSION['role'], 
                                'users'=> $users, 'showAffectationFolder'=> true, 'affectsDos'=> $affectsDos,
                                'showComfirmSendToDlegate'=> true, 'sessionUserId'=> $_SESSION['id'],
                                'mouvHistos'=> $mouvHistos
                                ]);
            exit();

        } catch (\Throwable $th) {
            throw $th;
        }

    }

    //Get all Lists of checked Folder
    if (isset($_GET['listsCheckedFolder'])) {

        $verifDosControl = new VerifierDossierController($pdo);
        $listsVerifDos = $verifDosControl->selectAllAction();
        $userSecurity = new ServiceSecurity($pdo);
        $users = $userSecurity->listeUsers();
        $mouvHistoControl = new MouvementHistoriqueController($pdo);
        $mouvHistos = $mouvHistoControl-> selectAllMouvementOnly();
        //print_r($listsVerifDos);die;    
        try {
            if ($listsVerifDos == null) {
                exit('No Folder checked yet lists in record!');
            }
            $message = '';
            //print_r($listsVerifDos);die;
            echo $twig->render('index.html.twig', ['showListsCourielsChecked'=> true, 
                            'listsBe'=> $listsVerifDos, 'message'=>  $message, 
                            'loged'=> true, 'logsecurity'=> $_SESSION['username'], 
                            'sessionUserId'=> $_SESSION['id'], 'mouvHistos'=> $mouvHistos,
                            'users'=> $users
                            ]);
                           
                            
            exit();
            
        } catch (\Throwable $th) {
            throw $th;
        }

    }
    //Get all Lists of checked Folder after seen
    if (isset($_GET['listsCheckedFolderAfterSeen'])) {

        $verifDosControl = new VerifierDossierController($pdo);
        $listsVerifDos = $verifDosControl->selectAllAction();
        $userSecurity = new ServiceSecurity($pdo);
        $users = $userSecurity->listeUsers();
        $mouvHistoControl = new MouvementHistoriqueController($pdo);
        $mouvHistos = $mouvHistoControl-> selectAllMouvementOnly();
        try {
            if ($listsVerifDos == null) {
                exit('No Lecture yet lists record!');
            }
            //print_r($listsLect);die;

            $message = 'Dossier visé a été bien enregistré';
         

            $message = 'Dossier visé a été bien enregistré';
            echo $twig->render('index.html.twig', ['showListsCourielsChecked'=> true, 
                                'listsBe'=> $listsVerifDos, 'message'=> $message, 
                                'loged'=>true, 'logsecurity'=> $_SESSION['username'],
                                'sessionUserId'=> $_SESSION['id'], 'mouvHistos'=> $mouvHistos,
                                'users'=> $users
                                ]);
            exit();
            
        } catch (\Throwable $th) {
            throw $th;
        }

    }
    //Get all Lists of checked Folder after reject
    if (isset($_GET['listsCheckedFolderAfterReject'])) {

        $verifDosControl = new VerifierDossierController($pdo);
        $listsVerifDos = $verifDosControl->selectAllAction();
        $userSecurity = new ServiceSecurity($pdo);
        $users = $userSecurity->listeUsers();
        $mouvHistoControl = new MouvementHistoriqueController($pdo);
        $mouvHistos = $mouvHistoControl-> selectAllMouvementOnly();
        try {
            if ($listsVerifDos == null) {
                exit('No Lecture yet lists record!');
            }

            $message = 'Dossier rejet a été bien enregistré';
       
            //print_r($listsLect);die;
           
            echo $twig->render('index.html.twig', ['showListsCourielsChecked'=> true, 
                            'listsBe'=> $listsVerifDos, 'message'=> $message, 
                            'loged'=>true, 'logsecurity'=> $_SESSION['username'], 
                            'mouvHistos'=> $mouvHistos, 'users'=> $users,
                            'sessionUserId'=> $_SESSION['id']
                            ]);
            exit();
            
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    //Get all Lists of Seen Folder
    if (isset($_GET['listsSeenFolder']) || isset($_GET['listsSeenFolder']) && isset($_GET['sendVisa'])) {

        $viseDosControl = new ViserDossierController($pdo);
        $listsViseDos = $viseDosControl->selectAllAction();
        $mouvHistoControl = new MouvementHistoriqueController($pdo);
        $mouvHistos = $mouvHistoControl-> selectAllMouvementOnly();

        try {
            if ($listsViseDos == null) {
                exit('No Lecture yet lists record!');
            }
            //print_r($listsLect);die;

            if (isset($_GET['sendVisa'])) {
                $message = 'Creation de visa a été bien enregistrée';
            }
            else {
                $message = '';
            }

            echo $twig->render('index.html.twig', ['showListsCourielsSeen'=> true, 
                                'listsBe'=> $listsViseDos, 'showFormVisaRecordFolder' => true, 
                                'loged'=>true, 'logsecurity'=> $_SESSION['username'], 
                                'sessionUserId'=> $_SESSION['id'], 'mouvHistos'=> $mouvHistos 
                                ]);
            exit();
            
        } catch (\Throwable $th) {
            throw $th;
        }


    }

    //Get all Lists of Reject Folder
    if (isset($_GET['listsRejectFolder'])) {

        $rejectDosControl = new RejeterDossierController($pdo);
        $listsRejectDos = $rejectDosControl->selectAllAction();
        $mouvHistoControl = new MouvementHistoriqueController($pdo);
        $mouvHistos = $mouvHistoControl-> selectAllMouvementOnly();
        try {
            if ($listsRejectDos == null) {
                exit('No yet Folder lists record!');
            }
            //print_r($listsLect);die;
            echo $twig->render('index.html.twig', ['showListsCourielsReject'=> true, 'listsBe'=> $listsRejectDos, 
                                'showFormCreateVisa' => true, 'loged'=>true, 'logsecurity'=> $_SESSION['username'],
                                'sessionUserId'=> $_SESSION['id'], 'mouvHistos'=> $mouvHistos 
                                ]);
            exit();
            
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    //Get all Lists of Visa created Folder
    if (isset($_GET['listsVisaCreated'])) {

        $enregVisaControl = new EnregistrementVisaController($pdo);
        $listsvisa = $enregVisaControl->selectAllAction();
        try {
            if ($listsvisa == null) {
                exit('No yet VISA lists record!');
            }
            //print_r($listsLect);die;
            echo $twig->render('index.html.twig', ['showListsVisaCreated'=> true, 'listsBe'=> $listsvisa,
                            'loged'=>true, 'logsecurity'=> $_SESSION['username'],
                            'sessionUserId'=> $_SESSION['id']
                            ]);
            exit();
            
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    //GET DISTRIBUTION LISTES
    if (isset($_GET['listDistribitions'])) {
        $distribDosControl = new DistributionDossierController($pdo);
        $distribs = $distribDosControl->selectAllAction();
        try {
            if ($distribs == null) {
                exit('No yet VISA lists record!');
            }
            //print_r($listsLect);die;
            echo $twig->render('index.html.twig', ['showListsCourielsDistribution'=> true, 'listsBe'=> $distribs,
                            'loged'=>true, 'logsecurity'=> $_SESSION['username']
                            ]);
            exit();
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    /**
    * METHODE GET OBJECT BY ID BIGIN HERE
    * 
    **/

    //Get BE by id
    if (isset($_GET['findBe'])) {
        $enregBe = new EnregistrementBe();
        $enregBeControl = new EnregistrementBeController($pdo);
        $be = $enregBeControl->findByIdAction( (int) $_GET['findBe'] );
        try {
            if ($be == null) {
                exit('BE not find!');
            }

            echo $twig->render('index.html.twig', ['showDetailCouriels'=> true, 'listsBe'=> $be,
                            'loged'=>true, 'logsecurity'=> $_SESSION['username']
                            ]);
            exit();



        } catch (\Throwable $th) {
            throw $th;
        }       
    }

    // GET LISTS Affectation
    if (isset($_GET['showListsAffect']) || isset($_GET['showAffectAfterSave'])) {
        $affectDosControl = new AffectationDossierController($pdo);
        $listAffects = $affectDosControl->selectAllAction();
        try {
            if ($listAffects == null) {
                exit('BE affectation not find!');
            }

            if (isset($_GET['showAffectAfterSave'])) {
               $message = 'Enregistrement fait!';
            }
            else {
                $message = '';
            }

            echo $twig->render('index.html.twig', ['showListsAffectAdded'=> true, 'listsBe'=> $listAffects,
                            'loged'=>true, 'logsecurity'=> $_SESSION['username'],  'sessionUserId'=> $_SESSION['id'],
                            'role'=> $_SESSION['role']
                            ]);
            exit();



        } catch (\Throwable $th) {
            throw $th;
        }       
    }

    //GET LISTS Mouvement History
    if (isset($_GET['showListsMouvement'])) {
        
        $MouvHistoControl = new MouvementHistoriqueController($pdo);
        $MouveHistos = $MouvHistoControl->selectMouvementHistoriques();
        $servSecurity = new ServiceSecurity($pdo);
        $users = $servSecurity->listeUsers();      

        $arrayMouments= array();

        foreach ($MouveHistos as $key => $value) {
            $arrayMouments[$value['mouv_histo_enreg_be_livre_num']][$value['mouv_histo_type']] = $value;
        }
        print_r($arrayMouments);die();

        try {
            if ($MouveHistos == null) {
                exit('Mouvement history not find!');
            }

            echo $twig->render('index.html.twig', ['showListsMouvementAdded'=> true, 'listsBe'=> $arrayMouments,
                            'loged'=>true, 'logsecurity'=> $_SESSION['username'], 'users'=> $users, 
                            'sessionUserId'=> $_SESSION['id']
                            ]);
            exit();

        } catch (\Throwable $th) {
            throw $th;
        }       

    }

    //LOCALISATION MOUVEMENT FOLDER
    if (isset($_GET['showFolderPlacement']) || isset($_POST['searchLivreNume'])) {
        
        $servSecurity = new ServiceSecurity($pdo);
        $users = $servSecurity->listeUsers();

        if(isset($_POST['searchLivreNume']) && !empty($_POST['searchLivreNume'])) {

           $mouvHistoControl = new MouvementHistoriqueController($pdo);
            $inCouriel = $mouvHistoControl->findFolderIfItIsAtCouriel($_POST['searchLivreNume']);
            $inCheker = $mouvHistoControl->findFolderIfItIsAtChecker($_POST['searchLivreNume']);
            $inDelegate = $mouvHistoControl->findFolderIfItIsAtDelegue($_POST['searchLivreNume']);
            $atDelegateWhenAffects = $mouvHistoControl->findFolderIfItIsAtDelegueWhenAffectation($_POST['searchLivreNume']);
            $atCheckerWhenAffects = $mouvHistoControl->findFolderIfItIsAtChekerWhenAffectation($_POST['searchLivreNume']);

            try {

                echo $twig->render('index.html.twig', ['showListFindLocationFolder'=> true,
                                'loged'=>true, 'logsecurity'=> $_SESSION['username'], 'users'=> $users, 
                                'sessionUserId'=> $_SESSION['id'], 'show'=> true,
                                'inCouriel'=> $inCouriel, 'inCheker'=> $inCheker, 'inDelegate'=> $inDelegate,
                                'searchLivreNume'=> $_POST['searchLivreNume'],
                                'atDelegateWhenAffects'=> $atDelegateWhenAffects, 
                                'atCheckerWhenAffects'=> $atCheckerWhenAffects
                                ]);
                exit();
        
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        else{

            echo $twig->render('index.html.twig', ['showListFindLocationFolder'=> true, 'loged'=>true,
            'logsecurity'=> $_SESSION['username'], 'users'=> $users, 
            'sessionUserId'=> $_SESSION['id'], 'role'=> $_SESSION['role']
            ]);
            exit();
        }   

    }

    //GET LIST DEF 
    if (isset($_GET['listsDefRecorded'])) {

        $defControl = new EnregistrementDefController($pdo);
        $defs = $defControl->selectAllAction();
        $servSecurity = new ServiceSecurity($pdo);
        $users = $servSecurity->listeUsers();
        
        try {
            if ($defs == null) {
                exit('DF not find!');
            }

            echo $twig->render('index.html.twig', ['showListsDefAdded'=> true, 'listsBe'=> $defs,
                            'loged'=>true, 'logsecurity'=> $_SESSION['username'], 'users'=> $users, 
                            'sessionUserId'=> $_SESSION['id'], 'role'=> $_SESSION['role']
                            ]);
            exit();

        } catch (\Throwable $th) {
            throw $th;
        }      

    }

    //GET LIST TEF showListsTefAdded
    if (isset($_GET['listsTefRecorded'])) {
        $tefControl = new TefController($pdo);
        $tefs = $tefControl->selectAllAction();
        $servSecurity = new ServiceSecurity($pdo);
        $users = $servSecurity->listeUsers();
        
        try {
            if ($tefs == null) {
                exit('DF not find!');
            }

            echo $twig->render('index.html.twig', ['showListsTefAdded'=> true, 'listsBe'=> $tefs,
                            'loged'=>true, 'logsecurity'=> $_SESSION['username'], 'users'=> $users, 
                            'sessionUserId'=> $_SESSION['id'], 'role'=> $_SESSION['role']
                            ]);
            exit();

        } catch (\Throwable $th) {
            throw $th;
        }      
    }

    //GET LIST TOTAL SITUATION Couriel Filter by month or date
    if (isset($_GET['statistiqueCoriel']) || isset($_POST['dateYear']) || isset($_POST['dateMounth1']) || isset($_POST['dateMounth2'])) {
        $situationControl = new SituationController($pdo);
        $servSecurity = new ServiceSecurity($pdo);
        $users = $servSecurity->listeUsers();

        if (!empty($_POST['dateMounth1']) && !empty($_POST['dateMounth2'])) {
            //die(date("Y-m-d", strtotime($_POST['dateMounth1'])) . '  ' . date("Y-m-d", strtotime($_POST['dateMounth2'])));
            $rejectTotals = $situationControl->TotalCourielRejectFilter(date("Y-m-d", strtotime($_POST['dateMounth1'])), date("Y-m-d", strtotime($_POST['dateMounth2'])));
            $viseTotals = $situationControl->TotalCourielViseFilter(date("Y-m-d", strtotime($_POST['dateMounth1'])), date("Y-m-d", strtotime($_POST['dateMounth2'])));

            //List statistique DEF
            $rejectDefTotals =  $situationControl->totalDefRejeter(date("Y-m-d", strtotime($_POST['dateMounth1'])), date("Y-m-d", strtotime($_POST['dateMounth2'])));
            $viseDefTotals =  $situationControl->totalDefViser(date("Y-m-d", strtotime($_POST['dateMounth1'])), date("Y-m-d", strtotime($_POST['dateMounth2'])));
            $motifDefs =  $situationControl->motifDefRejeter(date("Y-m-d", strtotime($_POST['dateMounth1'])), date("Y-m-d", strtotime($_POST['dateMounth2'])));
            //total courie enregistrer
            $tatalcouries = $situationControl->totalCourieEnregistrer(date("Y-m-d", strtotime($_POST['dateMounth1'])), date("Y-m-d", strtotime($_POST['dateMounth2'])));

            //list rejeter couries
            $listRejectCouries = $situationControl->listCourieRejet(date("Y-m-d", strtotime($_POST['dateMounth1'])), date("Y-m-d", strtotime($_POST['dateMounth2'])));

            echo $twig->render('index.html.twig', ['showListStatistique'=> true, 'loged'=>true,
                'logsecurity'=> $_SESSION['username'], 'users'=> $users, 
                'sessionUserId'=> $_SESSION['id'], 'role'=> $_SESSION['role'],
                'rejectTotals'=> $rejectTotals, 'viseTotals'=> $viseTotals, 'show'=> true,
                'dateMounth1'=> $_POST['dateMounth1'], 'dateMounth2'=> $_POST['dateMounth2'],
                'rejectDefTotals'=> $rejectDefTotals, 'viseDefTotals'=> $viseDefTotals,
                'listRejectCouries'=> $listRejectCouries, 'tatalcouries'=>  $tatalcouries,
                'motifDefs'=>  $motifDefs
            ]);
           exit();
        }

        if (!empty($_POST['dateYear'])) {
            $rejectTotals = $situationControl->TotalCourielRejectFilter($_POST['dateYear']);
            $viseTotals = $situationControl->TotalCourielViseFilter($_POST['dateYear']);

            //List statistique DEF
            $rejectDefTotals =  $situationControl->totalDefRejeter($_POST['dateYear']);
            $viseDefTotals =  $situationControl->totalDefViser($_POST['dateYear']);
            $motifDefs =  $situationControl->motifDefRejeter($_POST['dateYear']);

            //total couriel enregistrer
            $tatalcouries = $situationControl->totalCourieEnregistrer($_POST['dateYear']);

            //list rejeter couries
            $listRejectCouries = $situationControl->listCourieRejet($_POST['dateYear']);

            echo $twig->render('index.html.twig', ['showListStatistique'=> true, 'loged'=>true,
            'logsecurity'=> $_SESSION['username'], 'users'=> $users, 
            'sessionUserId'=> $_SESSION['id'], 'role'=> $_SESSION['role'],
            'rejectTotals'=> $rejectTotals, 'viseTotals'=> $viseTotals, 'show'=> true,
            'dateYear'=> $_POST['dateYear'],'rejectDefTotals'=> $rejectDefTotals, 
            'viseDefTotals'=> $viseDefTotals, 'listRejectCouries'=> $listRejectCouries,
            'tatalcouries'=>  $tatalcouries, 'motifDefs'=>  $motifDefs
            ]);
         
           exit();
        }

        if (isset($_GET['statistiqueCoriel'])) {
            echo $twig->render('index.html.twig', ['showListStatistique'=> true, 'loged'=>true,
             'logsecurity'=> $_SESSION['username'], 'users'=> $users, 
            'sessionUserId'=> $_SESSION['id'], 'role'=> $_SESSION['role']
            ]);
            exit();
        }

    }

    // SITUATION D'ENGAGEMENT
    if(isset($_GET['situationEngagement']) || isset($_POST['searchDistrict']) && isset($_POST['searchDate']) ) {
        
        $situationControl = new SituationController($pdo);
        $servSecurity = new ServiceSecurity($pdo);
        $users = $servSecurity->listeUsers();

        if (isset($_POST['searchDistrict']) && isset($_POST['searchDate'])) {

            $situationEngagements = $situationControl->listRapportEngagementByDistrict($_POST['searchDistrict'], $_POST['searchDate']);
            $engagementTotals = $situationControl->totalModPassByDistrict($_POST['searchDistrict'], $_POST['searchDate']);

            echo $twig->render('index.html.twig', ['showListSituation'=> true, 'loged'=>true,
            'logsecurity'=> $_SESSION['username'], 'users'=> $users, 'show'=> true,
            'sessionUserId'=> $_SESSION['id'], 'role'=> $_SESSION['role'],
            'listsBe'=> $situationEngagements, 'engagementTotals'=> $engagementTotals,
             'searchDistrict'=> $_POST['searchDistrict'], 'searchDate'=> $_POST['searchDate']
            ]);
            exit();
        }

        if (isset($_GET['situationEngagement'])) {
            
            echo $twig->render('index.html.twig', ['showListSituation'=> true, 'loged'=>true,
            'logsecurity'=> $_SESSION['username'], 'users'=> $users, 
            'sessionUserId'=> $_SESSION['id'], 'role'=> $_SESSION['role']
            ]);
            exit();
        }

    }


} //End test session

//SING OUT
if (isset($_GET[''])) {
    session_destroy();
    // header('location:http://drcf.dev.com');
    // exit();
}

/**
 * REDIRECT WHENE WITHOUT SESSION LOGIN
 */
// session_start();

echo $twig->render('index.html.twig', ['showLoginPage'=> true]);
exit();