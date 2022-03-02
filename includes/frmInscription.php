<form action="index.php?page=inscription" method="post">
    <ul>
        <li><label for="userName">Nom : </label><input type="text" name="userName" id="userName" value="<?php echo $userName?> " /> </li>
        <li><label for="userFirsteName">Prénom : </label><input type="text" name="userFirstName" id="userFirstName" value="<?php echo $userFirstName?> " /> </li>
        <li><label for="userMail">Votre mail : </label><input type="text" name="userMail" id="userMail" value="<?php echo $userMail?> " /> </li>
        <li><label for="userPassword">Votre mot de passe : </label><input type="password" name="userPassword" id="userPassword" value="<?php echo $userPassword?> " /> </li>
        <li><label for="verifPassword">Confirmer votre mot de passe : </label><input type="password" name="verifPassword" id="verifPassword" value="<?php echo $verifPassword?> " /> </li>
        <li><label for="avatar">Avatar : </label><input type="file" name="avatar" id="avatar" value="<?php echo $avatar?> " /> </li>
        <input type="reset" value="Effacer" />
        <input type="submit" value="S'inscrire" name="inscription" />

    
    
    
    
    </ul>
</form>