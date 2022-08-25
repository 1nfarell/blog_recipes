<?php

require_once 'StaticConnection.php';
        //вывод статей на главную страницу
        function generationPost()
        {
            $db = StaticConnection::getConnection();
            $sth = $db->prepare("SELECT DISTINCT articles.id, title, description, picture, views, categories.name 
            FROM articles             
            JOIN categories ON articles.id_categories = categories.id
            GROUP BY articles.id;");
            
            // запрос с ингредиентами
            // SELECT DISTINCT articles.id, title, description, picture, views, GROUP_CONCAT(CONCAT( indigrient,': ', amount), CONCAT(' ', measure) SEPARATOR ', ') AS indigrient, categories.name 
            // FROM articles 
            // JOIN indigrients ON articles.id = indigrients.id_article 
            // JOIN categories ON articles.id_categories = categories.id
            // GROUP BY articles.id;


            $sth->execute();
            

            if ($sth->rowCount() > 0){
                while($article = $sth->fetch(PDO::FETCH_ASSOC)){ 
                    ?>
                    <div class="main-field">
                            <p class="card-id">В категории: <?= $article['name'] ?></p>

                            <img class="card-text-picture" src="data:image/jpeg;base64, <?= base64_encode($article['picture']) ?>">

                            <h3 class="card-title" ><a href="post.php?id_article=<?= $article['id'] ?>"><?= $article['title'] ?></a></h3>
                            
                            <p class="card-text-description"><?= mb_substr($article['description'], 0, 158, 'UTF-8') ?></p>
                            
                            
                            <p class="card-text-indigrients"> Необходимые ингредиенты: </br> </p> 
                            
                            <?php                             
                                $indigrients=explode(", ", $article['indigrient']);
                                
                                foreach($indigrients as &$value){
                                    echo "<p class=\"card-text-indigrients-description\">".$value."<br />"."</p>";
                                }
                            ?>
                            
                            <p class="card-text-views"> Просмотров: <?=$article['views']?></p>
                    </div>
                    <?php 
                } 
            } else echo "Нет статей";
           
        }
        //добавление полей из формы в бд
        function addPost(){

            if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['img_upload']) && isset($_POST['text'])  && isset($_POST['categories'])){
                $title = $_POST['title'];
                $description = $_POST['description'];
                $text = $_POST['text'];
                $picture = $_POST['img_upload'];
                $id_categories = intval($_POST['categories']);

                
                
                
                $db = StaticConnection::getConnection();
                
                $array = array('title' => $title, 'description' => $description, 'text' => $text, 'picture' => $picture, 'id_categories' => $id_categories);
                
                $sth = $db->prepare("INSERT INTO articles(title, description, text, picture, id_categories) VALUES (:title, :description, :text, :picture, :id_categories)");
                
                $sth->execute($array);
                
                $result = true;
                
                
                
            } echo mb_detect_encoding($_POST['img_upload']);

            
            if ($result) {
                echo "Успех. Информация занесена в базу данных";
            } 
        }

        //SELECT categories в выпадающий список 
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