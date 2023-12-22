<?php
session_start();
class main{
    private $conn = "";

    function __construct(){
        $this->conn = mysqli_connect("localhost","root","root","master");
    }

    function printBestMasters(){
        $sql= "SELECT * FROM staff where orders>0";
        $result = mysqli_query($this->conn,$sql);
        if($result){
            echo '<div class="staff">';
            while($row = mysqli_fetch_assoc($result)){
                echo '<div class="menu_staff">';
                echo '<img src="img/masters/'.$row['image'].'">';
                echo '<span>'.$row['name'].'</span><br>';
                echo '<span>Поручений - '.$row['orders'].'</span>';
                echo '</div>';
            }
            echo '</div>';
        }else{
            echo '<span>Не удалось подключиться к базе данных</span>';
        }
    }
    function printMasters(){
        $sql= "SELECT * FROM staff";
        $result = mysqli_query($this->conn,$sql);
        if($result){
            echo '<div class="staff">';
            while($row = mysqli_fetch_assoc($result)){
                echo '<div class="menu_staff">';
                echo '<img src="img/masters/'.$row['image'].'">';
                echo '<span>'.$row['name'].'</span><br>';
                echo '<span>Поручений - '.$row['orders'].'</span>';
                echo '</div>';
            }
            echo '</div>';
        }else{
            echo '<span>Не удалось подключиться к базе данных</span>';
        }
    }
    function getServicesName(){
        $sql= "SELECT id,name FROM services";
        $result = mysqli_query($this->conn,$sql);
        if($result){
            while($row = mysqli_fetch_assoc($result)){
                $array[]=$row;
            }
        }
        return $array;
    }
    function printServicesPrice($id){
        $sql= "SELECT price FROM services where id='$id'";
        $result = mysqli_query($this->conn,$sql);
        if($result){
            while($row = mysqli_fetch_assoc($result)){
                echo '<span value="'.$row['price'].'" id="home_order_modal_select_span_end_price">'.$row['price'].'р.</span>';
            }
        }
    }
    function newOrder($address,$number,$name,$price,$start_date,$mail,$com){
        $sql= "SELECT * FROM clients where telephone='$number' and uaddress='$address' and uname='$name'";
        $result = mysqli_query($this->conn,$sql);
        $row = mysqli_fetch_assoc($result);
        if(mysqli_num_rows($result)==0){
            $pass = '';
            $arr = array(
                'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 
                'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 
                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 
                'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 
                '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
            );
            for ($i = 0; $i<10; $i++) {
                $pass.= $arr[random_int(0, count($arr) - 1)];
            }
            $pass = md5($pass);
            $sql= "INSERT INTO clients(`uname`,`mail`,`telephone`,`uaddress`,`pass`) VALUES('$name','$mail','$number','$address','$pass')";
            $result = mysqli_query($this->conn,$sql);
            if($result){
                $sql= "SELECT * FROM clients where telephone='$number' and uaddress='$address' and uname='$name'";
                $result = mysqli_query($this->conn,$sql);
                $row = mysqli_fetch_assoc($result);
                $id = $row['id'];
                $sql = "INSERT INTO orders(`client_id`,`price`,`start_date`,`status`,`message`) VALUES('$id','$price','$start_date','waiting','$com')";
                $result = mysqli_query($this->conn,$sql);
            }
        }else{
            $id = $row['id'];
            $sql = "INSERT INTO orders(`client_id`,`price`,`start_date`,`status`,`message`) VALUES('$id','$price','$start_date','waiting','$com')";
            $result = mysqli_query($this->conn,$sql);
        }
    }
    function login($pass,$mail){
        $sql= "SELECT * FROM clients where mail='$mail' and pass='$pass'";
        $result = mysqli_query($this->conn,$sql);
        if($result){
            $row = mysqli_fetch_assoc($result);
            $name=$row['uname'];
            $address=$row['uaddress'];
            $telephone=$row['telephone'];

            $f = fopen('file.txt', 'a+');
            fwrite($f, "1");
            fclose($f);
            setcookie("name",$name,time()+3600*24);
            setcookie("telephone",$telephone,time()+3600*24);
            setcookie("address",$address,time()+3600*24);

            setcookie("pass",$pass,time()+3600*24);
            setcookie("mail",$mail,time()+3600*24);            
        }else{
            $_SESSION['error']='<span style="color:red;">Произошла ошибка</span>';
            $f = fopen('file.txt', 'a+');
            fwrite($f, "хуй");
            fclose($f);
        }
    }
    function reg($address,$number,$name,$pass,$mail){
        $sql= "SELECT * FROM clients where mail='$mail' or telephone='$number' or uaddress='$address'";
        $result = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                $array[] = $row;
            }
            foreach($array as $key=>$val){
                if($val['telephone']==$number){
                    $_SESSION['error']='<span style="color:red;">Номер телефона занят</span>';
                }
                if($val['mail']==$mail){
                    $_SESSION['error']='<span style="color:red;">Почта занята</span>';
                }
                if($val['uaddress']==$address){
                    $_SESSION['error']='<span style="color:red;">Адрес занят</span>';
                }
            }
        }
        else{
            $sql= "INSERT INTO clients(`uname`,`mail`,`telephone`,`uaddress`,`pass`) VALUES('$name','$mail','$number','$address','$pass')";
            $result = mysqli_query($this->conn,$sql);
            if($result){
                $_SESSION['error']='<span style="color:green;">Регистрация успешно завершена</span>';
            }else{
                $_SESSION['error']='<span style="color:red;">Произошла ошибка</span>';
            }
        }
    }
    function status(){
        print_r($_SESSION['error']);
        unset($_SESSION['error']);
    }
}
if(isset($_GET['error'])){
    $cl=new main();
    $cl->status();
}
if(isset($_GET['select'])){
    $cl=new main();
    $id=$_GET['select'];
    $cl->printServicesPrice($id);
}
if(isset($_POST['log'])){
    $cl = new main();
    $pass = md5($_POST['pass']);
    $mail = $_POST['mail'];
    $cl->login($pass,$mail);
}
if(isset($_POST['reg'])){
    $cl = new main();
    $mail = $_POST['mail'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $number = $_POST['telephone'];
    $pass=md5($_POST['pass']);
    $cl->reg($address,$number,$name,$pass,$mail);
}
if(isset($_POST['order'])){
    $cl = new main();
    $start_date = $_POST['start_date'];
    $mail = $_POST['mail'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $number = $_POST['telephone'];
    $price = substr($_POST['price'],0,strlen($_POST['price']-2));
    if(!empty($_POST['message'])){
        $com = $_POST['message'];
    }else{
        $com = "";
    }
    $cl->newOrder($address,$number,$name,$price,$start_date,$mail,$com);
}
?>