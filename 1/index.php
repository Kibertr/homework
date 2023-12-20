<?php
$conn = mysqli_connect("localhost","root","root","zadanie");
?>
<head>
    <style>
        .div div{
            display:flex;
            float:left;
        }
    </style>
</head>
список таблиц
<div class="div">
<div>
<table border="1" cellpadding="5">
<?php

$sql = "SHOW tables";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_row($result)){
    echo '<tr><td><a href=?table='.$row[0].'>'.$row[0].'</td></tr>';
}
?>
</table>
</div>
    <div>
        <form action=<?php if(isset($_GET['table'])){echo '"index.php?table='.$_GET['table'].'"';}?> method="post">
            <table border="1" cellpadding="5"><?php
                if(isset($_GET['table'])){
                    $table = $_GET['table'];
                    $sql_column = "DESCRIBE $table";
                    $result_column = mysqli_query($conn,$sql_column);
                    while($row_column = mysqli_fetch_row($result_column)){
                        $tables[]=$row_column[0];
                        if(!empty($_GET['edit'])){
                            echo '<td><input type="text" name="'.$row_column[0].'" value="'.$row_column[0].'"></td>';
                        }else{
                            echo '<td>'.$row_column[0].'</td>';
                        }
                    }
                    if(isset($_GET['edit'])){
                        echo '<input type="hidden" name="table" value="'.$_GET['table'].'">';
                        echo '<td><input type="submit" value="подтвердить"></td>';
                    }
                    else{
                        echo '<td><a href="?table='.$table.'&edit='.$table.'">изменить</a></td>';

                    }
                    
                    $sql_data = "SELECT * FROM $table";
                    $result_data = mysqli_query($conn,$sql_data);
                    while($row_data = mysqli_fetch_assoc($result_data)){
                        echo '<tr>';
                        for($i=0;$i<count($tables);$i++){
                            echo '<td>'.$row_data[$tables[$i]].'</td>';
                        }
                        echo '</tr>';
                    }
                }?>
            <table>
        </form>
    </div>
</div>
<?php
if(!empty($_POST)){
    $table=$_POST['table'];
    $sql_table = "DESCRIBE $table";
    $result_table = mysqli_query($conn,$sql_table);
    $sql_table="";
    $rows = count($_POST);
    $i=3;
    while($row= mysqli_fetch_row($result_table)){
        if($row[2]=="NO"){
            $null = "NOT NULL";
        }else{
            $null="";
        }
        foreach($_POST as $key=>$val){
            if($key==$row[0] && $row[3]!="PRI"){
                $sql_table.="CHANGE `$key` `$val` $row[1] $null";
                if($rows>$i){
                    $i++;
                    $sql_table.=", ";
                }
            }
        }
        
    }
    $sql = "ALTER TABLE $table $sql_table";
    $result = mysqli_query($conn,$sql);

}
?>
