<?php
if($_COOKIE['User']==''){
    echo "<script> alert('不存在该用户名($UNAME)!');parent.location.href='index.html'; </script>";
}
if($_COOKIE['rtbook']==0){
    echo "<script>parent.location.href='library.php'; </script>";
}
$servername = "localhost";
$username = "BigHomework";
$password = "20010326@Jiao";
$myDB ="BigHomework";

setcookie('rtbook',0);

$dbh1=new PDO('mysql:host='.$servername.';port=3306;charset=utf8; dbname='.$myDB,$username,$password,array( 
    PDO::ATTR_PERSISTENT=>true 
    )); 

    $sql1 = "SELECT * FROM BookMessage WHERE id =".$_GET['bookid'];
    $res = $dbh1->query($sql1);
    $sql1 = "SELECT * FROM NeceMessage WHERE username =".$_COOKIE['User'];
    $res1 = $dbh1->query($sql1);
    foreach($res1 as $row1){
        break;
    }
    foreach($res as $row){
        break;
    }

    preg_match("/时间：.*&nbsp;/",$row['borrowtags'],$BDATE);
    preg_match("/时长：.*天/",$row['borrowtags'],$BTL);

    $BDATE = str_replace("时间：","",str_replace("&nbsp;","",$BDATE));
    $BTL = str_replace("时长：","",str_replace("天","",$BTL));

    $zero1=date("Y-m-d",strtotime("+".$BTL[0]." day",strtotime($BDATE[0])));
    $zero2=date("Y-m-d",time());

    if(strtotime($zero1)<strtotime($zero2)){
        $sql1 = "UPDATE NeceMessage SET nowtype = 1 , forbidentime = '".date("Y-m-d",strtotime("+7 day"))."' WHERE id =".$row1['id'];
        $dbh1->query($sql1);
        echo "<script>alert('逾期还书，一周内禁止借书！');</script>";
        //echo  $sql1 ;
    }

$sql1 = "UPDATE BookMessage SET borrownumber = ".($row['borrownumber']-1)." , borrowtags = '".preg_replace("/<br>.*?".$row1['name'].".*?天/","",$row['borrowtags'])."' WHERE id =".$_GET['bookid'];
$dbh1->query($sql1);
//echo $sql1;

if($row1['major']==$row['major']){
    $sql1 = "UPDATE NeceMessage SET mbtimes = ".($row1['mbtimes']+1)." , majorbook = '".trim(str_replace($row['name'],"",$row1['majorbook']),",，")."' WHERE id =".$row1['id'];
}else{    
    $sql1 = "UPDATE NeceMessage SET umbtimes = ".($row1['umbtimes']+1)." , unmajorbook = '".trim(str_replace($row['name'],"",$row1['unmajorbook']),",，")."' WHERE id =".$row1['id'];
}
$sql1 = preg_replace("/[,，]{1,}/",",",$sql1);
//echo $sql1;
$dbh1->query($sql1);

echo "<script>alert('归还书籍".$row['name']."成功！');parent.location.href='library.php'; </script>";

?>