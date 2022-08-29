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

            <div class="card-indigrients" style="display: none;">                 
                    <div class="card-indigrients-indigrient" >
                    <?= $indigrients['indigrient'] ?>
                    </div>

                    <div class="card-indigrients-amount" >
                    <?= $indigrients['amount'] ?> 
                    </div>                
            </div>              
            <?php            
        }
    }
}

//вывод статей на главную страницу index.php
function generationPost()
{
    
    $db = StaticConnection::getConnection();
    $sth = $db->prepare("SELECT DISTINCT articles.id, title, description, images.image_name, images.image_tmp, users.id AS id_user, users.full_name, views, categories.name 
    FROM articles             
    JOIN categories ON articles.id_categories = categories.id
    JOIN images ON articles.id_image = images.id
    JOIN users ON articles.id_username = users.id
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
                    <a href="autor.php?user=<?= $article['id_user'] ?>">
                        <p class="card-text-autor"><?= $article['full_name'] ?></p> 
                    </a>
                </div>                    
                <a href="post.php?id_article=<?= $article['id'] ?>">
                    <img class="card-text-picture" src="data:image/jpeg;base64, <?= base64_encode($article['image_tmp']) ?>">
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

function autorPost()
{
    $id_user = intval($_GET['user']);
    
    $db = StaticConnection::getConnection();
    $sth = $db->prepare("SELECT DISTINCT articles.id, title, description, images.image_name, images.image_tmp, users.id AS id_user, users.full_name, views, categories.name 
    FROM articles             
    JOIN categories ON articles.id_categories = categories.id
    JOIN images ON articles.id_image = images.id
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
                    <img class="card-text-picture" src="data:image/jpeg;base64, <?= base64_encode($article['image_tmp']) ?>">
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
    
    if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['categories']) && isset($_FILES['myimage']) && isset($_POST['text']) && isset($_POST['indigrient']) && isset($_POST['amount']) && isset($_POST['measure'])){
        
        //сохранение изображения в бд
        $imagename=$_FILES["myimage"]["name"];
        
        //Получаем содержимое изображения и добавляем к нему слеш            
        $imagetmp=addslashes(file_get_contents($_FILES['myimage']['tmp_name']));
    
        $db = StaticConnection::getConnection();
        $sth = $db->prepare("INSERT INTO images(image_tmp, image_name) VALUES('$imagetmp','$imagename')");
        $sth->execute();
             
        //добавление основных полей из формы
        $title = $_POST['title'];
        $description = $_POST['description'];                
        $id_categories = intval($_POST['categories']);
        $text = $_POST['text'];
        $user = $_SESSION['user']['id'];             
                
        $array = array('id_username' => $user ,'title' => $title, 'description' => $description, 'text' => $text, 'id_categories' => $id_categories);
        $sth = $db->prepare("INSERT INTO articles(id_username, title, description, id_image, text, id_categories) VALUES (:id_username, :title, :description, (SELECT id FROM images ORDER BY ID DESC LIMIT 1), :text, :id_categories)");
        
        $sth->execute($array);

        //добавление ингредиентов из формы
        $indigrient = $_POST['indigrient'];
        $amount = $_POST['amount'];                
        $measure = intval($_POST['measure']);

        $array = array('indigrient' => $indigrient,'amount' => $amount,'measure' => $measure);
        $sth = $db->prepare("INSERT INTO indigrients(indigrient, amount, id_article, id_measure) VALUES (:indigrient, :amount, (SELECT id FROM articles ORDER BY ID DESC LIMIT 1), :measure)");
        
        $sth->execute($array);
                
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
//SELECT measure в выпадающий список addpost.php
function selectMeasure(){

    $db = StaticConnection::getConnection();
    $sth = $db->prepare("SELECT DISTINCT * FROM measures");
    $sth->execute();            
    
    if ($sth->rowCount() > 0){
        while($article = $sth->fetch(PDO::FETCH_ASSOC)){ 
            ?>
            <option value="<?= $article['id']?>"><?= $article['measure'] ?></option>
            <?php
        }
    };            
}