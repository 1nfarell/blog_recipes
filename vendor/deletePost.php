<?php 
require_once 'StaticConnection.php';

function deletePost(){
    $article_id = $_GET['article_id'];
    $db = StaticConnection::getConnection();
    $sth = $db->prepare("DELETE FROM articles
    WHERE id = '$article_id'");
    $sth->execute();            
}

echo deletePost();