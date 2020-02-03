<?php
if($_COOKIE['User']==''){
    echo "<script> alert('不存在该用户名($UNAME)!');parent.location.href='index.html'; </script>";
}
    $servername = "localhost";
    $username = "BigHomework";
    $password = "20010326@Jiao";
    $myDB ="BigHomework";
    
    if($_COOKIE['Adm']==0){
        echo "<script>parent.location.href='library.php'; </script>";
    }

    $UNAME = $_COOKIE['User'];
    echo "<a href='library.php'><button>返回主界面</button></a>";

    $dbh1=new PDO('mysql:host='.$servername.';port=3306;charset=utf8; dbname='.$myDB,$username,$password,array( 
        PDO::ATTR_PERSISTENT=>true 
        )); 
    $sql1 = "SELECT * FROM NeceMessage WHERE Adm ='1' AND username != '$UNAME' ";
    $res = $dbh1->query($sql1);
    echo "<br><br><br><table>现有管理员";
    foreach($res as $row){
        echo "<tr>
            <td>".$row['name']."
                <form action='deladm.php' method='post'>
                    <input style='display:none' name='id' value = ".$row['id'].">
                    <button><font color=red>删除管理员</font></button>
                </form>
            </td>
        </tr>";
    }
    if($res->rowCount()==0){
        echo "<tr><td>无</td></tr>";
    }
    echo '</table>';
    $sql1 = "SELECT * FROM NeceMessage WHERE Adm ='0'";
    $res = $dbh1->query($sql1);
    echo "<br><br><table>现有普通用户";
    foreach($res as $row){
        echo "<tr>
            <td>".$row['name']."
                <form action='addadm.php' method='post'>
                    <input style='display:none' name='id' value = ".$row['id'].">
                    <button><font color=green>授予管理权限</font></button>
                </form>
            </td>
        </tr>";
    }
    if($res->rowCount()==0){
        echo "<tr><td>无</td></tr>";
    }
    echo '</table>';
?>