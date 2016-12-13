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

<h1 class="aqua legerement_a_droite souligner">Ajout d'un DVD</h1>
<div class="legerement_a_droite">
    
<?php 

    if(isset($_POST['Envoyer']))
    {
        $target_dir = "C:\wamp\www\GitHub\ProjetWeb2016\images/";
        $target_file = $target_dir . basename($_FILES["image_dvd"]["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $flag=0;
        if (file_exists($target_file))
        {
            echo '<p class="deeppink centre grand">Attention : ce fichier existe déjà dans le dossier images</p>';
        }
        else 
        {
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
            {
                echo '<p class="deeppink centre grand">Seul les fichers JPG, JPEG, PNG & GIF sont autorisés.</p>';
            }
            else 
            {
                if (move_uploaded_file($_FILES["image_dvd"]["tmp_name"], $target_file))
                {
                    if(isset($_POST['Envoyer']))
                    {
                        ?><br/><?php
                        if($_POST['titre']!="" && $_POST['realisateur']!=""&& $_POST['scenariste']!=""&& $_POST['producteur']!=""
                                && $_POST['date_sortie']!=""&& $_POST['quantite']!="")
                        {
                            if($_POST['quantite']>=1)
                            {
                                if(preg_match("#[A-Z -][A-Za-z -]+#",$_POST['realisateur']) == true )
                                {
                                    if(preg_match("#[A-Z -][A-Za-z -]+#",$_POST['scenariste']) == true )
                                    {
                                            $log = new dvdBD($cnx);
                                            $retour=$log->ajoutDVD($_SESSION['id_administrateur'],$_POST['titre'],$_POST['realisateur'],$_POST['scenariste'],$_POST['producteur'],$_POST['date_sortie'],$_POST['quantite'],$_FILES["image_dvd"]["tmp_name"],$_POST['description']);

                                            if($retour=='Le DVD a été ajouté')
                                            {
                                                ?>
                                                <p class="deeppink grand">
                                                    <?php
                                                        print 'Le DVD ';
                                                        print_r($_POST['titre']);
                                                        print ' réalisé par ';
                                                        print_r($_POST['realisateur']);
                                                        print ' a bien été rajouté à la base de données.<br/>';
                                                        echo "Le fichier ". basename( $_FILES["image_dvd"]["name"]). " a bien été uploadé.";

                                                    ?>
                                                </p>
                                                <?php
                                            }
                                            else if ($retour!='Le DVD a été ajouté')
                                            {
                                                ?>
                                                <p class="deeppink">Un problème est intervenue.</p>
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
                                                                            }
                                }
                                else
                                {
                                    echo '<p class="deeppink centre grand">Le réalisateur et le scénariste doivent être composé uniquement de lettres</p>';
                                    echo '<p class="deeppink centre grand">Ils doivent également commencer par une majuscule</p>';
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
                }
                else
                {
                    echo '<p class="deeppink centre">Une erreur lors de l upload est intervenue</p>';
                }
            }
        }
    }
?>
</div>
<div class='legerement_a_droite'>
    <h2 class='evidence'>Veuillez entrer les informations du nouveaux DVD.</h2>
    <h3 class='deeppink'>Les caractères spéciaux sont à éviter.</h3>
    <div class="container largeur">
        <div class="table table-bordered">
            
            <form action="index.php?page=administrateur/ajoutDVD.php" method="POST" class="form-horizontal cadre" enctype="multipart/form-data">
                
                <div class="form-group">
                  <label class="control-label col-sm-3 evidence" for="titre">Titre :</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-inline" id="titre" name="titre" placeholder="Son titre">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3 evidence" for="realisateur">Réalisateur :</label>
                  <div class="col-sm-9"> 
                    <input type="text" class="form-inline" id="realisateur" name="realisateur" placeholder="Son réalisateur">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3 evidence" for="scenariste">Scénariste :</label>
                  <div class="col-sm-9"> 
                    <input type="text" class="form-inline" id="scenariste" name="scenariste" placeholder="Son scénariste">
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3 evidence" for="producteur">Production :</label>
                    <div class="col-sm-9"> 
                      <input type="text" class="form-inline" id="producteur" name="producteur" placeholder="Sa production">
                    </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3 evidence" for="date_sortie">Date de sortie :</label>
                  <div class="col-sm-9">
                      <input type="date" class="form-control" id="date_sortie" name="date_sortie" placeholder="Sa date de sortie">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3 evidence" for="quantite">Nombre de DVD disponibles :</label>
                  <div class="col-sm-9"> 
                      <input type="number" class="form-control" id="quantite" name="quantite" placeholder="Entrez la quantité de DVD disponibles">
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3 evidence" for="image_dvd">Image associé :</label>
                    <div class="col-sm-9"> 
                        <input type="file" class="form-control" id="image_dvd" name="image_dvd" placeholder="Exemple : image2.jpg">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3 evidence" for="description">Description:</label>
                    <div class="col-sm-9"> 
                        <input type="text" class="form-control" id="description" name="description" placeholder="Votre éventuelle description">
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
        <br/>
        <div id="imageAjoutDVD">
            <h3 class="evidence souligner centre">Affichage des DVD actuellement encodées dans la base de données</h3>
            <h4 class="deeppink souligner centre">Veillez à ce que l'image du film soit présente dans le dossier images avant d'enregistrer ce film</h4>

            <?php            
                        $query="select * from dvd";

                        $result=pg_query($cn,$query);
			$nbr=pg_num_rows($result);

                        //$nbr= count($data);

                        if($nbr>0)
                        {
                            $tab=array();
                            for($i=0;$i<$nbr;$i++)
                            {
                                    $tab[$i]=pg_fetch_array($result,$i);
                            }
                            for($i = 0;$i < $nbr ;$i++)
                            { ?>
                                <!-- impossible de rendre les images responsives sans qu'elles se mettent les unes en dessous des autres -->
                                <img class="img-rounded imagelocation" id="imageAjoutDVD" src="images/<?php  echo $tab[$i]['image_dvd']; ?>" 
                                     title="Titre : <?php echo utf8_encode($tab[$i]['titre']);?> || Quantité : <?php echo utf8_encode($tab[$i]['quantite']);?> || Description : <?php echo utf8_encode($tab[$i]['description']);?>"/>
                                
                            <?php
                            }
                        }
                        else
                        {
                            echo '<p class="deeppink">plus de films disponibles</p>';
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