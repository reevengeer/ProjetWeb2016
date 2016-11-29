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
<h1 class="aqua legerement_a_droite souligner">Modification de ses informations</h1>
<div class='legerement_a_droite'>
    <?php 
            $flag=0;
            if(isset($_POST['Modifier']))
            {
                ?><br/><?php
                if($_POST['mdp1']!=$_POST['mdp2'])
                {
                    echo '<p class="deeppink grand">Votre nouveau mot de passe doit être identique dans les deux cases</p>';
                }
                else
                {
                    if($_POST['ville']!=""&& $_POST['adresse']!=""&& $_POST['login']!=""&& $_POST['mdp1']!=""&& $_POST['mdp1']==$_POST['mdp2'])
                    {

                            //print 'ok';

                            $flag=1;
                            $query="select update_client(:nom,:prenom,:ville,:adresse,:login,:password)";
                            $resultset = $cnx->prepare($query);

                            $resultset -> bindValue(1,$_SESSION['nom']);
                            $resultset -> bindValue(2,$_SESSION['prenom']); 
                            $resultset -> bindValue(3,$_POST['ville']); 
                            $resultset -> bindValue(4,$_POST['adresse']);
                            $resultset -> bindValue(5,$_POST['login']);
                            $resultset -> bindValue(6,$_POST['mdp1']); 

                            $resultset->execute();

                            $retour = $resultset->fetchColumn(0);

                            if($retour=='Client mis à jour')
                            {
                                $_SESSION['ville']=$_POST['ville'];
                                $_SESSION['adresse']=$_POST['adresse'];
                                $_SESSION['login']=$_POST['login'];
                                
                                ?>
                                <p class="deeppink grand souligner">
                                    <?php
                                        print 'Vos informations ont bien été mis à jour dans la base de données.';
                                    ?>
                                </p>
                                <?php
                            }
                            else if ($retour!='Client mis à jour')
                            {
                                ?>
                                <p class="deeppink grand">Un problème est intervenue.</p>
                                <?php
                            }
                    }
                    else
                    {
                        ?>
                            <p class="deeppink grand">Vous devez tout compléter.</p>
                         <?php
                    }
                }
            }
        ?>
    <h2 class='evidence'>Veuillez entrer vos nouvelles informations</h2>
    <h3 class='deeppink'>Les caractères spéciaux sont à éviter.</h3>
    <div class="container largeur">
        <div class="table table-bordered">    
            <p class="deeppink grand souligner">Informations non modifiables</p>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="nom">Nom :</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-inline" id="nom" name="nom" value="<?php echo $_SESSION['nom']; ?>" disabled >
                  </div>
                </div>
            <br/>
            <br/>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="prenom">Prénom :</label>
                  <div class="col-sm-10"> 
                    <input type="text" class="form-inline" id="prenom" name="v" value="<?php echo $_SESSION['prenom']; ?>" disabled >
                  </div>
                </div>
            <br/>
            <br/>
        </div>
        <div class="table table-bordered"> 
        <form action="index.php?page=client/modifierClient.php" method="POST" class="form-horizontal cadre">
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="ville">Ville :</label>
                  <div class="col-sm-10"> 
                    <input type="text" class="form-inline" id="ville" name="ville" value="<?php echo $_SESSION['ville']; ?>">
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 evidence" for="adresse">Adresse :</label>
                    <div class="col-sm-10"> 
                      <input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo $_SESSION['adresse']; ?>">
                    </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="login">Login :</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-inline" id="login" name="login" value="<?php echo $_SESSION['login']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="mdp1">Password :</label>
                  <div class="col-sm-10"> 
                      <input type="password" class="form-control" id="mdp1" name="mdp1" placeholder="votre nouveau mot de passe">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="mdp2">Password :</label>
                  <div class="col-sm-10"> 
                      <input type="password" class="form-control" id="mdp2" name="mdp2" placeholder="Confimation du nouveau mot de passe">
                  </div>
                </div>
                <div class="form-group"> 
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" value="Modifier" name="Modifier">Confirmer modification</button>
                    <button type="reset" class="btn btn-danger">Annuler</button>
                  </div>
                </div>
                
            </form>
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