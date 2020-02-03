<?php
if($_COOKIE['User']==''){
    echo "<script> alert('不存在该用户名($UNAME)!');parent.location.href='index.html'; </script>";
}
if($_COOKIE['brbook']==0){
    echo "parent.location.href='library.php'; </script>";
}
$servername = "localhost";
$username = "BigHomework";
$password = "20010326@Jiao";
$myDB ="BigHomework";

$dbh1=new PDO('mysql:host='.$servername.';port=3306;charset=utf8; dbname='.$myDB,$username,$password,array( 
    PDO::ATTR_PERSISTENT=>true 
    )); 

    $sql1 = "SELECT * FROM BookMessage WHERE id =".$_POST['bookid'];
    $res = $dbh1->query($sql1);
    $sql1 = "SELECT * FROM NeceMessage WHERE username =".$_COOKIE['User'];
    $res1 = $dbh1->query($sql1);
    foreach($res1 as $row1){
        break;
    }
    foreach($res as $row){
        break;
    }
    
setcookie('brbook',0);
$sql1 = "UPDATE BookMessage SET borrownumber = ".($row['borrownumber']+1)." , borrowtags = '"."<br>"."借阅人：".$row1['name']."&nbsp;&nbsp;&nbsp;"."借阅时间：".$_POST['date']."&nbsp;&nbsp;&nbsp;"."借阅时长：".$_POST['timelong']."天' WHERE id =".$_POST['bookid'];
$dbh1->query($sql1);

if($row1['major']==$row['major']){
    $sql1 = "UPDATE NeceMessage SET mbtimes = ".($row1['mbtimes']-1)." , majorbook = '".$row1['majorbook'].",".$row['name']."' WHERE id =".$row1['id'];
}else{    
    $sql1 = "UPDATE NeceMessage SET umbtimes = ".($row1['umbtimes']-1)." , unmajorbook = '".$row1['unmajorbook'].",".$row['name']."' WHERE id =".$row1['id'];
}
$dbh1->query($sql1);

echo "<script>alert('借阅书籍".$row['name']."成功！');parent.location.href='library.php'; </script>";

?>