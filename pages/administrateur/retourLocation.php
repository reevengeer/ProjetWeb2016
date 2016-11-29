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

<?php
    $datetime = date("Y-m-d");
?>

<div class="well">
     <?php 
            $flag=0;
            if(isset($_POST['Confirmer']))
            {
		if(isset($_POST['choix']))
		{
                        $DvdChoisi = $_POST['film']; // correspond à l'id du dvd choisi
                        $query3="select * from historique where id_dvd=".$_POST['film']." and id_client=".$_POST['client'];

                        $resultset3 = $cnx->prepare($query3);

                        $resultset3->execute();
                        $data = $resultset3->fetchAll();

                        $nbr= count($data);

                        for($i = 0;$i < $nbr ;$i++)
                        {
                            //print "<br>".$data[$i]['titre'];
                            $_SESSION['duree'] = $data[$i]['duree'];
                        }

                        //-----------------------------------------------------
                        
			$query="select delete_historique(:id_client,:id_dvd)";
                        $resultset = $cnx->prepare($query);

                        $resultset -> bindValue(1,$_POST['client']);
                        $resultset -> bindValue(2,$_POST['film']); 
                        
                        $resultset->execute();

                        $retour = $resultset->fetchColumn(0);
                        
                        //------------------------------------------------------
                        
                        $query2="select * from dvd where id_dvd=".$DvdChoisi;

                        $resultset2 = $cnx->prepare($query2);

                        $resultset2->execute();
                        $data = $resultset2->fetchAll();

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
                            $_SESSION['description'] = $data[$i]['description'];
                        }

                        if($retour=='Ligne supprimé')
                        {
                            $newQuantite = $_SESSION['quantite']+1;
                                        
                            $query2="select update_dvd(:id_dvd,:titre,:realisateur,:scenariste,:producteur,:date_sortie,:quantite,:image_dvd,:description)";
                                        
                            $resultset2 = $cnx->prepare($query2);

                            $resultset2 -> bindValue(1,$_SESSION['id_dvd']);
                            $resultset2 -> bindValue(2,$_SESSION['titre']); 
                            $resultset2 -> bindValue(3,$_SESSION['realisateur']); 
                            $resultset2 -> bindValue(4,$_SESSION['scenariste']);
                            $resultset2 -> bindValue(5,$_SESSION['producteur']);
                            $resultset2 -> bindValue(6,$_SESSION['date_sortie']); 
                            $resultset2 -> bindValue(7,$newQuantite);
                            $resultset2 -> bindValue(8,$_SESSION['lien_image']);
                            $resultset2 -> bindValue(9,$_SESSION['description']);
                                        
                            $resultset2->execute();

                            $retour2 = $resultset2->fetchColumn(0);

                            if($retour2=='DVD mis à jour')
                            {
                            ?>
                                <p class="deeppink grand souligner">
                            <?php
                                 print 'Base de données mise à jour';
                                 $montant = 0;
                                 
                                 // je calcule le montant totale que le client devra payer mais le paiement en lui
                                 // même se faira sur un autre site plus sécurisé tel que paypal ou autre
                                 // qui peuvent gérer les paiements des sites en ligne                             
                               
                                 if($_POST['choix']=='Oui')
                                 {
                                    if($_SESSION['duree']=='1 à 2 jours                     ')
                                    {
                                       $montant= 8+2; // 8 euros de base lors d'une pénalité sans la durée
                                       $message="Le client vous doit : ".$montant." euros.";
                                       echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                                    }
                                    else if($_SESSION['duree']=='3 à 5 jours                     ')
                                    {
                                       $montant= 8+3;
                                       $message="Le client vous doit : ".$montant." euros.";
                                       echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                                    }
                                    else if($_SESSION['duree']=='1 semaine                       ')
                                    {
                                       $montant= 8+4;
                                       $message="Le client vous doit : ".$montant." euros.";
                                       echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                                    }
                                    else
                                    {
                                        print 'erreur lecture montant';
                                    }
                                 }
                                 else if($_POST['choix']=='Non')
                                 {
                                    if($_SESSION['duree']=='1 à 2 jours                     ')
                                    {
                                       $montant= 3+2; // 3 euros de base lors sans pénalité et sans la durée
                                       $message="Le client vous doit : ".$montant." euros.";
                                       echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                                    }
                                    else if($_SESSION['duree']=='3 à 5 jours                     ')
                                    {
                                       $montant= 3+3;
                                       $message="Le client vous doit : ".$montant." euros.";
                                       echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                                    }
                                    else if($_SESSION['duree']=='1 semaine                       ')
                                    {
                                       $montant= 3+4;
                                       $message="Le client vous doit : ".$montant." euros.";
                                       echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                                    }
                                    else
                                    {
                                        print 'erreur lecture montant';
                                    }
                                 }
                                 else
                                 {
                                     print 'erreur lecture choix';
                                 }
                            ?>
                            </p>
                            <?php
                        }
                        else if ($retour!='Ligne supprimé')
                        {
                            ?>
                            <p class="evidence grand">Un problème est intervenue.</p>
                            <?php
                        }
                                       
                }
		else
		{
               	    ?>
                        <p class="evidence grand">Vous devez préciser  pour un éventuel retard.</p>
                     <?php
		}
            }
        }
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-5 col-md-5 col-lg-5">
                <div>
                    <h2>Bienvenue 
                        <span class="souligner">
                            <?php
                                print_r($_SESSION['prenom']);
                                print " ";
                                print_r($_SESSION['nom']);
                            ?>
                        </span>
                    </h2>  
                    <h3 class="souligner">Retour d'un DVD</h3>
                    <br/>
                        <div class="legerement_a_droite">
                        <form action="index.php?page=administrateur/retourLocation.php" method="POST">
                            <table>	
                                <tr>
                                    <td>
                                        <label>Location a retiré : </label>
                                    </td>
                                    <td class="legerement_a_droite">
                                        <?php            
                                            $query="select * from historique";

                                            $resultset = $cnx->prepare($query);

                                            $resultset->execute();
                                            $data = $resultset->fetchAll();

                                            $nbr= count($data);

                                            if($nbr>0)
                                            {
                                                $tab = array();
                                                echo '<select name=film style="width:200px">';
                                                for($i = 0;$i < $nbr ;$i++)
                                                {
                                                    $tab[$i] = $data[$i];
                                                    echo "<option value=".$tab[$i]['id_dvd'].">".$tab[$i]['titre_film']."</option>";
                                                }
                                                echo "</select>";
                                            }
                                            else
                                            {
                                                echo '<p class="deeppink">Pas de DVD actuellement en location</p>';
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Client louant ce film : </label>
                                    </td>
                                    <td class="legerement_a_droite">
                                        <?php            
                                            $query="select * from historique,client where client.id_client=historique.id_client";
                                            // distinct ne fonctionne pas en postgreSQL
                                            $resultset = $cnx->prepare($query);

                                            $resultset->execute();
                                            $data = $resultset->fetchAll();

                                            $nbr= count($data);

                                            if($nbr>0)
                                            {
                                                $tab = array();
                                                echo '<select name=client style="width:200px">';
                                                for($i = 0;$i < $nbr ;$i++)
                                                {
                                                    $tab[$i] = $data[$i];
                                                    echo "<option value=".$tab[$i]['id_client'].">".$tab[$i]['nom']."</option>";
                                                }
                                                echo "</select>";
                                            }
                                            else
                                            {
                                                echo '<p class="deeppink">Aucune personne loue de DVD actuellement</p>';
                                            }
                                        ?>
                                    </td>
                                </tr>
                                </table>
                                <table>
                                        <tr>
                                            <td>
                                                <label></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="evidence">Retard éventuel (obligatoire):</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label></label>
                                            </td>
                                        </tr>
                                        <tr>
                                                <td><label for="Oui">Oui</label></td>
                                                <td><input type="radio" name="choix" value="Oui" /><br></td>
                                        </tr>
                                        <tr>
                                                <td><label for="Non">Non</label></td>
                                                <td><input type="radio" name="choix" value="Non" /><br></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><button type="submit" class="btn btn-success" value="Confirmer" name="Confirmer">Confirmer</button></td>
                                        </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>  
            <div class="col-sm-7 col-md-7 col-lg-7">
                <h2 class="centre souligner">DVD actuellement en location</h2>
                <br/>
                <table class="noir centre">
                    <tr>
                        <td class="tdHistorrique450Bis souligner">Titre du film</td>
                        <td class="tdHistorriqueBis souligner">Nom du Client</td>
                        <td class="tdHistorriqueBis souligner">Date de location</td>
                        <td class="tdHistorriqueBis souligner">Durée de la location</td>
                        <td class="tdHistorrique200Bis souligner">Date maximum de retour</td>
                    </tr>
                     <?php            
                            $query="select * from historique";

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
                                    <tr>
                                        <td class="tdHistorrique450Bis"><?php  echo $tab[$i]['titre_film']; ?></td>
                                        <td class="tdHistorriqueBis"><?php  echo $tab[$i]['nom_client']; ?></td>
                                        <td class="tdHistorriqueBis"><?php  echo $tab[$i]['date_location']; ?></td>
                                        <td class="tdHistorriqueBis"><?php  echo $tab[$i]['duree']; ?></td>
                                        <td class="tdHistorrique200Bis">
                                            <?php

                                            if($tab[$i]['duree']=='1 à 2 jours                     ')
                                            {
                                                $date = date("Y-m-d", strtotime($tab[$i]['date_location']." +2 days"));
                                                echo $date;
                                                if($datetime>$date)
                                                {
                                                    echo '<span class="deeppink"> (en retard)</span>';
                                                    $flag=1; // permet d'afficher la sanction à l'utilisateur si il est dans le cas
                                                }
                                            }
                                            if($tab[$i]['duree']=='3 à 5 jours                     ')
                                            {
                                                $date = date("Y-m-d", strtotime($tab[$i]['date_location']." +5 days"));
                                                echo $date;
                                                if($datetime>$date)
                                                {
                                                    echo '<span class="deeppink"> (en retard)</span>';
                                                    $flag=1;
                                                }
                                            }
                                            if($tab[$i]['duree']=='1 semaine                       ')
                                            {
                                                $date = date("Y-m-d", strtotime($tab[$i]['date_location']." +7 days"));
                                                echo $date;
                                                if($datetime>$date)
                                                {
                                                    echo '<span class="deeppink"> (en retard)</span>';
                                                    $flag=1;
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                            }
                            else
                            {
                                echo '<p class="deeppink">plus de films disponibles</p>';
                            }
                        ?>
                </table>
            </div>   
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