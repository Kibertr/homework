<?php
session_start();
class main{
    private $conn = "";

    function __construct(){
        $this->conn = mysqli_connect("localhost","root","root","master");
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
    function printServicesName(){
        $sql= "SELECT id,name FROM services";
        $result = mysqli_query($this->conn,$sql);
        if($result){
            while($row = mysqli_fetch_assoc($result)){
                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
        }
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
            $sql= "INSERT INTO clients(`uname`,`mail`,`telephone`,`uaddress`) VALUES('$name','$mail','$number','$address')";
            $result = mysqli_query($this->conn,$sql);
            if($result){
                $sql= "SELECT * FROM clients where telephone='$number' and uaddress='$address' and uname='$name'";
                $result = mysqli_query($this->conn,$sql);
                $row = mysqli_fetch_assoc($result);
                $id = $row['id'];
                $price = $row['price'];
                $sql = "INSERT INTO orders(`client_id`,`price`,`start_date`,`status`) VALUES('$id','$price','$start_date','waiting')";
                $result = mysqli_query($this->conn,$sql);
            }
        }else{
            $id = $row['id'];
            $sql = "INSERT INTO orders(`client_id`,`price`,`start_date`,`status`,`message`) VALUES('$id','$price','$start_date','waiting','$com')";
            $result = mysqli_query($this->conn,$sql);
        }
    }
}
if(isset($_GET['select'])){
    $cl=new main();
    $id=$_GET['select'];
    $cl->printServicesPrice($id);
}
if($_POST['type']=="order"){
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
