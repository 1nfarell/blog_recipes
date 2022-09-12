<?php

session_start();
    
if (!$_SESSION['user']) {
    header('Location: /login.php');
};
include 'vendor/generator.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>

    <link rel="stylesheet" href="assets/css/addpost.css">
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
                    <div class="header-right-form">
                        <form>
                            <p><?= $_SESSION['user']['full_name'] ?></p>
                                                
                        </form>
                    </div>
                    <div class="header-right-form-button">                    
                    <?php if(isset($_SESSION['user'])): ?> 
                        <a href="vendor/logout.php">Выход</a>
                    <?php endif; ?>
                    </div>
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
         
</header>  

   

    <!-- main -->
<div class="cabinet-main">        
    <div class="feild-center" id="field-center">
         
                                  
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
<script src="assets/js/cabinet.js"></script>


</body>

          
            

</html>