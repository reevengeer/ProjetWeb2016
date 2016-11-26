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
<div class="row">
    <div class="legerement_a_droite">
        <div id="imagesAccueil">
            <div class="col-sm-6">
                <div class="legerement_a_droite">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="4"></li>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <img src="./images/accueil.png" alt="accueil">
                                <div class="carousel-caption">
                                <p class="evidence">Accueil</p>
                                </div>
                            </div>
                            <div class="item">
                                <img src="./images/Xmen.jpg" alt="Xmen">
                            </div>
                            <div class="item">
                                <img src="./images/dareDevil.jpg" alt="dareDevil">
                            </div>
                            <div class="item">
                                <img src="./images/docteurStrange.jpg" alt="docteurStrange">
                            </div>
                            <div class="item">
                                <img src="./images/deadpool.jpg" alt="deadpool">
                                <div class="carousel-caption">
                                <p class="evidence">Deadpool</p>
                                </div>
                            </div>
                        </div>

                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <h3 class="centre aqua">Exemples de films disponibles chez nous </h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <h2 id="gras_accueil">Bienvenue dans la vidéothèque du Geek.</h2>
            <div id="texteaccueil">
                <p>Nous mettrons tout en oeuvre afin de répondre à toutes vos exigences en matière cinématographique.</p>
                <p>Nous sommes spécialisés dans tout ce qui concerne la culture Geek et évidemment les récentes sorties.</p>
                <p>Nous sommes à votre disposition pour la location et la vente de DVDS, n’hésitez pas à nous contacter pour plus amples informations.</p>
                <p class="gras aqua">Horaire :</p>
                <p>Lundi :   jour de fermeture</p>
                <p>  Mardi :   9h-18h</p>
                <p>  Mercredi :9h-18h</p>
                <p>  Jeudi :   9h-18h</p>
                <p>  Vendredi: 9h-22h</p>
                <p>  Samedi :  10h-00h</p>
                <br/>
            </div>
        </div>
    </div>
</div>
<p id="devise"> Notre but : la satisfaction de notre clientèle.</p>