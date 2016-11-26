<!doctype html> 
<?php // connexion à la base de donnée en ligne
	//require './lib/php/dbConnectProjetOnline.php';
?>
<?php // connexion à la base de donnée en local
	require './lib/php/dbConnectProjetLocal.php';
?>
<?php
    session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        
        <link rel="stylesheet" type="text/css" href="./lib/css/bootstrap-3.3.7/dist/css/bootstrap.css">
        
        <link rel="stylesheet" type="text/css" href="./lib/css/mediaqueries.css" />
        
        <script type="text/javascript" src="./lib/javaScript/jquery-3.1.1.js"></script>
        
        <script type="text/javascript" src="./lib/css/bootstrap-3.3.7/dist/js/bootstrap.js"></script>
        
        <script type="text/javascript" src="./lib/javaScript/functionsJquery.js"></script>
        
        <title>Projet Web 2016</title>
    </head>
    
    <body>
        <div id="format">
            
	    <header> 
	    </header>
		
	    <div class="droite_avec_bordure">
                <!-- affichage de la page que l'on visite en ce moment-->
		<?php 
                    if(!isset($_SESSION['nav'])) // si la variable de session n'existe pas
			$_SESSION['nav']="accueil";
		    if(isset($_GET['nav'])) // si on est passé par le menu
			$_SESSION['nav']=$_GET['nav'];
		    echo $_SESSION['nav'];
		?>
	    </div>
            </br>
	    <section id="contenu">
                
                <!-- partie sur l'ajout de la page -->
		<?php
                    if(!isset($_SESSION['page']))
			$_SESSION['page']="accueil.php";
                    if(isset($_GET['page']))
			$_SESSION['page']=$_GET['page'];
			$p="./pages/".$_SESSION['page'];
                        
		    if(file_exists($p))//tester l'existence de la page 
                    {
			include $p;
                    }
                    else
                    {
			echo "page en construction";
                    }
		?>
                <hr/>
            </section>
            <footer>
                <div id="footer">
                    <?php
                    if (file_exists('./pages/footer.php'))
                    {
                            include './pages/footer.php';//si footer exist
                    }
                    else
                    {
                            echo "Petite erreur technique...";
                    }
                    ?>
                </div>
		<a href="index.php?page=deconnect.php">
                    <img class="droite" src="./images/logo_sortie.png" alt="logo"/>
                </a>
                </br></br>
            </footer>
	</div>
    </body>
    
</html>
