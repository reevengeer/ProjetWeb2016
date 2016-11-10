<?php
    session_start();
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
<?php 
    if(isset($_POST['Envoyer']))
    {
        ?>
        <p class="evidence grand">
            <?php
                print 'Le DVD ';
                print_r($_POST['titre']);
                print ' réalisé par ';
                print_r($_POST['realisateur']);
                print ' a bien été rajouté à la base de données.';
            ?>
        </p>
        <?php
    }
?>
<h1 class="aqua legerement_a_droite">Modification d'un DVD</h1>
<div class='legerement_a_droite'>
    <h2 class='evidence'>Veuillez entrer les informations du DVD à modifier.</h2>
    <div class="container largeur">
        <div class="table table-bordered">
            
            <form action="index.php?page=modifierDVD.php" method="POST" class="form-horizontal cadre">
                
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="titre">Titre :</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-inline" id="titre" name="titre" placeholder="Son titre">
                  </div>
                </div>
                
                <div class="form-group"> 
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" value="Envoyer" name="Envoyer">Envoyer</button>
                    <button type="reset" class="btn btn-danger">Annuler</button>
                  </div>
                </div>
                
            </form>
            
        </div>
        <div class="table table-bordered">
            
            <form action="index.php?page=modifierDVD.php" method="POST" class="form-horizontal cadre">
                
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="titre">Titre :</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-inline" id="titre" name="titre" placeholder="Son titre">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="realisateur">Réalisateur :</label>
                  <div class="col-sm-10"> 
                    <input type="text" class="form-inline" id="realisateur" name="realisateur" placeholder="Son réalisateur">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="scenariste">Scénariste :</label>
                  <div class="col-sm-10"> 
                    <input type="text" class="form-inline" id="scenariste" name="scenariste" placeholder="Son scénariste">
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 evidence" for="producteur">Producteur :</label>
                    <div class="col-sm-10"> 
                      <input type="text" class="form-inline" id="producteur" name="producteur" placeholder="Son producteur">
                    </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="dateSortie">Date de sortie :</label>
                  <div class="col-sm-10">
                      <input type="date" class="form-control" id="dateSortie" name="dateSortie" placeholder="Sa date de sortie">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="nbre">Nombre de DVD disponibles :</label>
                  <div class="col-sm-10"> 
                      <input type="number" class="form-control" id="nbre" name="nbre" placeholder="Entrez la quantité de DVD disponibles">
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 evidence" for="image">Image associé :</label>
                    <div class="col-sm-10"> 
                        <input type="text" class="form-control" id="image" name="image" placeholder="nom de l'image avec son extension se trouvant dans le dossier images">
                    </div>
                </div>
                <div class="form-group"> 
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" value="Envoyer" name="Envoyer">Envoyer</button>
                    <button type="reset" class="btn btn-danger">Annuler</button>
                  </div>
                </div>
                
            </form>
            
        </div>
        
        <?php 
            $flag=0;
            if(isset($_POST['Envoyer']))
            {
		if($_POST['titre']!="" && $_POST['realisateur']!=""&& $_POST['scenariste']!=""&& $_POST['producteur']!=""
                        && $_POST['dateSortie']!=""&& $_POST['nbre']!=""&& $_POST['image']!="")
		{
                    if($_POST['nbre']>=1)
                    {
                        //print 'ok';
                        
			$flag=1;
			$query="select insert_dvd(:id_administrateur,:titre,:realisateur,:scenariste,:producteur,:date_sortie,:quantite,:image_dvd)";
                        $resultset = $cnx->prepare($query);

                        $resultset -> bindValue(1,$_SESSION['id_administrateur']);
                        $resultset -> bindValue(2,$_POST['titre']); 
                        $resultset -> bindValue(3,$_POST['realisateur']); 
                        $resultset -> bindValue(4,$_POST['scenariste']);
                        $resultset -> bindValue(5,$_POST['producteur']);
                        $resultset -> bindValue(6,$_POST['dateSortie']); 
                        $resultset -> bindValue(7,$_POST['nbre']);
                        $resultset -> bindValue(8,$_POST['image']);

                        $resultset->execute();

                        $retour = $resultset->fetchColumn(0);

                        if($retour=='Le DVD a été ajouté')
                        {
                            ?>
                            <p class="evidence grand">
                                <?php
                                    print 'Le DVD ';
                                    print_r($_POST['titre']);
                                    print ' réalisé par ';
                                    print_r($_POST['realisateur']);
                                    print ' a bien été rajouté à la base de données.';
                                ?>
                            </p>
                            <?php
                        }
                        else if ($retour!='Le DVD a été ajouté')
                        {
                            ?>
                            <p>Un problème est intervenue.</p>
                            <p>Le informations entrées doivent correspondre à celle d'un autre DVD.</p>
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