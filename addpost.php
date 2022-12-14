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

    <link rel="stylesheet" href="assets/css/addpost.css">
    
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
                    <div class="header-profile">
                        <div class="header-right-form">
                            <form>
                                <p><?= $_SESSION['user']['full_name'] ?></p>  
                            </form>
                        </div>
                        <div class="header-right-form-button">                    
                        <?php if(isset($_SESSION['user'])): ?> 
                            <a href="cabinet.php?user=<?= $_SESSION['user']['id'] ?>">Личный кабинет</a>
                            <a href="vendor/logout.php">Выход</a>
                        <?php else: ?> 
                            <a href="register.php">Регистрация</a>
                            <a href="login.php">Вход</a>
                        <?php endif; ?>
                        </div>
                    </div>    
                </div>
            </div>            
        </div>        
</header>  
<div class="cards-auth"> 
    <div class="card-auth"> 
        <img class="card-image" src="images\title-image.svg">     
    </div>       
</div>
    <!-- main -->
<div class="main">        
    <div class="main-center">
        <p style="padding-bottom: 20px; font-size: 18px; color: #5b5b5b;">Добавить рецепт</p>
        <form class="formAdd" name="formAddPost" method="POST" enctype="multipart/form-data"   action="">
            <div class="CategoriesArea">
                <p class="formP">Выберите категорию</p> 
                <select class="selectCategories" name="categories" required> 
                    <option disabled selected></option>
                    <?php selectCategories(); ?>
                </select>
            </div>
            <div class="nameReceptArea">        
                <p class="formP">Название рецепта</p> 
                <input  class="nameRecept" name="title" type="text" placeholder="Название рецепта" maxlength="90" pattern="^[А-Яа-яЁё\s]+$" required/>           
            </div>             
            <div class="descriptionArea">
                <p class="formP">Краткое описание</p>                
                <textarea class="descriptionRecept" name="description" type="text" placeholder="Краткое описание" maxlength="1000"  required></textarea> 
            </div>
            <div class="imageReceptArea">
                <p class="formP">Картинка для обложки</p>
                <label class="custom-file-upload">
                <input class="imageRecept" type="file" name="myimage" accept="image/jpeg" required/>Загрузить
                </label>
            </div>
            <div class="add_indigrients">
                <div class="add_indig_button">
                    <p class="formP">Необходимые ингредиенты</p>        
                    <input class="add_button" id="INeedMore" type="button" value="Добавить поле"/>
                </div>
                <div class="area_add_indigrients" id="Wrapper_add" >
                    <!-- поля с ингредиентами -->
                </div> 
            </div>  
            <div class="inputRecept"> 
                <div class="inputReceptPicture">
                    <div class="add_picture_button">
                        <p class="formP">Напишите рецепт. Процесс приготовления разбейте по пунктам и добавьте изображения.</p>
                        <input class="add_button_picture" id="INeedMoreImages" type="button" value="Добавить поле"/> 
                    </div>
                    <div class="inputReceptDescription" id="Wrapper_add_text">  <!-- поля с текстом -->  </div>
                </div>
            </div>
            <input class="saveButton" id="saveButton" type="submit" value="Сохранить рецепт"  />  
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
                    $(Wrap).append('<div class="wrapper_indigrients" name="wrapper"><input id="indigrient'+x+'"  class="indigrient" name="indigrient'+x+'"  type="text" placeholder="Ингредиент" maxlength="40" style="width:60%;" required pattern="^[А-Яа-яЁё\\s]+$"/><input  class="amount" name="amount'+x+'" type="text" placeholder="Кол-во" maxlength="4" style="width:20%;" required pattern="^\\d+([,.]\\d){0,1}\\d*$"/><select class="measure" required name="measure'+x+'"><option disabled selected></option>'+SelectData.reduce((previousValue, currentValue) => previousValue + `<option value="${currentValue['id']}"> ${currentValue['value']}</option>`, '')+' </select> </div>');
                    x++; 
                }, 
                error: function(...data){    
                }                
            })            
        });     
           
          
             
        $(AddButton).click(function(e) //функция добавления нового поля
        {
            if (x <= MaxInputs) //проверяем на максимальное кол-во
            {   $(".removeclass").hide();
                FieldCount++;
                //добавляем поле
                $(Wrap).append('<div  class="wrapper_indigrients" name="wrapper"><input id="indigrient'+x+'"  class="indigrient" name="indigrient'+x+'"  type="text" placeholder="Ингредиент" maxlength="40" style="width:60%;" required pattern="^[А-Яа-яЁё\\s]+$"/><input  class="amount" name="amount'+x+'" type="text" placeholder="Кол-во" maxlength="4" style="width:20%;" required pattern="^\\d+([,.]\\d){0,1}\\d*$"/><select class="measure" required name="measure'+x+'"><option disabled selected></option>'+SelectData.reduce((previousValue, currentValue) => previousValue + `<option value="${currentValue['id']}"> ${currentValue['value']}</option>`, '')+' </select><input id="removeclass'+x+'" class="removeclass" type="button" value="Удалить"/> </div>');
                
                x++; //приращение текстового поля
            }
            return false;
        });
        
        $("body").on("click", ".removeclass", function(e) { //удаление поля
            if (x > 2) {
                var id_btnRemove = "#removeclass";                
                console.log(x);
                $(this).parent('div').remove(); //удалить блок с полем
                x--; //уменьшаем номер текстового поля
                if (x > 2){
                id_btnRemoveCount = id_btnRemove + (x - 1);
                $(id_btnRemoveCount).show()};   
            }
            return false;
        })
    });
    $(document).ready(function() {
        var MaxInputs = 5;
        var Wrap = $("#Wrapper_add_image");        
        var Wraptext = $("#Wrapper_add_text");
        var AddButton = $("#INeedMoreImages");    
        let y = Wrap.length;
        var FieldCount = 0;
        let count = 1;
        
        
        let el = $('<div id="wrapper_Text'+y+'"  class="wrapper_Text" name="wrapper_Text">  <div class="text"> <p class="formP"> Пункт №'+(count)+'</p> <textarea class="textRecept" name="text'+y+'"  type="text" placeholder="Опишите процесс приготовления.." maxlength="500" required></textarea> </div></div> ');
                let buttons = $('<div class="area_add_picture" id="Wrapper_add_image"><div  class="wrapper_Image" name="wrapperImage"> <p class="formP">Прикрепите изображение</p> <label class="custom-file-upload"><input  class="addpicture" name="picture'+y+'" type="file" accept="image/jpeg" required/>Загрузить</label> </div><!-- поля с картинками --> </div>');
                Wraptext = $("#Wrapper_add_text");
                $(Wraptext).append(el);
                el.append(buttons);
        y++;
        count++;
        $(AddButton).click(function(e) //функция добавления нового поля
        {
            if (y <= MaxInputs) //проверяем на максимальное кол-во
            {   $(".removeclassimage").hide();    
                
                FieldCount++;
                //добавляем поле
                let el = $('<div id="wrapper_Text'+y+'"  class="wrapper_Text" name="wrapper_Text">  <div class="text"> <p class="formP"> Пункт №'+(count)+'</p> <textarea class="textRecept" name="text'+y+'"  type="text" placeholder="Опишите процесс приготовления.." maxlength="500" required></textarea> </div></div> ');
                let buttons = $('<div class="area_add_picture" id="Wrapper_add_image"><div  class="wrapper_Image" name="wrapperImage"> <p class="formP">Прикрепите изображение</p> <label class="custom-file-upload"><input  class="addpicture" name="picture'+y+'" type="file" accept="image/jpeg" required/>Загрузить</label><input id="removeclassimage'+y+'" class="removeclassimage" type="button" value="Удалить поле"/> </div><!-- поля с картинками --> </div>');
                Wraptext = $("#Wrapper_add_text");
                $(Wraptext).append(el);
                el.append(buttons);
                count++;
                y++; //приращение текстового поля
                
                buttons.on("click", '.removeclassimage', function(e) { 
                    var id_btnRemoveImage = "#removeclassimage";
                    //удаление поля
                    buttons.remove();
                    count--;
                    el.remove();
                    y--;
                    if (y > 1){
                    id_btnRemoveImageCount = id_btnRemoveImage + (y - 1);
                    $(id_btnRemoveImageCount).show();
                    }
                });
            }
            return false;
        });
    });   
</script>
</body>
</html>