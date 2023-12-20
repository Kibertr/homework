<script src="../../jquery-3.7.1.js"></script>
<div id="select_div">Сколько полей - <select name="rows" id="rows">
    <?php
    for($i=3;$i<10;$i++){
        echo '<option value="'.$i.'">'.$i.'</option>';
    }
    ?>
</select>
</div>
<div id="input_div">
</div>
<form id="main_form" action="index.php" method="post" style="display:none">

<input type="submit" vlaue="Отправить">
</form>
<button id="select_button">Выбрать</button>
<button id="create_button" style="display:none">Показать форму</button>
<button id="output_button" style="display:none">Отправить данные</button>
<script>
    $("#select_button").on("click",function(){
        $("#select_div").css("display","none");
        $("#select_button").css("display","none");
        for(i=1;i<=$("#rows").val();i++){
            $("#input_div").append('<div><input id="label'+i+'" placeholder="label к строке '+i+'"><input type="text" id="name'+i+'" placeholder="имя '+i+' строки"></div>');
        }
        $("#create_button").css("display","block");
    });
    $("#create_button").on("click",function(){
        $("#input_div").css("display","none");
        for(i=1;i<=$("#rows").val();i++){
            console.log($("#rows").val());
            $("#main_form").append('<div><label for="input'+i+'">'+$("#label"+i+"").val()+'</label><input type="text" id="input'+i+'" name="'+$("#name"+i+"").val()+'"></div>');
        }
        $("#create_button").css("display","none");
        $("#main_form").css("display","block");
    });
</script>
<?php
if(!empty($_POST)){
    echo "<br>Отправленые данные:<br>";
    print_r($_POST);
}
?>
