<?php 
    session_destroy(); // a utiliser si on se connecte sur le serveur
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
<h1 class="titre">Merci pour votre visite</h1>
<div class="evidence centre">
    <br/>
    <h3> Nous ésperons que l'expérience offerte fût agréable et au plaisir de vous revoir chez nous.</h3>
    <br/>
    <h3>ADRESSE: 16 Rue du Bas du Tiers Milieu, 7000 Mordor</h3>
    <br/>
    <img class="img-responsive center-block" src="images/giphy3.gif" alt="gif1"/>
</div>
