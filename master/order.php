<?php
session_start();
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
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.118.2">
    <title>Blog Template · Bootstrap v5.3</title>
    <link rel="stylesheet" href="../css@3.css">
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    section{
      padding:100px 100px;
      height:100vh;
    }
    body{
      background:#DBDFE6;
    }
    header a:hover{
      background-color:rgba(25,20,50,0.5);
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
    .orders_type button{
        padding:10px;
        border-radius:25px;
        font-size:30px;
    }
    .orders_type{
        text-align:center;
    }
    .modal_content input{
        float:left;
        margin:10px;
    }
    .modal_content{
        text-align:center;
        padding:50px;
        border-radius:50px;
        height:400px;
        width:600px;
        background:#DBDFE6;
    }
    .modal{
        display: none;
        align-items:center;
        justify-content:center;
        background-color: rgba(0,0,0,0.5);
        }
    .modal_header{
        width: 20px;
        height:20px;
        float:right;
        font-size: 30px;
        font-weight: bold;
    }
    .modal_settings{
        display: inline-block;
        padding-left:40px;
        padding-top:20px;
    }
  </style>
</head>
<body class="body">
<header>
<a href="index.php" >Главная</a>
<a href="orders.php" style="background-color:rgba(25,20,50,0.5);">Услуги</a>
</header>
    <div id="home_order_modal" class="modal">
        <div class="modal_content">
        <span id="errors"></span>
            <div class="modal_settings">
                    <div style="width:100%">
                        <select id="home_order_modal_select">
                            <option>Выбрать услугу</option>
                            <?php
                            $cl->printServicesName();
                            ?>
                        </select>
                    </div>
                    <input type="text" id="home_order_modal_name" placeholder="Фио">
                    <input type="text" id="home_order_modal_mail" placeholder="Почта">
                    <input type="text" id="home_order_modal_telephone" placeholder="Телефон">
                    <input type="text" id="home_order_modal_address" placeholder="Адрес">
                    <input type="text"id="home_order_modal_message" placeholder="комментарий">
                    <input type="date" id="home_order_modal_start_date">
            </div>
            <div id="home_order_modal_select_end_price">
            <span>Итого:</span>
                <span id="home_order_modal_select_end_price_span"></span>
                
            </div>
            <button id="order_button">Заказать</button>
            
            <script>
                $("#home_order_modal_select").on("change",function(){
                    $("#home_order_modal_select_end_price_span").load("main.php?select="+$("#home_order_modal_select").val()+"");
                });
                $("#order_button").on("click",function(){
                    let name =$("#home_order_modal_name").val();
                    let telephone =$("#home_order_modal_telephone").val();
                    let address =$("#home_order_modal_address").val();
                    let message =$("#home_order_modal_message").val();
                    let start_date =$("#home_order_modal_start_date").val();
                    let price = $("#home_order_modal_select_span_end_price").text();
                    let mail = $("#home_order_modal_mail").val();
                    $.ajax({
                        url:'http://localhost/master/main.php',
                        method:'post',
                        data:{type: "order",name: name, mail: mail,telephone:telephone,address: address, message: message, start_date: start_date, price: price},
                        success: function(){
                            $("#home_order_modal_name").val("");
                            $("#home_order_modal_telephone").val("");
                            $("#home_order_modal_address").val("");
                            $("#home_order_modal_message").val("");
                            $("#home_order_modal_start_date").val("");
                            $("#home_order_modal_select_span_end_price").text("");
                            $("#home_order_modal_mail").val("");
                            $("#errors").html("<span style='color:green;font-size:30px;'>Заказ размещен</span>");
                        }
                    });
                });

            </script>
        </div>
    </div>
    <section>
        <div class="orders_type">

            <h1><span>Список доступных услуг</span><h1><br>
            <button id="home_order">Заказать мастера на дом</button>
            <button id="online_order">Связаться с мастером онлайн</button>
            <button id="office_order">записаться на обсуживание</button>
            <script>
                $("#office_order").on("click",function(){
                    $(".orders_type").load("main.php?reg");
                });
            </script>
        <div>
    </section>
        <hr style="color:black">
    <section>
        <div class="info">
        </div>
    </section>
    <script>
        let modal = document.getElementById("home_order_modal");
        let modalclick = document.querySelector(".modal");
        let modal_content = document.getElementById("modal_content");
        $(modalclick).on("click",function(e){
            if(e.target===modalclick){
                modal.style.display = "none";
                $("#errors").html("");
            }
        });
        $("#home_order").on("click",function(){
            modal.style.display = "flex";
        });
    </script>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
