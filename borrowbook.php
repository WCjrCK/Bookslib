<?php
if($_COOKIE['User']==''){
    echo "<script> alert('不存在该用户名($UNAME)!');parent.location.href='index.html'; </script>";
} 
    
    echo "<a href='library.php'><button>取消借阅</button></a>";
    $servername = "localhost";
    $username = "BigHomework";
    $password = "20010326@Jiao";
    $myDB ="BigHomework";/*
    echo empty($_GET['name']);
    echo empty($_GET['summary']);
    echo empty($_GET['major']);
    echo empty($_GET['tags']);
    echo empty($_GET['author']);
    echo empty($_GET['press']);
    echo empty($_GET['publictime']);
    echo empty($_GET['isbn']);*/

    $dbh1=new PDO('mysql:host='.$servername.';port=3306;charset=utf8; dbname='.$myDB,$username,$password,array( 
        PDO::ATTR_PERSISTENT=>true 
        )); 
    $sql1 = "SELECT * FROM BookMessage WHERE id =  ".$_GET['bookid'];
    //echo $sql1;
    $res = $dbh1->query($sql1);
    
    setcookie('brbook',1);
    foreach($res as $row){
        $ibtb=0;
        echo "<br><br><br><form action='brbook.php' method='post'>
        <div align=right><input type='date' name='date' required/></div>
        <input style='display:none' name='bookid' value=".$_GET['bookid']." />
        <div style=\"border:1px solid\">
        <table>
            <tr>
                <td rowspan=\"5\">
                    <div style=\"height:200px;width:200px;padding:20px;display:table-cell;text-align:center;vertical-align:middle\">
                        <img src=\"";

        if($row['cover']==NULL){
            echo "./picture/default.png";
        }else{
            echo $row['cover'];
        }

        echo "\"/>
                    </div>
                    <div align=center>在馆(".($row['booknumber']-$row['borrownumber']).")/借出(".$row['borrownumber'].")</div>
                </td>
                <td style=\"height:40px;padding:10px\"><div><b>书名：".$row['name']."</b></div></td>
            </tr>
            <tr><td style=\"height:40px;padding:10px\"><div>作者：<a href=\"search.php?searchnr=".$row['author']."&author=on\">".$row['author']."</a></div></td></tr>
            <tr><td style=\"height:40px;padding:10px\"><div>出版社：<a href=\"search.php?searchnr=".$row['press']."&press=on\">".$row['press']."</a>&nbsp;&nbsp;&nbsp;出版日期：<a href=\"search.php?searchnr=".$row['publictime']."&publictime=on\">".$row['publictime']."</a></div></td></tr>
            <tr><td style=\"height:40px;padding:10px\"><div>索书号：".$row['identifier']."</div></td></tr>
            <tr><td style=\"height:40px;padding:10px\"></td></tr>
            <tr><td></td><td>";
        
        echo "</td></tr>
        </table>";

        echo "
        <div style=\"padding:20px\">
            借阅时长：<select name='timelong'>
            <option value ='1'>1</option>
            <option value ='2'>2</option>
            <option value ='3'>3</option>
            <option value ='4'>4</option>
            <option value ='5'>5</option>
            <option value ='6'>6</option>
            <option value ='7'>7</option>
            <option value ='8'>8</option>
            <option value ='9'>9</option>
            <option value ='10'>10</option>
            <option value ='11'>11</option>
            <option value ='12'>12</option>
            <option value ='13'>13</option>
            <option value ='14'>14</option>
            <option value ='15'>15</option>
            <option value ='16'>16</option>
            <option value ='17'>17</option>
            <option value ='18'>18</option>
            <option value ='19'>19</option>
            <option value ='20'>20</option>
            <option value ='21'>21</option>
            <option value ='22'>22</option>
            <option value ='23'>23</option>
            <option value ='24'>24</option>
            <option value ='25'>25</option>
            <option value ='26'>26</option>
            <option value ='27'>27</option>
            <option value ='28'>28</option>
            <option value ='29'>29</option>
            <option value ='30'>30</option>
            </select>天
            <button>借阅</button>
        </div>
    </div></form>";
    }

?>