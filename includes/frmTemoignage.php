<form action="index.php?page=temoignage" method="post">
<label for="date">Date de l'évènement : </label><input type="date" id="date" name="date" value="<?php echo $date?>" >; <br />
<label for="heure">Heure de l'évènement : </label><input type="time" id="heure" name="heure" value="<?php echo $heure?>" >;<br />
<label for="duree">Durée de l'évènement : </label><input type="time" id="duree" name="duree" value="<?php echo $duree?>" >; <br />
<label for="observation">Direction d'observation : </label>
<select name="observation" id="observation" value="$observation">
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
<label for="description">Description de l'évènement : </label> <br />
<textarea name="description" id="description" placeholder="Veuillez décrire l'évènement survenu"></textarea> <br />
<input type="reset" value="Effacer">
<input type="submit" value="Envoyer" name="envoyer">
</form>