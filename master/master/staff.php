
<?php
include("main.php");
$cl=new main();
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
<script src="../jquery-3-7-1.js"></script>
  <!-- <script src="../assets/js/color-modes.js"></script> -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Страница с сотрудниками компьютерного мастера">
    <meta name="keywords" content="Мастер,компьютерный мастер,какой мастер">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="author" content="Якунин Дмитрий">
    <meta name="generator" content="Hugo 0.118.2">
    <meta name="generator" content="Hugo 0.118.2">
    <title>Blog Template · Bootstrap v5.3</title>
    <link rel="stylesheet" href="../css@3.css">
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    span{
      color:black;
    }
    body{
      background:#DBDFE6;
    }
    section{
      padding:100px 100px;
      height:100vh;
    }
    header a:hover{
      background-color:rgba(25,20,50,0.4);
      transition: all 0.3s ease-out
    }
    header a{
      color:white;
      text-decoration:none;
      padding:10px;
      margin:20px;
      border-radius:30px;
      background-color:rgba(25,20,50,0.8);
    }
    header{
      background:#0C5DA5;
      display:flex;
      align-items:center;
      justify-content:center;
      width:100%;
      position:absolute;
      height:60px;
    }
    .main{
      text-align:center;
      display:block;
      width:100%;
    }
    .menu_staff img{
      border-radius:80px;
      width:300px;
    }
    .menu_staff span{
      font-size:22px;
    }
    .menu_staff{
      border-radius:10px;
      padding:40px;
      background:#A4BBE0;
      text-align:center;
      width:400px;
      margin:50px;
    }
    .staff{
      display:flex;
      align-items:center;
      justify-content:center;
      width:100%;
    }
    .info img{
      width:400px;
    }
  </style>
</head>
<body class="body">
  <header>
    <a href="index.php" style="background-color:rgba(25,20,50,0.5);">Главная</a>
    <a href="orders.php">Услуги</a>
    <a href="profile.php">Профиль</a>
  </header>
  <section>
      <div class="main">
          <?php
              $cl->printMasters();
          ?>
      </div>
  </section>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
