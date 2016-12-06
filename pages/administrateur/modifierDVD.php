<?php
    if(isset($_SESSION['connexionAdministrateur']))
    {
?>
<nav class="menu">
		<?php
                    if (file_exists('./lib/php/menuAdministrateur.php'))
                    {
			include './lib/php/menuAdministrateur.php';
       		    }
               	    else
		    {
                        //tester l'existence du fichier pour que la page s'affiche même si le fichier manque (file_exists)
			echo "Il semblerait que nous ayions des problemes technique, veuillez nous en excuser .. ";
		    }
		?>
</nav>
<h1 class="aqua legerement_a_droite souligner">Modification d'un DVD</h1>
<?php 
            $flag=0;
            if(isset($_POST['Modifier']))
            {
                ?><br/><?php
		if($_POST['titre']!="" && $_POST['realisateur']!=""&& $_POST['scenariste']!=""&& $_POST['producteur']!=""
                        && $_POST['date_sortie']!=""&& $_POST['quantite']!=""&& $_POST['image_dvd']!="")
		{
                    if($_POST['quantite']>=1)
                    {
                        if(preg_match("#[A-Z -][A-Za-z -]+#",$_POST['realisateur']) == true )
                        {
                            if(preg_match("#[A-Z -][A-Za-z -]+#",$_POST['scenariste']) == true )
                            {
                                if(preg_match("#image[0-9]*\.[a-z]+#",$_POST['image_dvd']) == true )
                                {
                                    $log = new dvdBD($cnx);
                                    $retour=$log->modifierDVD($_SESSION['id_dvd'],$_POST['titre'],$_POST['realisateur'],$_POST['scenariste'],$_POST['producteur'],$_POST['date_sortie'],$_POST['quantite'],$_POST['image_dvd'],$_POST['description']);

                                    if($retour=='DVD mis à jour')
                                    {
                                        ?>
                                        <p class="deeppink grand">
                                            <?php
                                                print 'Le film ';
                                                print_r($_POST['titre']);
                                                print ' a bien été mis à jour dans la base de données.';
                                            ?>
                                            <br/>
                                        </p>
                                        <?php
                                    }
                                    else if ($retour!='DVD mis à jour')
                                    {
                                        ?>
                                        <p class="deeppink grand souligner">Un problème est intervenue.</p>
                                        <p class="deeppink">1.Les caractères spéciaux sont mal gérés par la base données.</p>
                                        <p class="deeppink">2.La contrainte d'unicité sur le couple titre/realisateur a été violé.</p>
                                        <p class="deeppink">3.Le lien utilisé pour l'image existe déjà dans la base de données.</p>
                                        <?php
                                    }
                                }
                                else
                                {
                                    echo '<p class="deeppink centre grand">Le réalisateur et le scénariste doivent être composé uniquement de lettres</p>';
                                    echo '<p class="deeppink centre grand">Ils doivent également commencer par une majuscule</p>';
                                    echo '<p class="deeppink centre grand">L image associé doit être au format : image2.jpg</p>';
                                }
                            }
                            else
                            {
                                echo '<p class="deeppink centre grand">Le réalisateur et le scénariste doivent être composé uniquement de lettres</p>';
                                echo '<p class="deeppink centre grand">Ils doivent également commencer par une majuscule</p>';
                                echo '<p class="deeppink centre grand">L image associé doit être au format : image2.jpg</p>';
                            }
                        }
                        else
                        {
                            echo '<p class="deeppink centre grand">Le réalisateur et le scénariste doivent être composé uniquement de lettres</p>';
                            echo '<p class="deeppink centre grand">Ils doivent également commencer par une majuscule</p>';
                            echo '<p class="deeppink centre grand">L image associé doit être au format : image2.jpg</p>';
                        }
                    }
                    else
                    {
                        ?>
                            <p class="evidence grand">La quantité doit être supérieure ou égale à 1.</p>
                            <br/>
                        <?php
                    }
                }
		else
		{
               	    ?>
                        <p class="evidence grand">Vous devez tout compléter.</p>
                        <br/>
                     <?php
		}	
            }
        ?>
<div class='legerement_a_droite'>
    <h2 class='evidence'>Veuillez entrer les informations du DVD à modifier.</h2>
    <h3 class='deeppink'>Les caractères spéciaux sont à éviter.</h3>
    <div class="container largeur">
        <div class="table table-bordered">  
            
                <form action="index.php?page=administrateur/modifierDVD.php" method="POST" class="form-horizontal cadre">
                    <div class="form-group">
                    <label class="control-label col-sm-2 evidence" for="titre">DVD à modifier :</label>
                    <div class="col-sm-10">
                    <?php            
                        $log = new dvdBD($cnx);
                        $data=$log->tousLesDVD();

                        $nbr= count($data);

                        if($nbr>0)
                        {
                            $tab = array();
                            echo "<select name=film>";
                            for($i = 0;$i < $nbr ;$i++)
                            {
                                $tab[$i] = $data[$i];
                                echo "<option value=".$tab[$i]['id_dvd'].">"."Titre : ".$tab[$i]['titre']." || Réalisateur : ".$tab[$i]['realisateur']." || Scénariste : ".$tab[$i]['scenariste']."</option>";
                            }
                            echo "</select>";
                        }
                        else
                        {
                            echo '<p class="deeppink">plus de films disponibles</p>';
                        }
                    ?>
                  </div>
                </div>
                <div class="form-group"> 
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" value="DVD_choisi" name="DVD_choisi">Modifier ce DVD</button>
                    <button type="reset" class="btn btn-danger">Annuler</button>
                  </div>
                </div>
                </form>
            
            <?php 
        if(isset($_POST['DVD_choisi']))
        {
            $DvdChoisi = $_POST['film']; // correspond à l'id du dvd choisi
                        
            $log = new dvdBD($cnx);
            $data=$log->informationsDVDDEpuisSonID($DvdChoisi);

            $nbr= count($data);

            for($i = 0;$i < $nbr ;$i++)
            {
                //print "<br>".$data[$i]['titre'];
                $_SESSION['id_dvd'] = $data[$i]['id_dvd'];
                $_SESSION['titre'] = $data[$i]['titre'];
                $_SESSION['realisateur'] = $data[$i]['realisateur'];
                $_SESSION['scenariste'] =$data[$i]['scenariste'];
                $_SESSION['producteur'] = $data[$i]['producteur'];
                $_SESSION['date_sortie'] = $data[$i]['date_sortie'];
                $_SESSION['quantite'] = $data[$i]['quantite'];
                $_SESSION['lien_image'] = $data[$i]['image_dvd'];
            }
        ?>
            
            <form action="index.php?page=administrateur/modifierDVD.php" method="POST" class="form-horizontal cadre">
                
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="titre">Titre :</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-inline" id="titre" name="titre" value="<?php echo $_SESSION['titre']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="realisateur">Réalisateur :</label>
                  <div class="col-sm-10"> 
                    <input type="text" class="form-inline" id="realisateur" name="realisateur" value="<?php echo $_SESSION['realisateur']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="scenariste">Scénariste :</label>
                  <div class="col-sm-10"> 
                    <input type="text" class="form-inline" id="scenariste" name="scenariste" value="<?php echo $_SESSION['scenariste']; ?>">
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 evidence" for="producteur">Production :</label>
                    <div class="col-sm-10"> 
                      <input type="text" class="form-inline" id="producteur" name="producteur" value="<?php echo $_SESSION['producteur']; ?>">
                    </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="date_sortie">Date de sortie :</label>
                  <div class="col-sm-10">
                      <input type="date" class="form-control" id="date_sortie" name="date_sortie" value="<?php echo $_SESSION['date_sortie']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="quantite">Nombre de DVD disponibles :</label>
                  <div class="col-sm-10"> 
                      <input type="number" class="form-control" id="quantite" name="quantite" value="<?php echo $_SESSION['quantite']; ?>">
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 evidence" for="image_dvd">Image associé :</label>
                    <div class="col-sm-10"> 
                        <input type="text" class="form-control" id="image_dvd" name="image_dvd" value="<?php echo $_SESSION['lien_image']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 evidence" for="description">Description :</label>
                    <div class="col-sm-10"> 
                        <input type="text" class="form-control" id="description" name="description" placeholder="Votre éventuelle description">
                    </div>
                </div>
                <div class="form-group"> 
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" value="Modifier" name="Modifier">Confirmer modification</button>
                    <button type="reset" class="btn btn-danger">Annuler</button>
                  </div>
                    <!--<br>
                    <br>
                    <img class="img-responsive center-block" src="images/giphy.gif" alt="gif1"/> -->
                </div>
                
            </form>
        <?php
        }
        ?>
            
        </div>         
    </div>
</div>
<?php
}
else
{
    echo '<p class="deeppink centre">URL non accessible</p>';
}
?>