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
    <meta name="description" content="главная страница сайта компьютерного мастера">
    <meta name="keywords" content="Мастер,Компьютер,компьютерный мастер,сайт мастера,сломанный компьютер,обновить ПО">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="author" content="Якунин Дмитрий">
    <meta name="generator" content="Hugo 0.118.2">
    <title>Компьютерный мастер</title>
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
    .about div{
      margin-bottom:200px;
    }
    .about span{
      font-size:20px;
    }
    .footer{
      background:rgba(25,20,50,0.5);
      width:100%;
      height:100px;
    }
    ul {list-style-type: none
    }
    .dop_info{
      font-size:20px;
    }
    .questions div{
      margin:30px;
    }
    .questions{
      text-align:center;
    }
    .staff_div img{
      width:200px;
    }
    .staff_div{
      text-align:center;
      max-height:500px;
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
  </style>
</head>
<body class="body">
  <header>
    <a href="index.php" style="background-color:rgba(25,20,50,0.5);">Главная</a>
    <a href="orders.php">Услуги</a>
    <a href="profile.php">Профиль</a>
    <a href="support.php">Поддержка</a>
  </header>
  <section>
    <div class="info">
      <div style="text-align:center">
        <div class="about">
          <div>
            <span style="font-size:30px;">Наша компания предоставяет <u>широкий</u> перечень услуг <u>качественного</u> ремонта компьютерной техники:</span>
            <ul  style="margin-top:20px;">
            <?php
            $array = $cl->getServicesName();
            foreach($array as $key=>$val){
              echo '<li><a href="orders.php?order='.$val['name'].'"><span>'.$val['name'].'</a></span></li>';
            }
            ?>
            </ul>
          </div>
          <div>
            <span>Работаем по всей <u>России</u> и не только!</span>
            <img src="img/any/russia.jpg" style="height:400px;">
          </div>
        </div>
      </div>

  </section>
  <section>
    <div class="staff_div">
      <span><h1>Наши лучшие сотрудники</h1></span>
    <?php
      $array = $cl->printBestMasters();
    ?>
    <div>
      <a href="staff.php">Все сотрудники</a>
    </div>
    </div>
  </section>
  <section>
    <div class="questions">
      <div>
      <span><h1>сколько стоят наши услуги?</h1></span>
      <span class="dop_info">Стоимость услуги зависит от типа работ ознакомиться можно <a href="orders.php">тут</a></span>
      </div>
      <div>
      <span  class="dop_info"><h1>Работаете ли в моем городе?</h1></span>
      <span>Работаем по всей россии, если нет ответа в вашем городе, свяжитесь с поддержкой</span>
      </div>
      <div>
        <span  class="dop_info"><h1>Что делать если сотрудник выполнил работу не полностью?</h1></span>
        <span>При любых вопросах или жалобах рекомендуем связаться с поддержкой</span>
      </div>
    </div>
  </section>
    <div class="footer">
      <div style="text-align:center">
        <b><span>Связь с нами</span></b>
        <ul>
          <li><span>master@mail.ru</span></li>
          <li><span>8 999 777 66 55</span></li>
        </ul>
      <div>
    <div>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
