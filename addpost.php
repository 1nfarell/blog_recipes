<?php

session_start();
    
if (!$_SESSION['user']) {
    header('Location: /');
};
include 'vendor/generator.php';

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить рецепт</title>

    <link rel="stylesheet" href="assets/css/post.css">
    <link href = "assets/fonts/Mont/stylesheet.css" rel = "stylesheet" type = "text/css" />
    
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;900&display=swap" rel="stylesheet">

    <script src="assets/js/jquery-3.4.1.min.js"></script>
    
</head>

<body>
<div class="container">
<header>
        <!-- header -->
        <div class="header">
            <div class="header-up">
                <div class="header-left">
                    <img class="logo" src="images\logo-kitchen-food.png">
                    <div class="logo-description">
                        <a href="index.php"><h1>Рецепты</h1></a>
                    </div>
                    
                </div>                   
                <div class="header-right">
                    <!-- Профиль -->
                    <div class="header-right-form">
                        <form>
                            <p><?= $_SESSION['user']['full_name'] ?></p>  
                        </form>
                    </div>
                    <div class="header-right-form-button">                    
                    <?php if(isset($_SESSION['user'])): ?> 
                        <a href="cabinet.php">Личный кабинет</a>
                        <a href="vendor/logout.php">Выход</a>
                    <?php else: ?> 
                        <a href="register.php">Регистрация</a>
                        <a href="login.php">Вход</a>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="header-nav"> 
                    
                    <div class="header-nav-1">
                        <a href="/index.php">Главная</a>
                    </div>
            </div> 
        </div>        
</header>   
    

    <!-- main -->
<div class="main">        
    <div class="main-center">
        

            <form class="formAdd" name="formAddPost" method="POST" enctype="multipart/form-data"   action="">
                <p>Выберите категорию блюда</p> 
                <select name="categories"> 
                    <option disabled selected></option>
                    <?php selectCategories(); ?>
                </select>
                
                <p>Введите название блюда</p> 
                <input name="title" type="text" placeholder="Название рецепта" style="width:100%; resize: none;"/>           
                </br>               
 
                <p>Придумайте краткое описание блюда, оно будет отображаться на главной странице</p>                
                <textarea name="description" type="text" placeholder="Краткое описание" style="width:100%; height:60px; resize: none;"></textarea> 
                </br> 

                <p>Выберите картинку, она тоже будет отображаться на главной странице</p>
                <input type="file" name="myimage" accept="image/jpeg"/>

               

                <input id="INeedMore" type="button" value="Добавить поле" style="margin-top:15px;"/>
                <div id="Wrapper_add" ></div>              
                

                
                <div name="input-recept">
                    <div name="input-recept-description">
                        <p>Напишите рецепт</p>
                        <textarea name="text"  type="text" placeholder="Опишите процесс приготовления.." style="width:100%; height:400px; resize: none;"></textarea>
                    </div> 

                    <p>Добавьте картинки, которые илюстрируют процесс приготовления</p>
                    <input id="INeedMoreImages" type="button" value="Добавить картинку" style="margin-top:15px;"/>
                    <div id="Wrapper_add_image"></div>
                </div>
                
                <input type="submit" value="Сохранить рецепт"  />                 
                <div id="demo"></div>
            </form>            
                                
            <?php addPost();?>                    
    </div>
</div>


<!-- footer -->
<footer>
    <div class="footer">
        <div class="footer-center"> 
            <p>© 2022 Максим Бекецкий</p> 
            <a href="/about.php">Обо мне</a>                                       
        </div>           
    </div>  
</footer>
</div>

<script src="assets/js/jquery-3.4.1.min.js"></script>
<script src="assets/js/main.js"></script>
<script type="text/javascript">
   
    $(document).ready(function() {
        var MaxInputs = 15;
        var Wrap = $("#Wrapper_add");
        var AddButton = $("#INeedMore");
        var x = Wrap.length;
        var FieldCount = 0;
        let SelectData = [];

        $(document).ready(function() {     
            let dataForm = $(this).serialize();
            $.ajax({
                url: 'vendor/selectMeashure.php',
                method: 'GET',
                data: dataForm,                   
                success: function(data){                
                    SelectData = JSON.parse(data);
                    console.log(SelectData); 
                }, 
                error: function(...data){                
                    console.log(data);
                    console.log(SelectData);
                }                
            })            
        });        
        
        $(AddButton).click(function(e) //функция добавления нового поля
        {
            if (x <= MaxInputs) //проверяем на максимальное кол-во
            {
                FieldCount++;
                //добавляем поле
                $(Wrap).append('<div id="'+x+'" name="wrapper"><input id="'+x+'" class="indigrient" name="indigrient'+x+'"  type="text" placeholder="Ингредиент" style="width:60%;"/><input id="'+x+'" name="amount'+x+'" type="text" placeholder="Кол-во" style="width:20%;"/><select id="'+x+'" name="measure'+x+'"><option disabled selected></option>'+SelectData.reduce((previousValue, currentValue) => previousValue + `<option value="${currentValue['id']}"> ${currentValue['value']}</option>`, '')+' </select><input class="removeclass" type="button" value="Удалить поле"/> </div>');
                x++; //приращение текстового поля
            }
            return false;
        });

        $("body").on("click", ".removeclass", function(e) { //удаление поля
            if (x > 1) {
                $(this).parent('div').remove(); //удалить блок с полем
                x--; //уменьшаем номер текстового поля
            }
            return false;
        })
    });
    $(document).ready(function() {
        var MaxInputs = 5;
        var Wrap = $("#Wrapper_add_image");
        var AddButton = $("#INeedMoreImages");
        var y = Wrap.length;
        var FieldCount = 0;
        
        $(AddButton).click(function(e) //функция добавления нового поля
        {
            if (y <= MaxInputs) //проверяем на максимальное кол-во
            {
                FieldCount++;
                //добавляем поле
                $(Wrap).append('<div id="'+y+'" name="wrapperImage"><input id="'+y+'" name="picture'+y+'" type="file" accept="image/jpeg"/><input class="removeclassimage" type="button" value="Удалить поле"/> </div>');
                y++; //приращение текстового поля
            }
            return false;
        });

        $("body").on("click", ".removeclassimage", function(e) { //удаление поля
            if (y > 1) {
                $(this).parent('div').remove(); //удалить блок с полем
                y--; //уменьшаем номер текстового поля
            }
            return false;
        })
    });
</script>
</body>
</html>