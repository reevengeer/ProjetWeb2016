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
                        $log = new historiqueBD($cnx);
                        $data1=$log->historiqueDVDClient($_POST['film'],$_POST['client']);

                        $nbr= count($data1);
                        $flag=0;
                        for($i = 0;$i < $nbr ;$i++)
                        {
                            //print "<br>".$data[$i]['titre'];
                            $_SESSION['duree'] = $data1[$i]['duree'];
                            // pour recuperer la duree du film choisit
                            $flag=1;
                        }
                        if($flag==0)
                        {
                            echo '<p class="deeppink centre grand">La combinaison client/DVD ne correspond pas</p>';
                        }
                        else
                        {

                        //-----------------------------------------------------
                        
                        $retour=$log->deleteHistorique($_POST['client'],$_POST['film']);
                        
                        //------------------------------------------------------
                        
                        $log2 = new dvdBD($cnx);
                        $data=$log2->informationsDVDDEpuisSonID($_POST['film']);

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

                        if($retour=='Ligne supprimé')
                        {
                            $_SESSION['quantite'] = $_SESSION['quantite']+1;
                                        
                            $retour2=$log2->updateDVD($_SESSION['id_dvd'],$_SESSION['titre'],$_SESSION['realisateur'],$_SESSION['scenariste'],$_SESSION['producteur'],$_SESSION['date_sortie'],$_SESSION['quantite'],$_SESSION['image_dvd'],$_SESSION['description']);

                            if($retour2=='DVD mis à jour')
                            {
                            ?>
                                <p class="deeppink grand souligner">
                            <?php
                                print 'Base de données mise à jour';
                                $montant = 0;
                                 
                                $log3 = new clientBD($cnx);
                                $_SESSION['id_client']=$_POST['client'];
                                $data3=$log3->rechercheClientSurSonID($_SESSION['id_client']);

                                $nbr3= count($data3);

                                for($i = 0;$i < $nbr3 ;$i++)
                                {
                                    $_SESSION['reduction'] = $data3[$i]['reduction'];
                                }
                                
                                $reductionAccordee = $_SESSION['reduction'];
                        
                                 // je calcule le montant totale que le client devra payer mais le paiement en lui
                                 // même se faira sur un autre site plus sécurisé tel que paypal ou autre
                                 // qui peuvent gérer les paiements des sites en ligne                             
                               
                                 if($_POST['choix']=='Oui')
                                 {
                                    if($_SESSION['duree']=='1 à 2 jours                     ')
                                    {
                                       $montant= ((3+2)/100*(100-$reductionAccordee))+5; // 8 euros de base lors d'une pénalité sans la durée
                                       $message="Le client vous doit : ".$montant." euros.";
                                       echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                                    }
                                    else if($_SESSION['duree']=='3 à 5 jours                     ')
                                    {
                                       $montant= ((3+3)/100*(100-$reductionAccordee))+5;
                                       $message="Le client vous doit : ".$montant." euros.";
                                       echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                                    }
                                    else if($_SESSION['duree']=='1 semaine                       ')
                                    {
                                       $montant= ((3+4)/100*(100-$reductionAccordee))+5;
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
                                       $montant= (3+2)/100*(100-$reductionAccordee); // 3 euros de base lors sans pénalité et sans la durée
                                       $message="Le client vous doit : ".$montant." euros.";
                                       echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                                    }
                                    else if($_SESSION['duree']=='3 à 5 jours                     ')
                                    {
                                       $montant= (3+3)/100*(100-$reductionAccordee);
                                       $message="Le client vous doit : ".$montant." euros.";
                                       echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                                    }
                                    else if($_SESSION['duree']=='1 semaine                       ')
                                    {
                                       $montant= (3+4)/100*(100-$reductionAccordee);
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
                        <p class="evidence grand">Un problème lors de la suppression est intervenu</p>
                     <?php
		}
            }
        }
        else
        {
            ?>
            <p class="evidence grand">Vous devez cocher une case</p>
            <?php
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
                                            $log = new historiqueBD($cnx);
                                            $data=$log->toutLHistorique();

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
                                            $log = new historiqueBD($cnx);
                                            $data=$log->clientHistorique();

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
                                                <label class="evidence">Retard éventuel (obligatoire)</label>
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
                                echo '<p class="deeppink">Aucun DVD e location actuellement</p>';
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