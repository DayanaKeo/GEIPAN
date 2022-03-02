<h1>Votre Témoignage</h1>

<form action="index.php?page=temoignage" method="post">
<label for="userMail">Votre mail : </label><input type="text" name="userMail" id="userMail" value="<?php echo $userMail?> " /> <br />
<label for="datEvent">Date de l'évènement : </label><input type="date" id="date" name="date" value="<?php echo $datEvent?>" >; <br />
<label for="heure">Heure de l'évènement : </label><input type="time" id="heure" name="heure" value="<?php echo $heure?>" >;<br />
<label for="duree">Durée de l'évènement : </label><input type="time" id="duree" name="duree" value="<?php echo $duree?>" >; <br />
<label for="lieu">Lieu de l'évènement : </label><input type="text" id="lieu" name="lieu" value="<?php echo $lieu?>" >; <br />

<label for="observation">Direction d'observation : </label>
<select name="observation" id="observation" value="<?php echo $observation ?> ">
    <option value="nord">Nord</option>
    <option value="nordEst">Nord-est</option>
    <option value="nordOuest">Nord-Ouest</option>
    <option value="est">Est</option>
    <option value="ouest">Ouest</option>
    <option value="sud">Sud</option>
    <option value="sudEst">Sud-est</option>
    <option value="sudOuest">Sud-ouest</option>
    <option value="nord">Nord</option>
</select> <br />
<label for="descriptions">Description de l'évènement : </label> <br />
<textarea name="descriptions" id="descriptions" placeholder="Veuillez décrire l'évènement survenu" value="<?php echo $descriptions?>"></textarea> <br />

<label for="temps">Météo au moment de l'évènement : </label><br />
<input type="radio" id="vent" name="temps">
<label for="vent">Venteux/Nuageux</label><br/>

<input type="radio" id="pluie" name="temps">
<label for="pluie">Pluvieux</label><br/>

<input type="radio" id="soleil" name="temps">
<label for="soleil">Ciel dégagé</label><br/>

<input type="radio" id="neige" name="temps">
<label for="neige">Enneigé</label><br/>

<input type="radio" id="brouillard" name="temps">
<label for="brouillard">Brouillard</label><br/>


<input type="reset" value="Effacer">
<input type="submit" value="Envoyer" name="envoyer">
</form>