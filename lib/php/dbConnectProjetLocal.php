<?php
	$dsn='pgsql:host=localhost;dbname=projetWeb2016;port=5432';
	$user='admin';
	$password='banane';
	try
	{
		$cnx = new PDO ($dsn,$user,$password);
                $connexion = "host=localhost user=admin dbname=projetWeb2016 password=banane port=5432"; 
                $cn = pg_connect ($connexion);
		?>
                <h6>Connexion etablie!</h6>
                <?php
	}
	catch (PDOException $e)
	{
		print $e;
	}
?>