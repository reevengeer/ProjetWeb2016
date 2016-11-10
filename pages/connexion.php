<?php
    session_start();
?>
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

<h1 class='titre'>Connexion</h1>
<div class='legerement_a_droite'>
    <h2 class='evidence'>Connectez-vous !!!</h2>
    <div class="container largeur">
        <div class="table table-bordered">
            
            <form action="index.php?page=connexion.php" method="POST" class="form-horizontal cadre">
                
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
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" value="Envoyer" name="Envoyer">Envoyer</button>
                    <button type="reset" class="btn btn-danger">Annuler</button>
                    <div class=btn-group> 
                    <button type=button class="btn btn-danger dropdown-toggle" data-toggle=dropdown aria-haspopup=false aria-expanded=false>Problème de connexion ???
                        <span class=caret></span>
                    </button> 
                    <ul class=dropdown-menu> 
                        <li><a href="index.php?page=retrouvermdp.php">Mot de passe oublié</a></li> 
                        <li><a href="index.php?page=inscription.php">S'inscrire</a></li>
                        <li role=separator class=divider></li> 
                        <li><a href="index.php?page=accueil.php">Accueil</a></li> 
                    </ul> 
                    </div> 
                  </div>
                </div>
                
            </form>
            
        </div>
        <?php 
            $flag=0;
            if(isset($_POST['Envoyer']))
            {
		if($_POST['Identifiant']!="" && $_POST['mdp']!="")
		{
                    $flag=1;
                    //$query = $cnx->prepare("SELECT * FROM CLIENT WHERE login='".$_POST["Identifiant"]."' AND password='".$_POST["mdp"]."'");
                    $query = "select * from client where login='".$_POST["Identifiant"]."' AND password='".$_POST["mdp"]."'";

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
                    if (count($data)!=0)
                    {
                        header('Location: index.php?page=client/accueilClient.php');
                    }
                    else if (count($data)==0)
                    {
                        $query = "select * from Administrateur where login='".$_POST["Identifiant"]."' AND password='".$_POST["mdp"]."'";

                        $resultset = $cnx->prepare($query);

                        $resultset->execute();
                        $data = $resultset->fetchAll();

                        $nbr= count($data);
                        for($i = 0;$i < $nbr ;$i++)
                        {
                            //print "<br>".$data[$i]['nom'];
                            $_SESSION['id_administrateur'] = $data[$i]['id_administrateur'];
                            $_SESSION['nom'] = $data[$i]['nom'];
                            $_SESSION['prenom'] =$data[$i]['prenom'];
                            $_SESSION['salaire'] = $data[$i]['salaire'];
                            $_SESSION['ville'] = $data[$i]['ville'];
                            $_SESSION['adresse'] = $data[$i]['adresse'];
                            $_SESSION['login'] = $data[$i]['login'];
                            $_SESSION['password'] = $data[$i]['password'];
                        }
                        if (count($data)!=0)
                        {
                            header('Location: index.php?page=administrateur/ajoutDVD.php');  
                        }
                        else 
                        {
                            ?>
                            <p class="evidence grand">Personne ne correspond aux valeurs entrées.</p>
                           <?php
                        }
                     }
                }
            else
            {
                print 'champs non remplis.';
            }
        }
    ?>

    </div>
