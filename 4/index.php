<head>
    <style>
        *{
            margin: 0px;
        }
        .main{
            width:100%;
        }
        .main .container{
        }
        a{
            color:white;
            text-decoration:none;
        }
        .ya span{
            color:white;
            padding:3px;
            border-radius:10px;
            background:black;
        }
        .ya{
            padding:5px;
            background-color:green;
        }
        .a{
            border-radius:20px;
            background:rgba(0,0,0,0.6);
            padding:10px;
            margin:10px;
        }
        .container{
            float:left;
            height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            min-width:131px;
        }
    </style>
</head>
<?php
$m=["1"=>"январь","2"=>"февраль","3"=>"Март","4"=>"Апрель","5"=>"Май","6"=>"Июнь","7"=>"Июль","8"=>"Август","9"=>"Сентябрь","10"=>"Октябрь","11"=>"Ноябрь","12"=>"Декабрь"];
$mp=["01"=>"январь","02"=>"февраль","03"=>"Март","04"=>"Апрель","05"=>"Май","06"=>"Июнь","07"=>"Июль","08"=>"Август","09"=>"Сентябрь","10"=>"Октябрь","11"=>"Ноябрь","12"=>"Декабрь"];
class main{
    private $conn = "";

    function __construct(){
        $this->conn=mysqli_connect("localhost","root","root","school");
    }
    function printGroups(){
        $sql = "SELECT * FROM groups";
        $result = mysqli_query($this->conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    }
    function printStudents($group){
        $sql = "SELECT * FROM students where group_id='$group'";
        $result = mysqli_query($this->conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            echo '<div class="a"><a href="?'.$row['name'].'">'.$row['name'].'</a></div>';
        }
    }
    function getGroupNum($group){
        $sql = "SELECT * FROM students where group_id='$group'";
        $result = mysqli_query($this->conn,$sql);
        $num = mysqli_num_rows($result);
        return $num;
    }
    function getGraf($date){
        $sql = "SELECT * FROM attendance where date='$date'";
        $result = mysqli_query($this->conn,$sql);        
        if(mysqli_num_rows($result)==1){
            while($row = mysqli_fetch_assoc($result)){
                $array = $row['visiting'];
            }
        }else{
            return 0;
        }
        return $array;
    }

    function otmetit($date,$c,$s,$g){
        $sql ="SELECT * FROM attendance where date='$date' and subject=$s";
        $result = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($result)==1){
            echo 1;
            $sqlr="UPDATE attendance set visiting='$c' where subject='$s' and date='$date' and group_id='$g'";
            $resultr= mysqli_query($this->conn,$sqlr);
        }else{
            
            $sqlr="INSERT INTO `attendance`(`date`, `subject`, `group_id`, `visiting`) VALUES ('$date','$s','$g','$c')";
            echo $sqlr;
            $resultr= mysqli_query($this->conn,$sqlr);
        }
       
    }
    function printSubject(){
        $sql = "SELECT * FROM subjects";
        $result = mysqli_query($this->conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            echo '<option value="'.$row['subject'].'">'.$row['subject'].'</option>';
        }
    }
}
$cl=new main();
?>
<div class="main">
    <div class="container">
         
        <form class="form">
            отметить учеников<br>
            <input type="date" name="date_i"><br>
            <input type="number" name="number_i"><br>
            <input type="subject" name="subject_i"><br>
            <input type="submit" value="отметить">
        </form>
    </div>
    <div class="container" style="float:right">
        <table border="1" height="100%">
            <td colspan="31">
            <table height="100%" width="100%">
                <?php
                $year = date("Y",mktime());
                $month = date("m",mktime(0,0,0,$_GET['month']+1,0,$year));
                $fd = date("t",mktime(0,0,0,$_GET['month']+1,0,$year));
                for($i=1;$i<=$fd;$i++){
                    echo '<td></td>';
                }
                echo '<tr>';
                $group = $_GET['group'];
                for($i=1;$i<=$fd;$i++){
                    $date= $year."-".$month."-".$i;
                    $c = $cl->getGraf($date);
                    $d = $cl->getGroupNum($group);
                    $e = 90/$d;
                    if($c!=0){
                        $height=$c*$e;
                    }else{
                        $height=0;
                    }
                    
                    echo '<td valign="bottom" align="center" width="2%"><div class="ya" style="height:'.$height.'vh;margin-bottom:8px"><span>'.$c.'</span></div></td>';
                }
                echo '</tr>';
                ?>
            </table>
            </td>
            <tr height="1%">
                <?php
                for($d=1;$d<=$fd;$d++){
                    echo '<td width="35">'.$d.'</td>';
                }
            ?>
            </tr>
        </table>
    </div>
    <div class="container" style="float:right">
        <form>
            генерация графика
        <div class="input">
            <select name="group">
            <?php
            $cl->printGroups();
            ?>
            </select>
        </div>
            <select name="month">
                <?php
                for($i=1;$i<=12;$i++){
                    echo '<option value="'.$i.'">'.$m[$i].'</option>';
                }
                ?>
            </select><br>
            <select name="subject_i">
                <?php
                    $cl->printSubject();
                ?>
            </select>
            <input type="submit" value="сгенирировать">
            </form>
    </div>
</div>
<?php
if(isset($_GET['date_i'])){
    $date = $_GET['date_i'];
    $c = $_GET['number_i'];
    $s = $_GET['subject_i'];
    $g = $_GET['group'];
    $cl->otmetit($date,$c,$s,$g);
}
?>
