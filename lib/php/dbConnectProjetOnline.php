<?php // si on veut travailler avec la base de donnée de l'école
// définition de la variable de connexion
	$connexion = "host=lamp-edu.condorcet.be user=marc.rolland dbname=marc_rolland_projet password=banane port=5432"; 
	$cnx = pg_connect ($connexion);
	if(!$cnx)
	{
		echo 'Echec de la connexion à la base de données';
		exit( );
	}
	else
	{
		echo 'Connexion en ligne établie';
	}
?>