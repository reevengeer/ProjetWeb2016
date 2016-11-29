<?php
    if(isset($_SESSION['connexion']))
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

<?php
    $datetime = date("Y-m-d");
?>

<h1 class="aqua centre souligner">Historique de vos locations en cours</h1>
<div class='legerement_a_droite'>
    <h2 class="evidence centre">Nous sommes le : <?php echo $datetime; ?></h2>
    <br/>
    <div class="container largeur">
        <table class="blanc centre">
            <tr>
                <td class="tdHistorrique450 souligner">Titre du film</td>
                <td class="tdHistorrique souligner">Date de location</td>
                <td class="tdHistorrique souligner">Durée de la location</td>
                <td class="tdHistorrique200 souligner">Date maximum de retour</td>
            </tr>
                 <?php            
                        $query="select * from historique where id_client=".$_SESSION['id_client'];

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
                                    <td class="tdHistorrique450"><?php  echo $tab[$i]['titre_film']; ?></td>
                                    <td class="tdHistorrique"><?php  echo $tab[$i]['date_location']; ?></td>
                                    <td class="tdHistorrique"><?php  echo $tab[$i]['duree']; ?></td>
                                    <td class="tdHistorrique200">
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
    <?php
        if(isset($flag))
        { ?>
            <!-- // permet d'afficher la sanction à l'utilisateur si il est dans le cas -->
            <h2 class="deeppink centre">Tout retard entrainera une amende de 5 euros par DVD</h2>
        <?php }
    ?>
</div>

<?php
}
else
{
    echo '<p class="deeppink centre">URL non accessible</p>';
}
?>