<?php
require_once 'StaticConnection.php';
//SELECT measure в выпадающий список addpost.php
function selectMeasure(){

    $db = StaticConnection::getConnection();
    $sth = $db->prepare("SELECT DISTINCT * FROM measures");
    $sth->execute();            
    
    if ($sth->rowCount() > 0){
        while($article = $sth->fetch(PDO::FETCH_ASSOC)){ 
           
            $measure[] = [
                'id' => intval($article['id']),
                'value' => $article['measure']   
            ]; 
            $measure_json = $measure;
            
        }
    }; 
    return json_encode($measure_json);     
}
echo selectMeasure();