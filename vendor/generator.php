<?php

require_once 'StaticConnection.php';

//вывод ингридиентов на главную страницу index.php, вызывается в function generationPost 
function ingredietsPost($article_id)
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

                            
                    <div class="card-indigrients-indigrient" >
                    <?= $indigrients['indigrient'] ?>
                    </div>

                    <div class="card-indigrients-amount" >
                    <?= $indigrients['amount'] ?> 
                    </div>                
                      
            <?php            
        }
    }
}

//вывод статей на главную страницу index.php
function generationPost()
{
    
    $db = StaticConnection::getConnection();
    $sth = $db->prepare("SELECT DISTINCT articles.id, title, description, users.id AS id_user, users.full_name, views, categories.name 
    FROM articles             
    JOIN categories ON articles.id_categories = categories.id   
    JOIN users ON articles.id_username = users.id
    GROUP BY articles.id 
    ORDER BY articles.id DESC");


    $sth->execute();
           

    if ($sth->rowCount() > 0){
        while($article = $sth->fetch(PDO::FETCH_ASSOC)){ 
            ?>
            <div class="main-field">
                
                                   
                <a href="post.php?id_article=<?= $article['id'] ?>">
                    <img class="card-text-picture"  <?= $id_article = $article['id'];
                                                        $sthh = $db->prepare("SELECT images.id_article, images.image_name, images.image_tmp
                                                        FROM images            
                                                        WHERE images.id_article = $id_article AND recipe_picture_boolean = 1"); 
                                                        $sthh->execute();
                                                        $image = $sthh->fetch(PDO::FETCH_ASSOC); ?> src="data:image/jpeg;base64, <?= base64_encode($image['image_tmp']) ?>">
                </a>
                
                 
                <a class="card-title" href="post.php?id_article=<?= $article['id'] ?>">
                    <h2><?= $article['title'] ?></h2>
                </a>
                
                
                <p class="card-text-description"><?= mb_substr($article['description'], 0, 200, 'UTF-8') ?></p>
                
                <div class="card-autor">    
                    <img class="card-icon-autor" src="images\icon-user.png">
                    <a href="autor.php?user=<?= $article['id_user'] ?>">
                        <p class="card-text-autor"><?= $article['full_name'] ?></p> 
                    </a>
                </div> 
                <div class="card-views">    
                    <img class="card-icon-views" src="images\eye.png">
                    <p class="card-text-views"><?= $article['views'] ?> </p>
                </div> 

                <div class="card-text-indigrients">
                    <img class="card-text-plus" src="images\plus.png"> 
                    <p class="card-text-indigr">Развернуть</p>
                </div>
                
                <div class="card-indigrients" style="display: none;"> 
                    <?= ingredietsPost($article['id']); ?>  
                </div>    
            </div>
            <?php             
        }     
    } else echo "Нет статей";      
}

function autorPost()
{
    $id_user = intval($_GET['user']);
    
    $db = StaticConnection::getConnection();
    $sth = $db->prepare("SELECT DISTINCT articles.id, title, description, users.id AS id_user, users.full_name, views, categories.name 
    FROM articles             
    JOIN categories ON articles.id_categories = categories.id   
    JOIN users ON articles.id_username = users.id
    WHERE users.id = '$id_user'
    GROUP BY articles.id 
    ORDER BY articles.id DESC");
    

    $sth->execute();
           

    if ($sth->rowCount() > 0){
        while($article = $sth->fetch(PDO::FETCH_ASSOC)){ 
            ?>
            <div class="main-field">
                <div class="card-views">    
                    <img class="card-icon-views" src="images\eye.png">
                    <p class="card-text-views"><?= $article['views'] ?> </p>
                </div>
                <div class="card-autor">    
                    <img class="card-icon-autor" src="images\icon-user.png">                    
                    <p class="card-text-autor"><?= $article['full_name'] ?></p>                    
                </div>                    
                <a href="post.php?id_article=<?= $article['id'] ?>">
                    <img class="card-text-picture"  <?= $id_article = $article['id'];
                                                        $sthh = $db->prepare("SELECT images.id_article, images.image_name, images.image_tmp
                                                        FROM images            
                                                        WHERE images.id_article = $id_article AND recipe_picture_boolean = 1"); 
                                                        $sthh->execute();
                                                        $image = $sthh->fetch(PDO::FETCH_ASSOC); ?> src="data:image/jpeg;base64, <?= base64_encode($image['image_tmp'])  ?>">
                </a>
                <div class="card-id"> 
                    <img class="card-icon-id" src="images\hashtag-sign.png">
                    <p class="card-id-name"><?= $article['name'] ?></p>
                </div>
                 
                <a class="card-title" href="post.php?id_article=<?= $article['id'] ?>">
                    <h2><?= $article['title'] ?></h2>
                </a>
                
                
                <p class="card-text-description"><?= mb_substr($article['description'], 0, 200, 'UTF-8') ?></p>
                
                <img class="card-text-indigrients" src="images\plus.png"> 
                
                <?= ingredietsPost($article['id']); ?>       
            </div>
            <?php             
        }     
    } else echo "Нет статей";      
}



//добавление полей из формы addpost.php в бд
function addPost(){
    
    if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['categories']) && isset($_FILES['myimage']) && isset($_POST['text'])){
        
        $db = StaticConnection::getConnection();
             
        //добавление основных полей из формы
        $title = $_POST['title'];
        $description = $_POST['description'];                
        $id_categories = intval($_POST['categories']);
        $text = $_POST['text'];
        $user = $_SESSION['user']['id'];             
                
        $array = array('id_username' => $user ,'title' => $title, 'description' => $description, 'text' => $text, 'id_categories' => $id_categories);
        $sth = $db->prepare("INSERT INTO articles(id_username, title, description, text, id_categories) VALUES (:id_username, :title, :description, :text, :id_categories)");
        
        $sth->execute($array);

        //сохранение изображения в бд
        $imagename=$_FILES["myimage"]["name"];
        
        //Получаем содержимое изображения и добавляем к нему слеш            
        $imagetmp=addslashes(file_get_contents($_FILES['myimage']['tmp_name']));    
        
        $sth = $db->prepare("INSERT INTO images(image_tmp, image_name, recipe_picture_boolean, id_article) VALUES('$imagetmp','$imagename', 1, (SELECT id FROM articles ORDER BY ID DESC LIMIT 1))");
        $sth->execute();

        $x = 1;      
        do {

            $indigrient = $_POST['indigrient'.$x];
            $amount = $_POST['amount'.$x];                
            $measure = intval($_POST['measure'.$x]);

            $array = array('indigrient' => $indigrient,'amount' => $amount,'measure' => $measure);
            $sth = $db->prepare("INSERT INTO indigrients(indigrient, amount, id_article, id_measure) VALUES (:indigrient, :amount, (SELECT id FROM articles ORDER BY ID DESC LIMIT 1), :measure)");
            
            $sth->execute($array);

            $x = $x + 1;
        } while (isset($_POST['indigrient'.$x]) && isset($_POST['amount'.$x]) && isset($_POST['measure'.$x]));
        
        $y = 1;      
        do {
            
            $picturename=$_FILES['picture'.$y]['name'];
            
            //Получаем содержимое изображения и добавляем к нему слеш            
            $imagetmp=addslashes(file_get_contents($_FILES['picture'.$y]['tmp_name']));
        
            $db = StaticConnection::getConnection();
            $sth = $db->prepare("INSERT INTO images(image_tmp, image_name, recipe_picture_boolean, id_article) VALUES('$imagetmp','$picturename', 0, (SELECT id FROM articles ORDER BY ID DESC LIMIT 1))");
            $sth->execute();
            $y = $y + 1;
           
        } while (isset($_FILES['picture'.$y]));    
                
        $result = true;        
        }   
        

    if ($result) {
        echo "Успех. Информация занесена в базу данных";
    } 
}




//SELECT categories в выпадающий список addpost.php
function selectCategories(){

    $db = StaticConnection::getConnection();
    $sth = $db->prepare("SELECT DISTINCT * FROM categories");
    $sth->execute();            
    
    if ($sth->rowCount() > 0){
        while($article = $sth->fetch(PDO::FETCH_ASSOC)){ 
            ?>
            <option value="<?= $article['id']?>"><?= $article['name'] ?></option>
            <?php
        }
    };            
}



function cabinetPost(){
    $id_user = intval($_GET['user']);
    
    $db = StaticConnection::getConnection();
    $sth = $db->prepare("SELECT DISTINCT articles.id, title, views, categories.name 
    FROM articles             
    JOIN categories ON articles.id_categories = categories.id   
    JOIN users ON articles.id_username = users.id
    WHERE users.id = '$id_user'
    GROUP BY articles.id 
    ORDER BY articles.id DESC");
    $sth->execute();

    ?>
            <div class="field">
                
                <div class="field-id-article">
                    <p>ID</p>
                </div>                      
                <div class="field-title"> 
                    <p>Название</p> 
                </div>
                <div class="field-categories-name">
                    <p>Категория</p>
                </div> 
                <div class="field-view"> 
                    <p>Просмотры </p>
                </div>
                <div class="field-Button"> 
                    
                
                    
                </div>
            </div>
            <?php    

    if ($sth->rowCount() > 0){
        while($article = $sth->fetch(PDO::FETCH_ASSOC)){ 
            ?>
            <div class="field">

                <div class="field-id-article">
                    <p><?= $article['id'] ?> </p>
                </div>                      
                <div class="field-title"> 
                <a href="post.php?id_article=<?= $article['id'] ?>"><?= $article['title'] ?></a>
                </div>
                <div class="field-categories-name">
                    <p><?= $article['name'] ?></p>
                </div> 
                <div class="field-view"> 
                    <p><?= $article['views'] ?> </p>
                </div>
                <div class="field-Button"> 
                    <input class="editButton" type="button" value="Изменить"  />
                
                    <input class="deleteButton" type="button" value="Удалить"  />
                </div>
            </div>
            <?php             
        }     
    } else echo "Нет статей";  
}

