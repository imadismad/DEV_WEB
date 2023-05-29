<?php
session_start();
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeautyMix • Recette</title>
    <link rel="stylesheet" href="recette.css">
</head>
<body>
<section>
<center>
    <br><br><br>
    <div class="form-box2"><!--case pour la recette, et chaque section est délimitée par une balise hr-->
        <div class="like-button"><!--bouton j'aime-->
            <div class="heart-bg">
                <div class="heart-icon"></div>
            </div>
        </div>
        <!--div de la note de la recette-->
        <div id="noteetoile">
            <p id="noterecette">4.5 &#11088;</p>
        </div>
        <h2 id="nomrecette">Anti-cernes (j'en ai besoin mdrrr)</h2><!--titre de la recette-->
        <br>
        <br>
        <center><img id="imagerecette" src="chat.jpeg" alt="profiteroles au chocolat"></center><!--image de la recette-->
        <br><br>
        <!--les différentes informations-->
        <p id="categorie">Catégorie : Peau </p>
        <p id="prix"> Prix moyen : 10 &#8364; 00</p>
        <p id="dificulte">Difficulté : moyen</p>
        <br><br>
        <hr>
        <br><br>
        <div id="ingredients">
            <h2>Ingrédients</h2><br><br>
            <p>• 125 g d'eau</p><br>
            <p>• 60 g de beurre</p><br>
            <p>• 1 pincée de sel</p><br>
            <p>• 100 g de farine</p><br>
            <p>• 2 oeufs</p><br>
            <p>• 150 g de chocolat noir</p><br>
            <p>• 1/8 de litre de lait</p><br>
            <p>• 25 g de sucre</p><br>
            <p>• Glace au chocolat</p><br>
            <p>• 1/4 de litre de crème liquide</p><br>
            <p>• 60 g de sucre</p><br>
            <p>• vanille liquide</p><br>
            <p>• 60 g d'amandes</p><br>
        </div>
        <br><br>
        <hr>
        <br><br>
        <div id="etapes">
            <h2>Etapes</h2>
            <br><br>
            <p>• Préchauffez le four à 180°C</p><br>
            <p>• Faites fondre dans une casserole le lait, l'eau, le sel et sucre, ainsi que le beurre</p><br>
            <p>• ajoutez hors du feu la farine en une seule fois et mélangez bien pour obtenir une pâte homogène.</p><br>
            <p>• Hors du feu, ajoutez les oeufs un par un en mélangeant bien : vous allez obtenir une pâte lisse et homogène</p><br>
            <p>• Remplissez une poche à douille de cette pâte, et sur une plaque recouverte de papier cuisson, formez des petits choux de 2 ou 3 cm de diamètre</p><br>
            <p>• Enfournez pour 30 minutes sans ouvrir la porte du four en cours de cuisson</p><br>
            <p>• Faites chauffer le lait jusqu'à frémissement</p><br>
            <p>• Battez les jaunes d'oeuf avec le sucre et la vanille jusqu'à ce que le mélange soit bien mousseux, ajoutez la maizéna</p><br>
            <p>• Versez le lait bouillant sur ce mélange en fouettant bien</p><br>
            <p>• Remettez dans la casserole et faites épaissir quelques minutes à feu très doux sans cesser de remuer</p><br>
            <p>• Laissez refroidir puis placez au frais</p><br>
            <p>• Faites chauffer la crème dans une casserole</p><br>
            <p>• Versez sur le chocolat coupé en morceaux</p><br>
            <p>• Lissez avec un fouet et versez sur les profiteroles garnies de crème.</p><br>
            </div>
        <br><br>
    </div>
        <br><br><br><br><br><br><br><br><br><br><br>
        <!--section commentaire-->
        <div id="commentaire" class="form-box2">
            <h2>Commentaires</h2>
            <br>
            <div id="postcommentaire" class="form-box25">
                    <h3>Laissez un commentaire !</h3>
                    <br>
                    <form action="ajoutercomm.php" id="formcommentaire" method="post">
                        <center>
                            <div id="erreur"></div>
                            <div class="rating">
                            <input type='radio' hidden name='rate' value="5" id='rating-opt5' data-idx='0'>	
                            <label class="note" for='rating-opt5'><span>Vraiment satisfait</span></label>
                        
                            <input type='radio' hidden name='rate' value="4" id='rating-opt4' data-idx='1'>
                            <label class="note" for='rating-opt4'><span>Assez satisfaisant</span></label>
                        
                            <input type='radio' hidden name='rate' value="3" id='rating-opt3' data-idx='2'>
                            <label class="note" for='rating-opt3'><span>Neutre</span></label>
                        
                            <input type='radio' hidden name='rate' value="2" id='rating-opt2' data-idx='3'>
                            <label class="note" for='rating-opt2'><span>Insatisfaisant</span></label>
                        
                            <input type='radio' hidden name='rate' value="1" id='rating-opt1' data-idx='4'>
                            <label class="note" for='rating-opt1'><span>Vraiment insatisfaisant</span></label>
                            </div>
                        </center>
                        <br>
                        <div class="inputbox">
                            <input type="text" id="titrecommentaire">
                            <label for="titrecommentaire">Titre</label>
                        </div>
                        <input type="hidden" value="112" id="idrecette">
                        <br>
                        <textarea name="Commentaire" id="moncommentaire" cols="90" rows="10" required placeholder="Votre commentaire"></textarea>
                        <br><br>
                        <button type="submit" class="choice">Poster</button>
                    </form>
            </div>
            <br>
            <br>
            <hr>
            <br>
            <br>
                <div class="form-box25" class="commentaireposte">
                    <h4 id="name">Nom Prenom</h4>
                    <!--note sur 5 a faire-->
                    <br><p id="commentaire">je trouve que je suis beau</p><br>
                </div>
                <br><br><br>
        </div>
        <br><br><br><br><br>
</center>
</section>
<!--script du bouton j'aime-->
<script>
    const likeButton = document.querySelector(".like-button");
    const heartIcon = likeButton.querySelector(".heart-icon");
    let isLiked = false;

    likeButton.addEventListener("click", () => {
    heartIcon.classList.toggle("liked");
    
    if (isLiked) {
        unlikeAction();
    } else {
        likeAction();
    }
    
    isLiked = !isLiked;
    });

</script>
<script src="favoris.js"></script>
</body>
</html>