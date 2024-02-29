<?php
class main{
    private $conn = "";

    public function __construct(){
        $this->conn = mysqli_connect("localhost","root","root",'school');
    }
    function print_groups(){
        $sql = 'SELECT * FROM groups';
        $result = mysqli_query($this->conn,$sql);
        while($row = mysqli_fetch_array($result)){
            if(isset($_GET['group']) && $_GET['group']==$row['id']){
                echo '<option selected value="'.$row['id'].'">'.$row['name'].'</option>';
            }else{
                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
        }
    }
    function print_subjects(){
        $sql = 'SELECT * FROM subjects';
        $result = mysqli_query($this->conn,$sql);
        while($row = mysqli_fetch_array($result)){
            if(isset($_GET['subject']) && $_GET['subject']==$row['id']){
                echo '<option selected value="'.$row['id'].'">'.$row['name'].'</option>';
            }else{
                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
        }
    }
    function print_table_date($month){
        $cd = mktime(0,0,0, $month, 1, date('Y',time()));
        $ld = mktime(0,0,0,$month,date("t",$cd),date('Y',time()));
        for($i=$cd;$i<=$ld;$i=$i+(3600*24)){
            echo '<td><div style="10px">'.date('d',$i)."</div></td>";
        }
    }
    function print_month(){
        $months = ["1"=>"Январь","2"=>"Февраль","3"=>"Март","4"=>"Апрель","5"=>"Май","6"=>"Июнь","7"=>"Июль","8"=>"Август","9"=>"Сентябрь","10"=>"Октябрь","11"=>"Ноябрь","12"=>"Декабрь"];
        foreach($months as $n=>$t){
            if(isset($_GET["month"]) && $_GET["month"]==$n){
                echo '<option selected value="'.$n.'">'.$t.'</otion>';
            }else{
                echo '<option value="'.$n.'">'.$t.'</otion>';
            }
        }
    }
    function print_graph($month,$group,$subject){
        $sql_s = "SELECT * FROM students where group_id='$group'";
        $result_s = mysqli_query($this->conn,$sql_s);
        $mh = 500/mysqli_num_rows($result_s);
        $sql_at = "SELECT * FROM attendance where month='$month' and group_id='$group' and subject_id='$subject'";
        $result_at = mysqli_query($this->conn,$sql_at);
        $cd = mktime(0,0,0, $month, 1, date('Y',time()));
        $ld = mktime(0,0,0,$month,date("t",$cd),date('Y',time()));
        $dates = array();
        while($row = mysqli_fetch_array($result_at)){
            $dates[$row['date']]= $row['attend'];
        }
        for($i=$cd;$i<=$ld;$i=$i+(3600*24)){
            echo '<td valign="bottom" style="height:500px;text-align:center">';
                foreach($dates as $d=>$a){
                if($d==date("Y-m-d",$i)){
                    $h = $mh*$a;
                    echo $a.'<div style="height:'.$h.'px;background:green"></div>';
                }
            }
            echo '</td>';
        }
    }
    function add_data($attend,$date,$group,$subject){
        $sql_s = "SELECT * FROM students where group_id='$group'";
        $result_s = mysqli_query($this->conn,$sql_s);
        $total_students = mysqli_num_rows($result_s)+1;
        $nmonth = explode("-",$date);
        $month = $nmonth[1];
        $sql = "INSERT INTO attendance(`date`,`attend`,`group_id`,`month`,`subject_id`,`total_students`) VALUE('$date','$attend','$group','$month','$subject','$total_students')";
        $result = mysqli_query($this->conn,$sql);
        if($result){
            echo 'успешно отмечено';
        }else{
            echo 'ошибка';
        }
    }
}
$cl = new main();
?>
<head>
    <link rel="stylesheet" href="bootstrap.css">
    <style>
        .container{
            display: flex;
            justify-content: center;
            margin-top: 100px;
        }
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .main{
            display: flex;
            flex-direction: column;
            width:1000px;
            align-items: center;
        }
    </style>
</head>
<body>
    <form method="post"class="container row">
        <div class="col-md-2">
            <input type="number" name="attend" placeholder="кол-во присутвующих" class="form-control">
        </div>
        <div class="col-md-2">
            <input type="date" name="date" class="form-control">
        </div>
        <div class="col-md-2">
            <select name="group" class="form-control">
                <?php
                    $cl->print_groups();
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="subject" class="form-control">
                <?php
                    $cl->print_subjects();
                ?>
            </select>
        </div>
        <div style="text-align:center;margin-top:10px;">
            <div class="col-md-12">
                <input type="submit" class="btn btn-primary">
            </div>
        </div>
        <input type="hidden" name="post"value="post">
    </form>
    <div class="container main">
        <form class="row">
            <div class="col-md-3">
                <select name="month" class="form-control">
                <?php
                    $cl->print_month();
                ?>
            </select>
            </div>
            <div class="col-md-3">
            <select name="group" class="form-control">
                <?php
                    $cl->print_groups();
                ?>
            </select>
            </div>
            <div class="col-md-3">
            <select name="subject" class="form-control">
                <?php
                    $cl->print_subjects();
                ?>
            </select>
            </div>
            <div class="col-md-3">
                <input type="submit" class="btn btn-primary">
            </div>
        </form>
        <div class="div_table">
            <table class="table" border="1">
                <tr>
                <?php 
                $cl->print_graph($_GET['month'],$_GET['group'],$_GET['subject']);
                ?>
                </tr>
                <tr>
                <?php
                $cl->print_table_date($_GET['month']);
                ?>
                </tr>
            </table>
        </div>
    </div>
</body>
<?php
if(isset($_POST['post'])){
    if(!empty($_POST['attend']) && !empty($_POST['date']) && !empty($_POST['group']) && !empty($_POST['subject'])){
        $cl->add_data($_POST['attend'],$_POST['date'],$_POST['group'],$_POST['subject']);
    }else{
        echo 'необходимо заполнить все поля';
    }
}
?>
