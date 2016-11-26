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
<h1>historique</h1>