<?php
    if(isset($_SESSION['connexion']))
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
<div class='legerement_a_droite'>
    <h1 class="aqua souligner">Suppression d'un DVD</h1>
    <?php 
        if(isset($_POST['DVD_choisi']))
        {
            ?><br/><?php
            $DvdChoisi = $_POST['film']; // correspond à l'id du dvd choisi
            $query="select * from dvd where id_dvd=".$DvdChoisi;

                        $resultset = $cnx->prepare($query);

                        $resultset->execute();
                        $data = $resultset->fetchAll();

                        $nbr= count($data);

                        for($i = 0;$i < $nbr ;$i++)
                        {
                            $_SESSION['id_dvd'] = $data[$i]['id_dvd'];
                            $_SESSION['titre'] = $data[$i]['titre'];
                            $_SESSION['realisateur'] = $data[$i]['realisateur'];
                        }
                        
                        $query="select delete_dvd(:id_dvd)";
                        $resultset = $cnx->prepare($query);

                        $resultset -> bindValue(1,$_SESSION['id_dvd']);

                        $resultset->execute();

                        $retour = $resultset->fetchColumn(0);

                        if($retour=='DVD supprimé')
                        {
                            ?>
                            <p class="deeppink grand">
                                <?php
                                    print 'Le film ';
                                    print_r($_SESSION['titre']);
                                    print ' a bien été supprimé de la base de données.';
                                ?>
                            </p><br/>
                            <?php
                        }
                        else if ($retour!='DVD supprimé')
                        {
                            ?>
                            <p class="deeppink grand">Un problème est intervenue.</p>
                            <p class="deeppink">Le DVD en question est actuellement en location.</p>
                            <br/>
                            <?php
                        }
        }
        ?>
    <h2 class='evidence'>Veuillez choisir le DVD à supprimer de la bse de données</h2>
    <div class="container largeur">
        <div class="table table-bordered">  
            
                <form action="index.php?page=administrateur/supprimerDVD.php" method="POST" class="form-horizontal cadre">
                    <div class="form-group">
                    <label class="control-label col-sm-3 evidence" for="titre">DVD à supprimer :</label>
                    <div class="col-sm-9">
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
                                echo "<option value=".$tab[$i]['id_dvd'].">"."Titre : ".$tab[$i]['titre']." || Scénariste : ".$tab[$i]['scenariste']."</option>";
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
                    <button type="submit" class="btn btn-primary" value="DVD_choisi" name="DVD_choisi">Supprimer ce DVD</button>
                    <button type="reset" class="btn btn-danger">Annuler</button>
                  </div>
                </div>
                </form>
            <img class="img-responsive center-block" src="images/giphy2.gif" alt="gif1"/>
            <br/>
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