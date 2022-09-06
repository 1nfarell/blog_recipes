<?php
    session_start();
    if ($_SESSION['user']) {
        header('Location: /index.php');
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/auth.css">
    
    <link href = "assets/fonts/Mont/stylesheet.css" rel = "stylesheet" type = "text/css" />
</head>
<body>
<div class="container">
<!-- header -->
<header>
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
                        <a href="cabinet.php?user=<?= $_SESSION['user']['id'] ?>">Личный кабинет</a> 
                        <a href="vendor/logout.php">Выход</a>
                    <?php else: ?> 
                        <a href="login.php">У вас уже есть аккаунт? - Войти</a>
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


<div class="cards"> 
    <div class="card"> 
        <img class="card-image" src="images\title-image.png">     
    </div>  
    <div class="card"> 
        <p>test</p>   
    </div>
      
</div>
    <!-- Форма регистрации -->
<div class="main">  
    <form>
        <label class="lbl-registr">Регистрация</label>
        <label>ФИО</label>
        <input type="text" name="full_name" placeholder="Введите свое полное имя">
        <label>Логин</label>
        <input type="text" name="login" placeholder="Введите свой логин">
        <label>Почта</label>
        <input type="email" name="email" placeholder="Введите адрес своей почты">
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль">
        <label>Подтверждение пароля</label>
        <input type="password" name="password_confirm" placeholder="Подтвердите пароль">
        <button type="submit" class="register-btn">Зарегистрироваться</button>
        <p>
            У вас уже есть аккаунт? - <a class="ref" href="/login.php">авторизируйтесь</a>!
        </p>
        <p class="msg none"></p>
    </form>
    
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
</body>
</html>