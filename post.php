<?php

session_start();
    
include 'vendor/outputPost.php';

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Рецепт</title>

    <link rel="stylesheet" href="assets/css/post.css">
    <link href = "assets/fonts/Mont/stylesheet.css" rel = "stylesheet" type = "text/css" />
    
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;900&display=swap" rel="stylesheet">
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
                <div class="header-nav">
                    <div class="header-nav-1">
                        <?php if(isset($_SESSION['user'])): ?>
                            <a href="/addpost.php">Добавить рецепт</a>
                        <?php else: ?>
                            <a href="/register.php">Добавить рецепт</a>
                        <?php endif; ?>
                    </div>
                </div>                
            </div>       
        </div>         
</header>  
    <!-- main -->
<div class="main">        
    <div class="main-center">
        <?php generationOutput(); ?>                              
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
<script type="text/javascript">
    function setCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
    }
    function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
    }
    function delCookie(name) {
    setCookie(name,"",-1);
    }    
    
    if (getCookie("counter")) {
    var count=getCookie("counter")+1;
    setCookie("counter",count,365);
    } else {
    setCookie("counter",1,365);
    }

    console.log("Вы зашли на эту страницу "+getCookie("counter"));
    
</script>
</body>
</html>