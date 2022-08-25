<?php

session_start();
    


include 'vendor/generator.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Главная страница</title>
    <link rel="stylesheet" href="assets/css/profile.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;900&display=swap" rel="stylesheet">
</head>
<body>
<!-- header -->
<header>
    <div class="header">
        <div class="header-left">
            <img class="logo" src="images\logo-kitchen-food.png">
            <div class="logo-description">
                <a href="index.php"><h1>Рецепты</h1></a>
            </div>
        </div>
        
        <div class="header-center"> 
            
                    
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
        <div class="header-below">
            <div class="header-below-center"> 
                <div class="header-below-center-1">
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
        <?php
            
            generationPost();
        ?>
    </div>
    
</div>

<!-- footer -->
<footer>
    <div class="footer">
        <div class="footer-right"> 
            <p>© 2022 Максим Бекецкий</p>                                        
        </div>           
    </div>  
</footer>
</body>
</html>