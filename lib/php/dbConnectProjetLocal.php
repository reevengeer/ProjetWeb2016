<?php
	$dsn='pgsql:host=localhost;dbname=projetWeb2016;port=5432';
	$user='admin';
	$password='banane';
	try
	{
		$cnx = new PDO ($dsn,$user,$password);
		?>
                <h6>Connexion etablie</h6>
                <?php
	}
	catch (PDOException $e)
	{
		print $e;
	}
?>