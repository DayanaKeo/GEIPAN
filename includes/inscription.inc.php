<?php 

if (isset($_POST['inscription']))
{
    $userName = htmlentities(trim(mb_strtoupper($_POST['userName']))) ?? '';
    $userFirstName = htmlentities(ucfirst(mb_strtolower(trim($_POST['userFirstName'])))) ?? '';
    $userMail = htmlentities(mb_strtolower(trim($_POST['userMail']))) ?? '';
    $userPassword = htmlentities(trim($_POST['userPassword'])) ?? '';
    $verifPassword = htmlentities(trim($_POST['verifPassword'])) ?? '';

    $erreur = array();

    if (!preg_match("/(*UTF8)^[[:alpha:]]+$/", html_entity_decode($userName))){
        array_push($erreur, "Veuillez saisir votre nom");
    }
    else 
    {
        $userName = html_entity_decode($userName);
    }

    if (!preg_match("/(*UTF8)^[[:alpha:]]+$/", html_entity_decode($userFirstName))){
        array_push($erreur, "Veuillez saisir votre prénom");
    }
    else{
        $userFirstName = html_entity_decode($userFirstName);
    }

    if (!filter_var($userMail, FILTER_VALIDATE_EMAIL)){
        array_push($erreur, "Veuillez saisir un mail valide");
    }

    if (strlen($userPassword) === 0){
        array_push($erreur, "Veuillez saisir un mot de passe");
    }

    if (strlen($verifPassword) === 0){
        array_push($erreur, "Veuillez saisir la vérification du mot de passe");
    }

    if ($userPassword !== $verifPassword){
        array_push($erreur, "Le mot de passe ne correspond pas");
    }

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        
        $fileName = $_FILES['avatar']['name'];
        $fileType = $_FILES['avatar']['type'];
        $fileTmpName = $_FILES['avatar']['tmp_name'];
        
        $tableauTypes = array("image/jpeg", "image/jpg", "image/png", "image/gif");

        if (in_array($fileType, $tableauTypes)) {
            $path = getcwd() . "/avatars/";
            $date = date('dmYhis');
            $fileName = $date . $fileName;
            $fileNameFinal = $path . $fileName;
            $fileNameFinal = str_replace("\\", "/", $fileNameFinal);
        }
        else {
            array_push($erreur, "Erreur type MIME");
        }
    } else {
        $fileUploadError = $_FILES['avatar']['error'] ;
        
        switch($fileUploadError) {
            case 1 :
                $fileUploadErrorMessage = "La taille du fichier téléchargé excède la valeur de upload_max_filesize.";
            break;
            case 2 :
                $fileUploadErrorMessage = "La taille du fichier téléchargé excède la valeur de MAX_FILE_SIZE, qui a été spécifiée dans le formulaire HTML.";
            break;
            case 3 :
                $fileUploadErrorMessage = "Le fichier n'a été que partiellement téléchargé.";
            break;
            case 4 :
                $fileUploadErrorMessage = "Aucun fichier n'a été téléchargé.";
            break;
            case 6 :
                $fileUploadErrorMessage = "Un dossier temporaire est manquant.";
            break;
            case 7 :
                $fileUploadErrorMessage = "Échec de l'écriture du fichier sur le disque.";
            break;
            case 8 :
                $fileUploadErrorMessage = "Une extension PHP a arrêté l'envoi de fichier.";
            break;
        }

        array_push($erreur, "Erreur upload : " . $fileUploadErrorMessage);
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

            $requete = $conn->prepare("SELECT * FROM users WHERE userMail = '$userMail'");
            $requete->execute();
            $resultat = $requete->fetchAll(PDO::FETCH_OBJ);

            if(count($resultat) !== 0){
                echo "<p>Votre adresse est déjà dans la base de donnée</p>";
            }

            else 
            {
                $query = $conn->prepare(
                    "INSERT INTO users(userName, userFirstname, userMail, userPassword, userAvatar)
                    VALUES (:userName, :userFirstName, :userMail, :userPassword, :avatar);"
                );

                $query->bindParam(':userName', $userName, PDO::PARAM_STR_CHAR);
                $query->bindParam(':userFirstName', $userFirstName, PDO::PARAM_STR_CHAR);
                $query->bindParam(':userMail', $userMail, PDO::PARAM_STR_CHAR);
                $query->bindParam(':userPassword', $userPassword);
                $query->bindParam(':avatar', $fileNameFinal);

                $query->execute();

                move_uploaded_file($fileTmpName, $path . $fileName );

                
                echo "<p>Insertions effectuées avec succès</p>";
                // echo "<script>
                // document.location.replace('http://localhost/geipan/index.php?page=login')
                // </script>";
            }

        }
        catch (PDOException $e)
        {
            die("Erreur : " . $e->getMessage());
        }

        $conn = null;
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
    echo "Merci de renseigner le formulaire"; 
    $userName = $userFirstName = $userMail = "";
}

include 'frmInscription.php';