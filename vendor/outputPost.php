<?php

require_once 'StaticConnection.php';

function ingredietsOutput($article_id)
{
    $db = StaticConnection::getConnection();
    $sth = $db->prepare("SELECT DISTINCT indigrients.id, indigrient, indigrients.id_article, GROUP_CONCAT(CONCAT(amount, ' ' , measures.measure)) AS amount
    FROM indigrients 
    JOIN measures ON indigrients.id_measure = measures.id
    WHERE indigrients.id_article = '$article_id'  
    GROUP BY indigrients.id");
    $sth->execute();

    if ($sth->rowCount() > 0){
        while($indigrients = $sth->fetch(PDO::FETCH_ASSOC)){  
            ?>                          

            <div class="post-indigrients">                 
                    <div class="post-indigrients-indigrient" >
                    <?= $indigrients['indigrient'] ?>
                    </div>

                    <div class="post-indigrients-amount" >
                    <?= $indigrients['amount'] ?> 
                    </div>                
            </div>              
            <?php            
        }
    }
}

//вывод статей на  страницу post.php
function generationOutput()
{
    $articles_id = intval($_GET['id_article']);

    $db = StaticConnection::getConnection();
    $sth = $db->prepare("SELECT DISTINCT articles.id, title, description, text, users.id AS id_user, users.full_name, views, date, categories.name 
    FROM articles             
    JOIN categories ON articles.id_categories = categories.id   
    JOIN users ON articles.id_username = users.id
    WHERE articles.id = '$articles_id'
    GROUP BY articles.id");
    
    $sth->execute();
    // запрос с ингредиентами       

    if ($sth->rowCount() > 0){
        while($article = $sth->fetch(PDO::FETCH_ASSOC)){ 
            ?>
            <div class="post">
                
                
                <div class="post-id"> 
                    <img class="post-icon-id" src="images\hashtag-sign.png">
                    <p class="post-id-name"><?= $article['name'] ?></p>
                </div>

                <h2 class="post-title" ><?= $article['title'] ?></a></h2>

                <img class="post-image" <?= $id_article = $article['id'];
                                                $sth = $db->prepare("SELECT recipe_picture_boolean, images.id_article, images.image_name, images.image_tmp
                                                FROM images            
                                                WHERE images.id_article = $id_article AND recipe_picture_boolean = 1"); 
                                                $sth->execute();
                                                $image = $sth->fetch(PDO::FETCH_ASSOC); ?> src="data:image/jpeg;base64, <?= base64_encode($image['image_tmp']) ?>">                    
                
                

                <p class="post-text-description"><?= $article['description'] ?></p>
                
                <p class="post-text-indigrients"> Необходимые ингредиенты: </br> </p>                    
                    
                <?=  ingredietsOutput($article['id']); ?>
                <p class="post-text-title">Процесс приготовления:</p>
                <div class="post-cooking-process">
                    <div class="post-picture">
                        <?php $id_article = $article['id'];
                            $sth = $db->prepare("SELECT recipe_picture_boolean, images.id_article, images.image_name, images.image_tmp
                                                    FROM images            
                                                    WHERE images.id_article = $id_article AND recipe_picture_boolean = 0"); 
                            $sth->execute();
                            if ($sth->rowCount() > 0){
                                while($picture = $sth->fetch(PDO::FETCH_ASSOC)){ 
                                    ?> <img class="post-picture-image" src="data:image/jpeg;base64, <?= base64_encode($picture['image_tmp']) ?>"> 
                                    <?php
                                }
                            } ?>


                    </div>
                    <p class="post-text"> <?= $article['text'] ?> </br> </p> 

                </div>  
                    

                    <div class="post-autor">    
                        <img class="post-icon-autor" src="images\icon-user.png">                    
                        <a href="autor.php?user=<?= $article['id_user'] ?>">
                            <p class="post-text-autor"><?= $article['full_name'] ?></p> 
                        </a>                    
                    </div> 
                    
                    <div class="post-headdescription">
                        <div class="post-views">    
                            <img class="post-icon-views" src="images\eye.png">
                            <p class="post-text-views"><?= $article['views'] ?> </p>
                        </div>

                        <div class="post-date">
                            <img class="post-icon-date" src="images\date.png">
                            <p class="post-date"><?= $article['date'] ?> </p>
                        </div>  
                    </div>
            </div>

            <?php             
        }     
    } else echo "Ошибка..";   
}



