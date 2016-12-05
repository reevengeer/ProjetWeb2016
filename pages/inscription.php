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
                  <label class="control-label col-sm-2 evidence" for="Identifiant">Identifiant :</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="Identifiant" name="Identifiant" placeholder="Votre identifiant">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="mdp">Mot de passe :</label>
                  <div class="col-sm-10"> 
                    <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Votre mot de passe">
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
                        && $_POST['Identifiant']!=""&& $_POST['mdp']!=""&& $_POST['mdp2']!="")
		{
                    if($_POST['mdp']==$_POST['mdp2'])
                    {
			$log = new clientBD($cnx);
                        $retour=$log->inscription($_POST['nom'],$_POST['prenom'],$_POST['ville'],$_POST['adresse'],$_POST['Identifiant'],$_POST['mdp']);
                        
                        if($retour=='Le client a été ajouté')
                        {
                            $log = new clientBD($cnx);
                            $data=$log->connexionClient($_POST['Identifiant'],$_POST['mdp']);

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
                                
                                $_SESSION['connexion']='valide';
                            }

                            //print 'ok';
                            //print $_SESSION['connexion'];
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