<?php
if($_COOKIE['User']==''){
    echo "<script> alert('不存在该用户名($UNAME)!');parent.location.href='index.html'; </script>";
}
    $servername = "localhost";
    $username = "BigHomework";
    $password = "20010326@Jiao";
    $myDB ="BigHomework";
    
    echo "<a href='library.php'><button>返回主界面</button></a>";
    
    $UNAME = $_COOKIE['User'];
    $dbh1=new PDO('mysql:host='.$servername.';port=3306;charset=utf8; dbname='.$myDB,$username,$password,array( 
        PDO::ATTR_PERSISTENT=>true 
        )); 
    $sql1 = "SELECT * FROM NeceMessage WHERE username ='$UNAME'";
    $res = $dbh1->query($sql1);
    foreach($res as $row){
        
        $zero1=$row['forbidentime'];
        $zero2=date("Y-m-d",time());

        if(strtotime($zero1)<strtotime($zero2)){
            $sql1 = "UPDATE NeceMessage SET nowtype = 0  WHERE id =".$row['id'];
            $dbh1->query($sql1);
            $row['nowtype']=0;
        }

        echo "<table>
        <tr><td>姓名</td><td>".$row['name']."</td></tr>
        <tr><td>专业</td><td>".$row['major']."</td></tr>
        <tr><td>用户名</td><td>".$row['username']."</td></tr>
        <tr><td>管理权限</td><td>";
        if($row['adm']){
            echo '<font algin=right color=red>管理员</font>';
        }else{
            echo '普通用户';
        }
        echo "</td></tr>
        <tr><td>可借本专业书数目</td><td>".$row['mbtimes']."</td></tr>
        <tr><td>在借本专业书</td><td>";
        if($row['majorbook']==''){
            echo '无';
        }else{
            $str = $row['majorbook'];
            $str = trim($str, ",，");
            echo preg_replace(".[，,].","<br>",$str);
        }
        echo "</td></tr>
        <tr><td>可借非本专业书数目</td><td>".$row['umbtimes']."</td></tr>
        <tr><td>在借非本专业书</td><td>";
        if($row['unmajorbook']==''){
            echo '无';
        }else{
            $str = $row['unmajorbook'];
            $str = trim($str, ",，");
            echo preg_replace(".[，,].","<br>",$str);
        }
        echo "</td></tr>";
        switch ($row['nowtype']) {
            case 1:
                echo "<tr><td>借阅卡卡号</td><td>".($row['id']+100000)."</td></tr>
                <tr><td>状态</td><td><font algin=right color=red>您存在逾期还书记录,暂无法借书,请于".$row['forbidentime']."后还书</font>";
                break;
                
            case 0:
                echo "<tr><td>借阅卡卡号</td><td>".($row['id']+100000)."</td></tr>
                <tr><td>状态</td><td><font algin=right color=green>正常</font>";
                break;
                    
            case -1:
                echo '<tr><td>状态</td><td>未申请借阅卡,<a href="applyreadcard.php">点击申请</a>';
                break;
            
            default:
                # code...
                break;
        }
        echo "</td></tr>
        </table>";
    }
?>