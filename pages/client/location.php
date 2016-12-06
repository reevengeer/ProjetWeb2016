<?php
    if(isset($_SESSION['connexionClient']))
    {
?>
<nav class="menu">
		<?php
                    if (file_exists('./lib/php/menuClient.php'))
                    {
			include './lib/php/menuClient.php';
       		    }
               	    else
		    {
                        //tester l'existence du fichier pour que la page s'affiche même si le fichier manque (file_exists)
			echo "Il semblerait que nous ayions des problemes technique, veuillez nous en excuser .. ";
		    }
		?>
</nav>
<h1 class="aqua legerement_a_droite souligner">Location d'un DVD</h1>
<div class='legerement_a_droite'>
    <?php 
            $flag=0;
            if(isset($_POST['Envoyer']))
            {              
                ?><br/><?php
                    if(isset($_POST['choix']))
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
                            $_SESSION['image_dvd'] = $data[$i]['image_dvd'];
                            $_SESSION['description'] = $data[$i]['description'];
                        }
                        if($_SESSION['quantite']>0)
                        {
                            $datetime = date("Y-m-d");
                            
                            $log = new historiqueBD($cnx);
                            $retour=$log->enregistrementLocation($_SESSION['id_client'],$_SESSION['id_dvd'],$_SESSION['nom'],$_SESSION['titre'],$datetime,$_POST['choix']);
                            
                            if($retour=='Historique complété')
                            {                     
                                
                                // incrémentation de la réduction jusqu'à une réduction de maximum 15%
                                $log3 = new clientBD($cnx);
                                $data3=$log3->rechercheClientSurSonID($_SESSION['id_client']);

                                $nbr3= count($data3);

                                for($i = 0;$i < $nbr3 ;$i++)
                                {
                                    $_SESSION['reduction'] = $data3[$i]['reduction'];
                                }
                                
                                if($_SESSION['reduction']<15)
                                {
                                    $log3->updateReduction($_SESSION['id_client']);
                                    $data3=$log3->rechercheClientSurSonID($_SESSION['id_client']);
                                    
                                    $nbr3= count($data3);

                                    for($i = 0;$i < $nbr3 ;$i++)
                                    {
                                        $_SESSION['reduction'] = $data3[$i]['reduction'];
                                    }
                                }
                                else
                                {
                                    $reductionAccordee = $_SESSION['reduction'];
                                }
                                ///////////////////////////////////////////////
                                
                                $_SESSION['quantite'] = $_SESSION['quantite']-1;
                                
                                $log = new dvdBD($cnx);
                                $retour2=$log->updateDVD($_SESSION['id_dvd'],$_SESSION['titre'],$_SESSION['realisateur'],$_SESSION['scenariste'],$_SESSION['producteur'],$_SESSION['date_sortie'],$_SESSION['quantite'],$_SESSION['image_dvd'],$_SESSION['description']);

                                        if($retour2=='DVD mis à jour')
                                        {
                                            ?>
                                            <p class="deeppink grand">
                                                <?php
                                                    print 'Location effectuée';
                                                    // une redirection vers un site tel que paypal peut être ensuite effectué
                                                    // en donnant simplement le montant que devrait payer le client en fonction
                                                    // de la durée de la location
                                                ?>
                                            </p>
                                            <?php
                                        }
                                        else if ($retour2!='DVD mis à jour')
                                        {
                                            ?>
                                            <p class="deeppink grand">Un problème est intervenue lors de location.</p>
                                            <?php
                                        }
                                    ?>
                                </p>
                                <?php
                            }
                            else if ($retour!='Historique complété')
                            {
                                ?>
                                <p class="deeppink grand">Un problème est intervenu.</p>
                                <p class="deeppink grand">Vous louez en déjà en ce moment même ce DVD.</p>
                                <?php
                            }
                        }
                        else
                        {
                            echo '<p class="deeppink centre grand">Désolé le stock de ce DVD est épuisé</p>';
                        }
                    }
                    else
                    {
                        
                            echo '<p class="evidence grand">Vous devez cocher la durée de la location.</p>';
                         
                    }
            }
        ?>
    <h2 class='evidence'>Veuillez choisir votre DVD</h2>
    <div class="container largeur">
         
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
                                <img class="img-rounded imagelocation" src="images/<?php  echo $tab[$i]['image_dvd']; ?>" title="Titre : <?php echo utf8_encode($tab[$i]['titre']);?> || Description : <?php echo utf8_encode($tab[$i]['description']);?>"/>
                            <?php
                            }
                        }
                        else
                        {
                            echo '<p class="deeppink">plus de films disponibles</p>';
                        }
                    ?>

        <br/><br/>
        <div class="table table-bordered"> 
            <br/>
                <div class="legerement_a_droite">
                    <form action="index.php?page=client/location.php" method="POST">
                        <table class="deeppink">	
                            <tr>
                                <td>
                                    <label>Votre choix de film parmis ceux </label>
                                    <label class="souligner" >en stock</label>
                                </td>
                                <td>
                                    <?php            
                                        $log = new dvdBD($cnx);
                                        $data=$log->DVDAvecQuantiteSuperieurAZero();

                                        $nbr= count($data);

                                        if($nbr>0)
                                        {
                                            $tab = array();
                                            echo '<select name=film style="width:450px">';
                                            for($i = 0;$i < $nbr ;$i++)
                                            {
                                                $tab[$i] = $data[$i];
                                                echo "<option value=".$tab[$i]['id_dvd'].">".$i.". Titre : ".$tab[$i]['titre']."</option>";
                                            }
                                            echo "</select>";
                                        }
                                        else
                                        {
                                            echo '<p class="deeppink">plus de films disponibles</p>';
                                        }
                                    ?>
                                </td>
                            </tr>
                                    <tr>
                                        <td>
                                            <label></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="evidence souligner">Nombre de jours que vous souhaitez louer ce DVD </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label></label>
                                        </td>
                                    </tr>
                                    <tr>
                                            <td><label for="1e">Entre 1 && 2 jours</label></td>
                                            <td><input type="radio" name="choix" value="1 à 2 jours" /><br></td>
                                    </tr>
                                    <tr>
                                            <td><label for="2e">Entre 3 && 5 jours</label></td>
                                            <td><input type="radio" name="choix" value="3 à 5 jours" /><br></td>
                                    </tr>
                                    <tr>
                                            <td><label for="3e">1 semaine</label></td>
                                            <td><input type="radio" name="choix" value="1 semaine" /></br></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><button type="submit" class="btn btn-primary" value="Envoyer" name="Envoyer">Envoyer</button></td>
                                        <td><button type="reset" class="btn btn-danger">Annuler</button></td>
                                    </tr>
                        </table>
                    </form>
                </div>
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