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
    $sth = $db->prepare("SELECT DISTINCT articles.id, title, description, text, images.image_name, images.image_tmp, users.full_name, views, date, categories.name 
    FROM articles             
    JOIN categories ON articles.id_categories = categories.id
    JOIN images ON articles.id_image = images.id
    JOIN users ON articles.id_username = users.id
    WHERE articles.id = '$articles_id'
    GROUP BY articles.id");
    $sth->execute();
    // запрос с ингредиентами       

    if ($sth->rowCount() > 0){
        while($article = $sth->fetch(PDO::FETCH_ASSOC)){ 
            ?>
            <div class="post">
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

                <div class="post-autor">    
                    <img class="post-icon-autor" src="images\icon-user.png">                    
                    <p class="post-text-autor"><?= $article['full_name'] ?></p>                    
                </div>               

                <img class="post-picture" src="data:image/jpeg;base64, <?= base64_encode($article['image_tmp']) ?>">                    
                
                <div class="post-id"> 
                    <img class="post-icon-id" src="images\hashtag-sign.png">
                    <p class="post-id-name"><?= $article['name'] ?></p>
                </div>

                <h2 class="post-title" ><?= $article['title'] ?></a></h2>

                <p class="post-text-description"><?= $article['description'] ?></p>
                
                <p class="post-text-indigrients"> Необходимые ингредиенты: </br> </p>                    
                    
                <?=  ingredietsOutput($article['id']); ?>
                <p class="post-text-title">Процесс приготовления:</p>
                <p class="post-text"> <?= $article['text'] ?> </br> </p>                  
            </div>
            <?php             
        }     
    } else echo "Ошибка..";   
}

