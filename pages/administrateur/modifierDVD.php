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
<h1 class="aqua legerement_a_droite">Modification d'un DVD</h1>
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
                        $query="select * from dvd";

                        $resultset = $cnx->prepare($query);

                        $resultset->execute();
                        $data = $resultset->fetchAll();

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
            $query="select * from dvd where id_dvd=".$DvdChoisi;

                        $resultset = $cnx->prepare($query);

                        $resultset->execute();
                        $data = $resultset->fetchAll();

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
                  <label class="control-label col-sm-2 evidence" for="dateSortie">Date de sortie :</label>
                  <div class="col-sm-10">
                      <input type="date" class="form-control" id="dateSortie" name="dateSortie" value="<?php echo $_SESSION['date_sortie']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="nbre">Nombre de DVD disponibles :</label>
                  <div class="col-sm-10"> 
                      <input type="number" class="form-control" id="nbre" name="nbre" value="<?php echo $_SESSION['quantite']; ?>">
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 evidence" for="image">Image associé :</label>
                    <div class="col-sm-10"> 
                        <input type="text" class="form-control" id="image" name="image" value="<?php echo $_SESSION['lien_image']; ?>">
                    </div>
                </div>
                <div class="form-group"> 
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" value="Modifier" name="Modifier">Confirmer modification</button>
                    <button type="reset" class="btn btn-danger">Annuler</button>
                  </div>
                    <br>
                    <br>
                    <img class="img-responsive center-block" src="images/giphy.gif" alt="gif1"/>
                </div>
                
            </form>
        <?php
        }
        ?>
            
        </div>
        <?php 
            $flag=0;
            if(isset($_POST['Modifier']))
            {
		if($_POST['titre']!="" && $_POST['realisateur']!=""&& $_POST['scenariste']!=""&& $_POST['producteur']!=""
                        && $_POST['dateSortie']!=""&& $_POST['nbre']!=""&& $_POST['image']!="")
		{
                    if($_POST['nbre']>=1)
                    {
                        //print 'ok';
                        
			$flag=1;
			$query="select update_dvd(:id_administrateur,:titre,:realisateur,:scenariste,:producteur,:date_sortie,:quantite,:image_dvd)";
                        $resultset = $cnx->prepare($query);

                        $resultset -> bindValue(1,$_SESSION['id_dvd']);
                        $resultset -> bindValue(2,$_POST['titre']); 
                        $resultset -> bindValue(3,$_POST['realisateur']); 
                        $resultset -> bindValue(4,$_POST['scenariste']);
                        $resultset -> bindValue(5,$_POST['producteur']);
                        $resultset -> bindValue(6,$_POST['dateSortie']); 
                        $resultset -> bindValue(7,$_POST['nbre']);
                        $resultset -> bindValue(8,$_POST['image']);

                        $resultset->execute();

                        $retour = $resultset->fetchColumn(0);

                        if($retour=='DVD mis à jour')
                        {
                            ?>
                            <p class="evidence grand">
                                <?php
                                    print 'Le film ';
                                    print_r($_POST['titre']);
                                    print ' réalisé par ';
                                    print_r($_POST['realisateur']);
                                    print ' a bien été mis à jour dans la base de données.';
                                ?>
                            </p>
                            <?php
                        }
                        else if ($retour!='DVD mis à jour')
                        {
                            ?>
                            <p class="evidence grand">Un problème est intervenue.</p>
                            <?php
                        }
                    }
                    else
                    {
                        ?>
                            <p class="evidence grand">La quantité doit être supérieure ou égale à 1.</p>
                        <?php
                    }
                }
		else
		{
               	    ?>
                        <p class="evidence grand">Vous devez tout compléter.</p>
                     <?php
		}	
            }
        ?>
                        
    </div>
</div>