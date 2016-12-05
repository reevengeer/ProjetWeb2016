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
            $flag=0;
            if(isset($_POST['Envoyer']))
            {
                ?><br/><?php
		if($_POST['titre']!="" && $_POST['realisateur']!=""&& $_POST['scenariste']!=""&& $_POST['producteur']!=""
                        && $_POST['date_sortie']!=""&& $_POST['quantite']!=""&& $_POST['image_dvd']!="")
		{
                    if($_POST['quantite']>=1)
                    {
                        $log = new dvdBD($cnx);
                        $retour=$log->ajoutDVD($_SESSION['id_administrateur'],$_POST['titre'],$_POST['realisateur'],$_POST['scenariste'],$_POST['producteur'],$_POST['date_sortie'],$_POST['quantite'],$_POST['image_dvd'],$_POST['description']);

                        if($retour=='Le DVD a été ajouté')
                        {
                            ?>
                            <p class="deeppink grand">
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
                            <p class="deeppink">Un problème est intervenue.</p>
                            <p class="deeppink">1.Les caractères spéciaux sont mal gérés par la base données.</p>
                            <p class="deeppink">2.La contrainte d'unicité sur le couple titre/realisateur a été violé.</p>
                            <?php
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
</div>
<div class='legerement_a_droite'>
    <h2 class='evidence'>Veuillez entrer les informations du nouveaux DVD.</h2>
    <h3 class='deeppink'>Les caractères spéciaux sont à éviter.</h3>
    <div class="container largeur">
        <div class="table table-bordered">
            
            <form action="index.php?page=administrateur/ajoutDVD.php" method="POST" class="form-horizontal cadre">
                
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
                    <label class="control-label col-sm-2 evidence" for="producteur">Production :</label>
                    <div class="col-sm-10"> 
                      <input type="text" class="form-inline" id="producteur" name="producteur" placeholder="Sa production">
                    </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="date_sortie">Date de sortie :</label>
                  <div class="col-sm-10">
                      <input type="date" class="form-control" id="date_sortie" name="date_sortie" placeholder="Sa date de sortie">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="quantite">Nombre de DVD disponibles :</label>
                  <div class="col-sm-10"> 
                      <input type="number" class="form-control" id="quantite" name="quantite" placeholder="Entrez la quantité de DVD disponibles">
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 evidence" for="image_dvd">Image associé :</label>
                    <div class="col-sm-10"> 
                        <input type="text" class="form-control" id="image_dvd" name="image_dvd" placeholder="nom de l'image avec son extension préalablement enregistrés dans le dossier images">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 evidence" for="description">Description:</label>
                    <div class="col-sm-10"> 
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
                                <img class="img-rounded imagelocation" src="images/<?php  echo $tab[$i]['image_dvd']; ?>" 
                                     title="Quantité : <?php echo utf8_encode($tab[$i]['quantite']);?>. Description : <?php echo utf8_encode($tab[$i]['description']);?>"/>
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
<?php
}
else
{
    echo '<p class="deeppink centre">URL non accessible</p>';
}
?>