<div class="btn-group" role="group" aria-label="...">
    <!--<button type="button" class="btn btn-danger"><a href="index.php?page=accueilAdministrateur.php&amp;nav=Accueil Administrateur">Accueil Administrateur</a></button>-->
    <button type="button" class="btn btn-warning"><a href="index.php?page=administrateur/ajoutDVD.php&amp;nav=Ajouter un DVD">Ajouter un DVD</a></button>
    <button type="button" class="btn btn-info"><a href="index.php?page=administrateur/modifierDVD.php&amp;nav=Modifier un DVD">Modifier un DVD</a></button>
    <button type="button" class="btn btn-danger"><a href="index.php?page=administrateur/supprimerDVD.php&amp;nav=Supprimer un DVD">Supprimer un DVD</a></button>
</div>
</br>
<h2 class="aqua">Bienvenue 
    <span class="souligner">
        <?php
            print_r($_SESSION['nom']);
            print " ";
            print_r($_SESSION['prenom']);
        ?>
    </span>
</h2>
<p class="aqua">Admin n°  
    <?php
        print_r($_SESSION['id_administrateur']);
    ?>
</p>