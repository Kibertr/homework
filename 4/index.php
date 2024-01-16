<head>
    <style>
        *{
            margin: 0px;
        }
        .main{
            width:100%;
        }
        .top{
            margin-top:50px;
            display:flex;
            align-items:center;
            justify-content:center;
            width:100%;
        }
        .bot{
            margin-top:50px;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .left{
            float:left;
        }
        a{
            color:white;
            text-decoration:none;
        }
        .ya span{
            color:black;
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
    function printSubjects(){
        $sql = "SELECT * FROM subjects";
        $result = mysqli_query($this->conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            echo '<option value="'.$row['subject'].'">'.$row['subject'].'</option>';
        }
    }
    function printStudents($group){
        $sql = "SELECT * FROM students where group_id='$group'";
        $result = mysqli_query($this->conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            echo '<div class="a"><a href="?'.$row['name'].'">'.$row['name'].'</a></div>';
        }
    }
    function otmetit($date,$c,$s,$g){
        $sql ="SELECT * FROM attendance where date='$date' and subject='$s'";
        $result = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($result)==1){
            $sqlr="UPDATE attendance set visiting='$c' where subject='$s' and date='$date' and group_id='$g'";
            $resultr= mysqli_query($this->conn,$sqlr);
        }else{
            $sqlr="INSERT INTO `attendance`(`date`, `subject`, `group_id`, `visiting`) VALUES ('$date','$s','$g','$c')";
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
    function printGraf($month,$group,$fd,$year,$subject){
        $m = date("m",mktime(0,0,0,$month+1,0,$year));
        for($i=1;$i<=$fd;$i++){
            echo '<td></td>';
        }
        echo '<tr>';
        for($i=1;$i<=$fd;$i++){
            $date = $year."-".$m."-".$i;
            $sql = "SELECT * FROM attendance where date='$date' and subject='$subject'";
            $result = mysqli_query($this->conn,$sql);
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    $c = $row['visiting'];
                }
            }else{
                $c=0;
            }
            $sql = "SELECT * FROM students where group_id='$group'";
            $result = mysqli_query($this->conn,$sql);
            $d = mysqli_num_rows($result);
            if($d<1){
            }else{
                $e = 50/$d;
                if($c!=0){
                    $height=$c*$e;
                    echo '<td valign="bottom" align="center" width="2%"><div class="ya" style="height:'.$height.'vh;margin-bottom:8px"><span>'.$c.'</span></div></td>';
                }else{
                    $height=0;
                    echo '<td valign="bottom" align="center" width="2%"><div class="ya" style="height:'.$height.'vh;margin-bottom:8px"></div></td>';
                }
            }
        }
        echo '</tr>';
    }
}
$cl=new main();
?>
<div class="main">
    <div class="container">
        <div class="top">
            <div class="left">
                <form class="form">
                    отметить учеников<br>
                    <input type="date" name="date_i"><br>
                    <select name="group_i">
                        <?php
                        $cl->printGroups();
                        ?>
                    </select><br>
                    <input type="number" name="number_i" placeholder="присутствующие"><br>
                    <select name="subject_i">
                        <?php
                        $cl->printSubjects();
                        ?>
                    </select><br>
                    <input type="submit" value="отметить">
                </form>
            </div>
            <div class="left">

            </div>
        </div>
        <div class="bot">
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
                </select><br>
                <input type="submit" value="сгенерировать">
            </form>
            <table border="1" height='60%'>
                <td colspan="31">
                <table width="100%" height="100%">
                    <?php
                    if(isset($_GET['month'])){
                        $month = $_GET['month'];
                        $group = $_GET['group'];
                        $year = date("Y",time());
                        $fd = date("t",mktime(0,0,0,$month+1,0,$year));
                        $subject = $_GET['subject_i'];
                        $cl->printGraf($month,$group,$fd,$year,$subject);
                    }
                    ?>
                </table>
                </td>
                <tr height="1%">
                    <?php
                    if(isset($_GET['month'])){
                        for($d=1;$d<=$fd;$d++){
                            echo '<td width="35">'.$d.'</td>';
                        }
                    }else{
                        for($d=1;$d<=31;$d++){
                            echo '<td width="35">'.$d.'</td>';
                        }
                    }

                ?>
                </tr>
            </table>
        </div>
    </div>
</div>
<?php
if(isset($_GET['date_i'])){
    $date = $_GET['date_i'];
    $c = $_GET['number_i'];
    $s = $_GET['subject_i'];
    $g = $_GET['group_i'];
    $cl->otmetit($date,$c,$s,$g);
}
?>
