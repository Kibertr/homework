<?php
include("main.php");
$cl=new main();
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
<script src="../jquery-3.7.1.js"></script>
  <!-- <script src="../assets/js/color-modes.js"></script> -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="страница с профилем сайта компьютерного мастера">
    <meta name="keywords" content="профиль,зарегистрироваться,войти,сайт регистрации">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="author" content="Якунин Дмитрий">
    <meta name="generator" content="Hugo 0.118.2">
    <title>Страница пррофиля</title>
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
    .profile_links a{
      margin:10px;
      padding:10px;
      border-radius:20px;
      text-decoration:none;
      color:white;
      background:rgba(25,20,50,0.8);
    }
    .profile_links{
      height:100%;
      width:100%;
      display:flex;
      align-items:center;
      justify-content:center;
    }
    .reg_css{
      background:#0C5DA5;
      padding:20px;
      border-radius:20px;
    }
    .reg{
      height:100%;
      width:100%;
      display:flex;
      text-align:center;
      align-items:center;
      justify-content:center;

    }
    .input_reg input{
      border-radius:20px;
      border:none;
      margin:10px;
      padding:5px;
    }
    .input_reg{
      width:100%;
      text-align:center;
    }
    .button:hover{
      background-color:rgba(25,20,50,0.4);
      transition: all 0.3s ease-out
    }
    .button{
      color:white;
      background:rgba(55,20,120,0.8);
      border-radius:20px;
      border:none;
      margin:10px;
      padding:10px;
    }
  </style>
</head>
<body class="body">
  <header>
    <a href="index.php" >Главная</a>
    <a href="orders.php">Услуги</a>
    <a href="profile.php" style="background-color:rgba(25,20,50,0.5);">Профиль</a>
    <a href="support.php">Поддержка</a>
  </header>
<?php
print_r($_COOKIE);
    if(!empty($_COOKIE['mail']) && !empty($_COOKIE['pass'])){?>
      <section>
        <div class="main_data">
          <span>Вы вошли под именем <?php echo $_COOKIE['name'];?></span><a href="?exit">Выйти</a>
          <div>

          </div>
        </div>
      </section><?php
    }
    else{
      if(isset($_GET['reg']) || isset($_GET['log'])){
        if(isset($_GET['reg'])){?>
          <section>
          <div id="errors" style="text-align:center"></div>
            <div class="reg">
              
              <div class="reg_css">
                <div class="input_reg">
                  <input type="text" id="reg_name" placeholder="ФИО">
                  <input type="text" id="reg_address" placeholder="Адрес">
                  <input type="text" id="reg_telephone" placeholder="телефон">
                  <input type="text" id="reg_mail" placeholder="Почта">
                  <input type="text" id="reg_pass" placeholder="Пароль">
                </div>
                <div >
                  <button id="reg_button" class="button">Регистрация</button>
                </div>
              </div>
            </div>
            <script>
                $("#reg_button").on("click",function(){
                    if($("#reg_name").val()!="" && $("#reg_telephone").val()!="" && $("#reg_address").val()!="" && $("#reg_pass").val()!="" && $("#reg_mail").val()!=""){
                        let name =$("#reg_name").val();
                        let telephone =$("#reg_telephone").val();
                        let address =$("#reg_address").val();
                        let pass = $("#reg_pass").val();
                        let mail = $("#reg_mail").val();
                        $.ajax({
                            url:'http://localhost/yakunin/master/main.php',
                            method:'post',
                            data:{reg: "",name: name, mail: mail,telephone:telephone,address: address,pass: pass},
                            success: function(){
                                $("#errors").html("");
                                $("#reg_name").val("");
                                $("#reg_telephone").val("");
                                $("#reg_address").val("");
                                $("#reg_pass").val("");
                                $("#reg_mail").val("");
                                $("#errors").load("main.php?error");
                            }
                        });
                    }else{
                        $("#errors").html("<span style='color:red;font-size:30px;'>Необходимо заполнить все поля</span>");
                    }
                });

            </script>
          </section><?php
        }
        if(isset($_GET['log'])){?>
          <section>
          <div class="reg">
              
              <div class="reg_css">
                <div class="input_reg">
                  <input type="text" id="log_mail" placeholder="Почта">
                  <input type="text" id="log_pass" placeholder="Пароль">
                </div>
                <div >
                  <button id="log_button" class="button">Вход</button>
                </div>
              </div>
            </div>
            <script>
                $("#log_button").on("click",function(){
                  if($("#log_mail").val()!="" && $("#log_pass").val()!=""){
                        let pass = $("#log_pass").val();
                        let mail = $("#log_mail").val();
                        $.ajax({
                            url:'http://localhost/yakunin/master/main.php',
                            method:'post',
                            data:{log: "",pass: pass, mail: mail},
                            success: function(){
                              $("#errors").load("main.php?error");
                            }
                        });
                    }else{
                        $("#errors").html("<span style='color:red;font-size:30px;'>Необходимо заполнить все поля</span>");
                    }
                });
            </script>
          </section>
          <?php
        }
      }
      else{ ?>
        <section>
          <div class="profile_links">
            <div>
              <a href="?log">Войти</a>
              <a href="?reg">Регистрация</a>
            </div>
          </div>
        </section><?php
      }
    }
  ?>

<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
