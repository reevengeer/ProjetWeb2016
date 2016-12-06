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
<!-- protection de la connexion d'une attaque par la force brute via l'utilisation de cookies, 
empechant la connexion pour une durée de 10 min -->
<?php
        if(isset($_SESSION['nombre']) and isset($_SESSION['timestamp_limite']) < time())
        {
                // on enlève les variables de session
                unset($_SESSION['nombre']);
                unset($_SESSION['timestamp_limite']);
        }
        // Si le cookie n'existe pas 
	if(!isset($_COOKIE['marqueur']))
	{ 
            if(!isset($_SESSION['nombre']))
            {
		// Initialisation de la variable 
		$_SESSION['nombre'] = 0;
                // Blocage pendant 10 min
                $_SESSION['timestamp_limite'] = time() + 60*10;
            }
            if($_SESSION['nombre'] < 4)
	    {
            ?>
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

                                    $_SESSION['connexionClient']='valide';
                                }
                                if (count($data)!=0)
                                {
                                    header('Location: index.php?page=client/accueilClient.php');
                                }
                                else if (count($data)==0)
                                {
                                    $log = new administrateurBD($cnx);
                                    $data=$log->connexionAdministrateur($_POST['Identifiant'],$_POST['mdp']);

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

                                        $_SESSION['connexionAdministrateur']='valide';
                                    }
                                    if (count($data)!=0)
                                    {
                                        header('Location: index.php?page=administrateur/retourLocation.php');  
                                    }
                                    else 
                                    {
                                        // incrémentation du nombre d'essaie effectuer
                                        $_SESSION['nombre'] = $_SESSION['nombre']+1;
                                        ?>
                                        <p class="deeppink grand">Personne ne correspond aux valeurs entrées.</p>
                                       <?php
                                       echo '<p class="deeppink grand">Il ne vous reste que '.(5-$_SESSION['nombre']).' essaies.</p>';

                                    }
                                }
                            }
                        else
                        {
                            echo '<p class="evidence centre">champs non remplis.</p>';
                        }
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            else
            {
                // Si le cookie marqueur n'existe pas on le crée 
	        if(!isset($_COOKIE['marqueur']))
                {
                    $timestamp_marque = time() + 60; // On le marque pendant une minute 
                    $cookie_vie = time() + 60*60*24; // Durée de vie de 24 heures pour le décalage horaire
		    setcookie("marqueur", $timestamp_marque, $cookie_vie);
                    echo '<br/><p class="deeppink grand centre">Veuillez attendre 10 minutes avant de pouvoir essayer de vous connecter</p><br/>';
		}		
                // on quitte le script
                exit();
            }
        }
        else
        {
            echo '<br/><p class="deeppink grand centre">Veuillez attendre 10 minutes avant de pouvoir essayer de vous connecter</p><br/>';
            // Si le temps de blocage a été dépassé
            if($_COOKIE['marqueur'] < time())
            {
                // Destruction du cookie
                setcookie("marqueur", "", 0);
            }
        }
?>