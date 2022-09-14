<?php
require_once 'StaticConnection.php';

function outputingr($article_id)
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
                                    
            $indigrient[]  = [
            'indigrient' => $indigrients['indigrient'],
            'amount' =>      $indigrients['amount'],
            ];      
        }
    }   return $indigrient;
}

//вывод статей на главную страницу index.php
function outputHome()
{
    
    $db = StaticConnection::getConnection();
    $sth = $db->prepare("SELECT DISTINCT articles.id, title, description, users.id AS id_user, users.full_name, views, date, categories.id AS categID, categories.name AS categName   
    FROM articles             
    JOIN categories ON articles.id_categories = categories.id   
    JOIN users ON articles.id_username = users.id
    GROUP BY articles.id 
    ORDER BY articles.id DESC");
    $sth->execute();

    if ($sth->rowCount() > 0){
        while($article = $sth->fetch(PDO::FETCH_ASSOC)){ 
            
            $id_article = $article['id'];

            $sthh = $db->prepare("SELECT images.id_article, images.image_name, images.image_tmp
                FROM images            
                WHERE images.id_article = $id_article AND recipe_picture_boolean = 1"); 
            $sthh->execute();

            $image = $sthh->fetch(PDO::FETCH_ASSOC);

            $valuecard [] =[
                'id' =>  $article['id'],
                'image' => $image ? base64_encode($image['image_tmp']) : base64_encode(""),
                'categID' => $article['categID'],
                'categName' => $article['categName'],
                'title' => $article['title'],
                'description' => $article['description'],
                'full_name' => $article['full_name'],
                'views' => $article['views'],
                'date' => $article['date'],
                'ingr' => outputingr($article['id']),
            ]; 
            $valuecard_json = $valuecard;      
        }             
         
    }    return json_encode($valuecard_json);  
}

echo outputHome();