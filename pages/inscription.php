<nav class="menu">
		<?php
                    if (file_exists('./lib/php/menu.php'))
                    {
			include './lib/php/menu.php';
       		    }
               	    else
		    {
                        //tester l'existence du fichier pour que la page s'affiche même si le fichier manque (file_exists)
			echo "Il semblerait que nous ayions des problemes technique, veuillez nous en excuser .. ";
		    }
		?>
</nav>
<h1 class='titre'>inscription</h1>
<div class='legerement_a_droite'>
    <h2 class='evidence'>Enregistrez-vous !!!</h2>
    <div class="container largeur">
        <div class="table table-bordered">
            
            <form action="index.php?page=inscription.php" method="POST" class="form-horizontal cadre">
                
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="nom">Nom :</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-inline" id="nom" name="nom" placeholder="Votre nom">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="prenom">Prénom :</label>
                  <div class="col-sm-10"> 
                    <input type="text" class="form-inline" id="prenom" name="prenom" placeholder="Votre prénom">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="ville">Ville :</label>
                  <div class="col-sm-10"> 
                    <input type="text" class="form-inline" id="ville" name="ville" placeholder="Votre ville">
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 evidence" for="adresse">Adresse :</label>
                    <div class="col-sm-10"> 
                      <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Votre adresse">
                    </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="identifiant">Identifiant :</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="identifiant" name="identifiant" placeholder="Votre identifiant">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="mdp1">Mot de passe :</label>
                  <div class="col-sm-10"> 
                    <input type="password" class="form-control" id="mdp1" name="mdp1" placeholder="Votre mot de passe">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="mdp2">Confirmer votre mot de passe :</label>
                  <div class="col-sm-10"> 
                    <input type="password" class="form-control" id="mdp2" name="mdp2" placeholder="Confirmer votre mot de passe">
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
    </div>
        
        <?php 
            $flag=0;
            if(isset($_POST['Envoyer']))
            {
		if($_POST['nom']!="" && $_POST['prenom']!=""&& $_POST['ville']!=""&& $_POST['adresse']!=""
                        && $_POST['identifiant']!=""&& $_POST['mdp1']!=""&& $_POST['mdp2']!="")
		{
                    if($_POST['mdp1']==$_POST['mdp2'])
                    {
			$flag=1;
			/*echo "Votre EMAIL pour l'inscription est : ".$_GET['email']."<br>";
			echo "votre mot de passe a bien été enregistré"."<br>";*/
			$query="select insert_client(:nom,:prenom,:ville,:adresse,:login,:password)";
                        $resultset = $cnx->prepare($query);

                        $resultset -> bindValue(1,$_POST['nom']); 
                        $resultset -> bindValue(2,$_POST['prenom']); 
                        $resultset -> bindValue(3,$_POST['ville']);
                        $resultset -> bindValue(4,$_POST['adresse']);
                        $resultset -> bindValue(5,$_POST['identifiant']); 
                        $resultset -> bindValue(6,$_POST['mdp1']);

                        $resultset->execute();

                        $retour = $resultset->fetchColumn(0);

                        if($retour=='Le client a été ajouté')
                        {
                            // petit message pour indique que l'enregistrement a bien été effectué ... sans succés malgré avoir desactivé mes adblocks
                            $query = "select * from CLIENT where login='".$_POST["identifiant"]."' AND password='".$_POST["mdp1"]."'";

                            $resultset = $cnx->prepare($query);

                            $resultset->execute();
                            $data = $resultset->fetchAll();

                            $nbr= count($data);
                            for($i = 0;$i < $nbr ;$i++)
                            {
                                //print "<br>".$data[$i]['nom'];
                                $_SESSION['id_client'] = $data[$i]['id_client'];
                                $_SESSION['nom'] = $data[$i]['nom'];
                                $_SESSION['prenom'] =$data[$i]['prenom'];
                                $_SESSION['reduction'] = $data[$i]['reduction'];
                                $_SESSION['ville'] = $data[$i]['ville'];
                                $_SESSION['adresse'] = $data[$i]['adresse'];
                                $_SESSION['login'] = $data[$i]['login'];
                                $_SESSION['password'] = $data[$i]['password'];
                            }

                            header('Location: index.php?page=client/accueilClient.php'); 
                        }
                        else if ($retour!='Le client a été ajouté')
                        {
                            ?>
                            <p>Un problème est intervenue.</p>
                            <p>Le informations entrées doivent correspondre à celle d'un autre client.</p>
                            <?php
                        }
                    }
                    else
                    {
                        ?>
                            <p class="evidence grand">Votre mot de passe est différent dans les deux cases.</p>
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
    
    
        <!--    <?php
            $query="select insert_client(:nom,:prenom,:ville,:adresse,:login,:password)";
            $resultset = $cnx->prepare($query);

            $resultset -> bindValue(1,"plopiuee"); 
            $resultset -> bindValue(2,"Poussin jaune"); 
            $resultset -> bindValue(3,"plop");
            $resultset -> bindValue(4,"lien");
            $resultset -> bindValue(5,"Poussin jaune"); 
            $resultset -> bindValue(6,"plop");

            $resultset->execute();

            $retour = $resultset->fetchColumn(0);

            if($retour=='Le client a été ajouté')
            {
                ?>
                <p>Vous vous êtes bien enregistrez.</p>
                <?php
            }
            else if ($retour!='Le client a été ajouté')
            {
                ?>
                <p>Un problème est intervenue.</p>
                <p>Le informations entrées doivent correspondre à celle d'un autre client.</p>
                <?php
            }
    ?> -->