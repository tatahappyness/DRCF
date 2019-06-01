<?php

// ENvoi des information sur url 
header('Location:page2.php?login='.$_GET['login']);

//Insert oject to db;
$serializedObject = serialize($person);
$stmt = $pdo->prepare("INSERT INTO objects (data) VALUES (?)");
$stmt->execute(array( $serializedObject ));

//Retrive object from db
//Unserialize the data.
$person = unserialize($row['data']);
//Lets call the speak method / function on our object.
$person->speak();

//To run the local installation of webpack you can access its bin version as 
//node_modules/.bin/webpack.

// action distrib lire, verifier, viser, rejeter, visa, enregistrer

// SELECT * FROM `enregistrement_be` enreg INNER JOIN `verification_dossier` verif INNER JOIN `user` us ON enreg.id = verif.verif_dos_enreg_be_id_id AND verif.verif_dos_user_id_id = us.id WHERE enreg.enreg_be_etat_verifier IS NULL