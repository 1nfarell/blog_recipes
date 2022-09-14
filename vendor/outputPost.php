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
    $id = $_GET['id'];

    $db = StaticConnection::getConnection();
    $sth = $db->prepare("SELECT DISTINCT articles.id, title, description, users.id AS id_user, users.full_name, views, date, categories.name 
    FROM articles             
    JOIN categories ON articles.id_categories = categories.id   
    JOIN users ON articles.id_username = users.id
    WHERE articles.id = '$id'
    GROUP BY articles.id");
    
    $sth->execute();
    // запрос с ингредиентами       

    if ($sth->rowCount() > 0){
        while($article = $sth->fetch(PDO::FETCH_ASSOC)){ 
            ?>
            <div class="post">
                <img class="post-image" <?= $id_article = $article['id'];
                                                $sth = $db->prepare("SELECT recipe_picture_boolean, images.id_article, images.image_name, images.image_tmp
                                                FROM images            
                                                WHERE images.id_article = $id_article AND recipe_picture_boolean = 1"); 
                                                $sth->execute();
                                                $image = $sth->fetch(PDO::FETCH_ASSOC); ?> src="data:image/jpeg;base64, <?= base64_encode($image['image_tmp']) ?>">
                <h2 class="post-title" ><?= $article['title'] ?></a></h2>
                <div class="post-description-indigrients">
                    <p class="post-text-description"><?= $article['description'] ?></p>
                    <div class="post-text-indig">
                        <p class="post-text-indigrients"> Необходимые ингредиенты: </br> </p>                    
                            
                        <?=  ingredietsOutput($article['id']); ?>
                    </div>
                </div>
            </div>    
            <div class="post-general">
                <p class="post-text-title">Процесс приготовления:</p>
                <div class="post-cooking-process">
                    
                        <?php $id_article = $article['id'];                                 
                                $sth = $db->prepare("SELECT text, recept_text.id_article, recept_text.numeration, images.image_name, images.image_tmp 
                                                        FROM recept_text  
                                                        JOIN images ON recept_text.numeration = images.recipe_picture_boolean 
                                                        WHERE recept_text.id_article = $id_article AND images.id_article = $id_article 
                                                        ORDER BY numeration;");
                                $sth->execute();

                                if ($sth->rowCount() > 0){
                                    while($value = $sth->fetch(PDO::FETCH_ASSOC)){ 
                                        ?>  <div class="post-cooking-process-field">
                                                <div class="post-picture">
                                                    <img class="post-picture-image" src="data:image/jpeg;base64, <?= base64_encode($value['image_tmp']) ?>">
                                                </div>
                                                <div class="post-text">
                                                    <p class="post-text-value"> <?= $value['text'] ?></p> 
                                                </div>
                                            </div>
                                        <?php
                                    } 
                                } 
                                ?>
                </div>  
                <div class="info">
                    <div class="post-autor">    
                        <img class="post-icon-autor" src="images\icon-user.png">                    
                        <a href="autor.php?user=<?= $article['id_user'] ?>">
                            <p class="post-text-autor"><?= $article['full_name'] ?></p> 
                        </a>                    
                    </div> 
                    <div class="post-id"> 
                        <img class="post-icon-id" src="images\hashtag-sign.png">
                        <p class="post-id-name"><?= $article['name'] ?></p>
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
            </div>

            <?php             
        }     
    } else echo "Ошибка..";   
}



