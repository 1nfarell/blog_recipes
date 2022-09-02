<?php function deletePost(){
    $db = StaticConnection::getConnection();
    $sth = $db->prepare("DELETE FROM articles, comments, images, indigrients
    WHERE id_article = '$article_id'");
    $sth->execute();            
}

echo deletePost();