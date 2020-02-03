<?php
require_once "setup.php";
setup();
function signup(){
    $servername = "localhost";
    $username = "BigHomework";
    $password = "20010326@Jiao";
    $myDB ="BigHomework";

    $UTNAME = $_POST['name'];
    $IdCard = md5($_POST['idcardnum']);
    $stunum = md5($_POST['studentnum']);
    $UNAME = $_POST['username'];
    $PASW = md5($_POST['password']);

    $dbh1=new PDO('mysql:host='.$servername.';port=3306;charset=utf8; dbname='.$myDB,$username,$password,array( 
        PDO::ATTR_PERSISTENT=>true 
        )); 
    $sql1 = "SELECT * FROM NeceMessage WHERE name ='$UTNAME'";
    $res = $dbh1->query($sql1);
/*
    $con=mysqli_connect($servername,$username,$password,$myDB);

    $con->query("SET NAMES utf8");

    $result = mysqli_query($con,"SELECT * FROM NeceMessage WHERE name ='$UTNAME'");   */
       
    if($res->rowCount()==0){
        echo "<script> alert('不存在该学生($UTNAME)!');parent.location.href='SIGNUP.html'; </script>";
    }
        
    $tags = 1;
    foreach($res as $row){
        if($row['idcardnum'] == $IdCard){
            $tags=0;
            break;
        }
    }
    if($tags){
        echo "<script> alert('身份证号错误!');parent.location.href='SIGNUP.html'; </script>";
    }
        
    if(!($row['studentnum'] == $stunum)){
        echo "<script> alert('学号错误!');parent.location.href='SIGNUP.html'; </script>";
    }
        
    if(!($row['username'] == NULL)){
        echo "<script> alert('该学生已注册!跳转至登录页面');parent.location.href='index.html'; </script>";
    }
    $sql1 = "SELECT * FROM NeceMessage WHERE username ='$UNAME'";
    $res = $dbh1->query($sql1);
    if($res->rowCount()!=0){
        echo "<script> alert('该用户名已被使用!');parent.location.href='index.html'; </script>";
    }

    $sql1 = "UPDATE NeceMessage SET username = '$UNAME' , userpassword = '$PASW' WHERE idcardnum = '$IdCard' ";
    $dbh1->query($sql1);
    $dbh1=NULL;
    $ADM = $row['adm'];
    //echo $UNAME." ".$ADM;
    setcookie("User", "$UNAME");
    setcookie("Adm", "$ADM");
    echo "<script> parent.location.href='library.php'; </script>";
    //mysqli_query($con,"UPDATE NeceMessage SET username = '$UNAME' , userpassword = '$PASW' WHERE idcardnum = '$IdCard' ");
}
signup();
?>
