<div class="btn-group" role="group" aria-label="...">
    <!--<button type="button" class="btn btn-danger"><a href="index.php?page=accueilAdministrateur.php&amp;nav=Accueil Administrateur">Accueil Administrateur</a></button>-->
       <button type="button" class="btn btn-success" width="200px"><a href="index.php?page=administrateur/retourLocation.php&amp;nav=Retour des locations"><span class="glyphicon glyphicon glyphicon-home"> Retour des locations</span></a></a></button>

    <button type="button" class="btn btn-warning"><a href="index.php?page=administrateur/ajoutDVD.php&amp;nav=Ajouter un DVD"><span class="glyphicon glyphicon-plus"> Ajouter un DVD</span></a></a></button>
    <button type="button" class="btn btn-info"><a href="index.php?page=administrateur/modifierDVD.php&amp;nav=Modifier un DVD"><span class="glyphicon glyphicon-pencil"> Modifier un DVD</span></a></a></button>
    <button type="button" class="btn btn-danger"><a href="index.php?page=administrateur/supprimerDVD.php&amp;nav=Supprimer un DVD"><span class="glyphicon glyphicon-minus"> Supprimer un DVD</span></a></a></button>
</div>
<br/><br/>
<p class="aqua">Admin n°  
    <?php
        print_r($_SESSION['id_administrateur']);
    ?>
</p>