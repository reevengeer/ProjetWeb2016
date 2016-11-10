<?php
    session_start();
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
<h1 class="centre evidence">Accueil client</h1>
<div class="well">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4 col-md-3 col-lg-2">
                <div>
                    <h2 class="deux">Bienvenue sur votre espace client</h2>
                    <p class="evidence">Bonjour 
                        <span class="souligner">
                            <?php
                                print_r($_SESSION['nom']);
                                print " ";
                                print_r($_SESSION['prenom']);
                            ?>
                        </span>
                    </p>
                    <p class="evidence">Vous avez acutellement  
                        <?php
                            print_r($_SESSION['reduction']);
                            print "% de réduction";
                        ?>
                    </p>
                    <script type="text/javascript">
                        var passWord = $_SESSION['password'] ;
                    </script>
                    <p class="evidence">Votre password : 
                        <img id="motDePasse" class="droite" src="././images/pressez.png" alt="logo"/>
                    </p>
                   

                    <h4 class="souligner">Suivez-nous sur les réseaux sociaux</h4>
                    <div>
                        <p>
                            <a href="https://www.facebook.com/" target="_blank"><img class="gauche" src="./images/logo_facebook.png" alt="logo"/></a>
                            <a class="legerement_a_droite aqua" href="https://www.facebook.com/" target="_blank">facebook</a>
                        </p>
                    </div>
                    <div>
                        <p>
                            <a href="https://twitter.com/" target="_blank"><img class="gauche" src="./images/logo_twitter.png" alt="logo"/></a>
                            <a class="legerement_a_droite aqua" href="https://twitter.com/" target="_blank">Twitter</a>
                        </p>
                    </div>
                    <div>
                        <p>
                            <a href="https://www.instagram.com/" target="_blank"><img class="gauche" src="./images/logo_instagram.png" alt="logo"/></a>
                            <a class="legerement_a_droite aqua" href="https://www.instagram.com/" target="_blank">Instagram</a>
                        </p>
                    </div>
                </div>
            </div>  
            <div class="col-sm-4 col-md-5 col-lg-5">
                <div>
                    <h3>Notre Service </h3>
                    <p>
                        Cette vidéothèque en ligne vous propose d'accéder, depuis chez vous, à un choix incomparable 
                        de DVD/Blu-ray.
                    </p>
                    <p>Rolland Marc Services sa, la société fictive qui gère notre site, a été créée en novembre 
                        2016, et a son siège social et d'exploitation à Quievrain, choisie comme plate-forme d'envoi pour 
                        toute la Belgique et le Luxembourg.
                    </p>
                    <p>Notre site a recopié dans l'intégralité du texte de présentation
                        de http://public.dvdpost.com/fr/ car votre administrateur n'avait pas d'idée de présentation.
                    </p>
                </div>
            </div>   
            <div class="col-sm-4 col-md-4 col-lg-5">
                <div>
                    <h3>Explication du menu</h3>
                    <p>
                        La partie location est la page sur lequel vous allez pourvoir commander vos DVD. Une fois le
                        choix confirmer vous serez amener à payer le total de la commande pour que votre commande soit
                        réalisé.
                    </p>
                    <p>
                        La partie Hhistorique correspond à l'historique de vos anciennes commandes
                        réalisés sur notre site. Vous aurez toujours un oeil sur vos films déjà visionnés.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>