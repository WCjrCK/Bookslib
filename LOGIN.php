
<?php

require_once "setup.php";
setup();
function signup(){
    $servername = "localhost";
    $username = "BigHomework";
    $password = "20010326@Jiao";
    $myDB ="BigHomework";

    $UNAME = $_POST['username'];
    $PASW = md5($_POST['password']);

        $con=mysqli_connect($servername,$username,$password,$myDB);

        $result = mysqli_query($con,"SELECT * FROM NeceMessage WHERE username ='$UNAME'");
        
    if($row = mysqli_fetch_array($result)){
        if($PASW == $row['userpassword']){
            $ADM = $row['adm'];
            //echo $UNAME." ".$ADM;
            setcookie("User", "$UNAME");
            setcookie("Adm", "$ADM");
            echo "<script> parent.location.href='library.php'; </script>";
        } else {
            echo "<script> alert('密码错误!');parent.location.href='index.html'; </script>";
        }
    }else{
        echo "<script> alert('不存在该用户名($UNAME)!');parent.location.href='index.html'; </script>";
    }
}
signup();
?>