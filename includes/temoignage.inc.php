<?php

if (isset($_POST['envoyer']))
{
    $userMail = htmlentities(mb_strtolower(trim($_POST['userMail']))) ?? '';
    $datEvent = $_POST['datEvent'] ?? '';
    $heure = $_POST['heure'] ?? '';
    $duree = $_POST['duree'] ?? '';
    $lieu = $_POST['lieu'] ?? '';
    $observation = $_POST['observation'] ?? '';
    $descriptions = htmlentities(trim($_POST['descriptions'])) ?? '';


    $erreur = array();

    if (!filter_var($userMail, FILTER_VALIDATE_EMAIL)){
        array_push($erreur, "Veuillez saisir un mail valide");
    }

    if (!preg_match("/ (?<digit>\d+)/", ctype_digit ($datEvent))){
        array_push($erreur, "Veuillez saisir la date");
    }
    else 
    {
        $datEvent = ctype_digit($datEvent);
    }

    if (!preg_match("/(?<digit>\d+)$/", ctype_digit($heure))){
        array_push($erreur, "Veuillez saisir l'heure");
    }
    else{
        $heure = ctype_digit($heure);
    }

    if  (!preg_match("/(?<digit>\d+)$/", ctype_digit($duree))){
        array_push($erreur, "Veuillez saisir la durée");
    }
    else{
        $duree = ctype_digit($duree);
    }

    if (strlen($lieu) === 0){
        array_push($erreur, "Veuillez saisir un lieu");
    }

    if (strlen($observation) === 0){
        array_push($erreur, "Veuillez sélectionner le champs d'observation'");
    }

    if (strlen($descriptions)){
        array_push($erreur, "Veuillez saisir une description de l'évènement");
    }
    

    if (count($erreur) === 0)
    {
        $serverName = "localhost";
        $userName = "root";
        $userPassword = "";
        $database = "geipan";

        try
        {
            $conn = new PDO("mysql:host=$serverName; dbname=$database", $userName, $userPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $userPassword = password_hash($userPassword, PASSWORD_DEFAULT);

            $requete = $conn->prepare("SELECT * FROM observations WHERE obslocation = '$lieu'");
            $requete->execute();
            $resultat = $requete->fetchAll(PDO::FETCH_OBJ);

            if(count($resultat) !== 0){
                echo "<p>Votre adresse est déjà dans la base de donnée</p>";
            }

            else 
            {
                $query = $conn->prepare(
                    "INSERT INTO observations(obsDateTime, obsDuration, obsLocation, obsCardinalPoint, obsWeather, obsDescription)
                    VALUES (:datEvent, :heure, :duree, :lieu, :observation, :temps, :descriptions);"
                );

                $query->bindParam(':datEvent', $datEvent);
                $query->bindParam(':heure', $heure);
                $query->bindParam(':duree', $duree);
                $query->bindParam(':lieu', $lieu, PDO::PARAM_STR_CHAR);
                $query->bindParam(':observation', $observation, PDO::PARAM_STR_CHAR);
                $query->bindParam(':temps', $temps, PDO::PARAM_STR_CHAR);
                $query->bindParam(':descriptions', $descriptions, PDO::PARAM_STR_CHAR);


                $query->execute();

                echo "<p>Insertions témoignages effectuées avec succès</p>";
                // echo "<script>
                // document.location.replace('http://localhost/geipan/index.php?page=login')
                // </script>";
            }

        }
        catch (PDOException $e)
        {
            die("Erreur : " . $e->getMessage());
        }

        // $conn = null;
    }

    else
    {
        $messageErreur = "<ul>";
        $cnt = 0;

        do
        {
            $messageErreur .= "<li>" . $erreur[$cnt] . "</li>";
            ++$cnt; 
        }
        while ($cnt<count($erreur)); 
        $messageErreur .= "</ul>";

        echo $messageErreur;
    }
    
    }
    else
    { 
        echo "Merci de renseigner le formulaire de témoignage"; 
        $userMail = $datEvent = $heure = $duree = $lieu = $observation = $descriptions = "";
    }




include 'frmTemoignage.php';