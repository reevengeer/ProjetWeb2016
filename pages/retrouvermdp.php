<h1 class='titre'>Retrouver son mot de passe</h1>
<div class='legerement_a_droite'>
    <div class="container largeur">
        <div class="table table-bordered">
            
            <form action="index.php?page=retrouvermdp.php" method="POST" class="form-horizontal cadre">
                
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="Identifiant">Identifiant :</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="Identifiant" name="Identifiant" placeholder="Votre identifiant">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="nom">Nom :</label>
                  <div class="col-sm-10"> 
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom utilisé lors de l'enregistrement">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="prenom">Prénom :</label>
                  <div class="col-sm-10"> 
                    <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prénom utilisé lors de l'enregistrement">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2 evidence" for="ville">Ville :</label>
                  <div class="col-sm-10"> 
                    <input type="text" class="form-control" id="ville" name="ville" placeholder="Votre ville utilisé lors de l'enregistrement">
                  </div>
                </div>
                <div class="form-group"> 
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" value="Confirmer" name="Confirmer">Confirmer</button>
                    <button type="reset" class="btn btn-danger">Annuler</button>
                  </div>
                </div>
                
            </form>
            
        </div>
        
        <?php 
            $flag=0;
            if(isset($_POST['Confirmer']))
            {
		if($_POST['Identifiant']!="" && $_POST['nom']!="" && $_POST['prenom']!="" && $_POST['ville']!="")
		{ 
                    // pas de regex ici puisque cette partie concerne l'utilisateur et l'administrateur.
                    // Puisque l'administrateur doit entrer manuellement ses informations dans la base de données
                    // je ne peux l'obliger à respecter un certains regex pour les infos qu'il y rentrera
                    // sous peine de ne jamais lui permettre de retrouver son mdp si il n'a pas suivi les meme regex que
                    // l'utilisateur
                    
                    $log = new clientBD($cnx);
                    $data=$log->retrouverMDPClient($_POST['Identifiant'],$_POST['nom'],$_POST['prenom'],$_POST['ville']);
                        
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
                    }
                    if (count($data)!=0)
                    {
                        $message="Votre mot de passe est : ".$_SESSION['password'];
                        echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                        //header('Location: index.php?page=client/accueilClient.php');
                    }
                    else if (count($data)==0)
                    {
                        $log = new administrateurBD($cnx);
                        $data=$log->retrouverMDPAdministrateur($_POST['Identifiant'],$_POST['nom'],$_POST['prenom'],$_POST['ville']);
                        
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
                        }
                        if (count($data)!=0)
                        {
                            $message="Votre mot de passe est : ".$_SESSION['password'];

                            echo '<script type="text/javascript">window.alert("'.$message.'");</script>';
                        }
                        else 
                        {
                            ?>
                            <p class="evidence grand">Personne ne correspond aux valeurs entrées.</p>
                           <?php
                        }
                     }
                }
            else
            {
                print 'champs non remplis.';
            }
        }
    ?>
    </div>    
</div>