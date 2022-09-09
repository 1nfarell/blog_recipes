<?php
require_once 'StaticConnection.php';
session_start();

function cabinetPost(){
    $id_user = $_SESSION['user']['id'];
    
    $db = StaticConnection::getConnection();
    $sth = $db->prepare("SELECT DISTINCT articles.id, title, views, categories.name 
    FROM articles             
    JOIN categories ON articles.id_categories = categories.id   
    JOIN users ON articles.id_username = users.id
    WHERE users.id = '$id_user'
    GROUP BY articles.id 
    ORDER BY articles.id DESC");
    $sth->execute();

    if ($sth->rowCount() > 0){
        while($article = $sth->fetch(PDO::FETCH_ASSOC)){ 
            $valuearticle [] =[
                'id' =>  $article['id'],
                'name' => $article['name'],
                'title' => $article['title'],
                'views' => $article['views'],
            ]; 
            
            $valuearticle_json = $valuearticle;
        }      
    }
    
    return json_encode($valuearticle_json);
}

echo cabinetPost();