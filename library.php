<style type="text/css">
    .summary{
        font-family: Varela Round,Microsoft YaHei,Source Sans Pro,Helvetica Neue,
                        Menlo,Monaco,monospace,Lucida Console,sans-serif,Helvetica,Hiragino Sans GB,
                        Hiragino Sans GB W3,Source Han Sans CN Regular,WenQuanYi Micro Hei,Arial,sans-serif;
        white-space: pre-wrap;
        white-space: -moz-pre-wrap;
        white-space: -pre-wrap;
        white-space: -o-pre-wrap;
        word-wrap: break-word;
        word-break:break-all;
        width:100%
    }
</style>
<?php
    $servername = "localhost";
    $username = "BigHomework";
    $password = "20010326@Jiao";
    $myDB ="BigHomework";

    echo '<div align=right>';

    if(empty($_COOKIE['User'])){
        echo '<div align=center>游客，请先<a href="index.html">登录</a></div>';
        setcookie('Adm',0);
    }else{
        $UNAME = $_COOKIE['User'];
        $dbh1=new PDO('mysql:host='.$servername.';port=3306;charset=utf8; dbname='.$myDB,$username,$password,array( 
            PDO::ATTR_PERSISTENT=>true 
            )); 
        $sql1 = "SELECT * FROM NeceMessage WHERE username ='$UNAME'";
        $res = $dbh1->query($sql1);
        foreach($res as $row){
            echo '欢迎您,<xmp>'.$row['name'].'</xmp>';
        }
        if($_COOKIE['Adm']){
            echo "(<font algin=right color=red>管理员</font>)";
        }
        echo "<a href='LOGOUT.php'><button>登出</button></a>";
    }
    echo '</div>';

    if(!empty($_COOKIE['User'])){
        echo "<a href='personmess.php'><button>个人信息</button></a>";
    }
    if($_COOKIE['Adm']){
        echo "<a href='newadm.php'><button>管理管理员</button></a>";
        echo "<a href='addbook.php'><button>添加书籍</button></a>";
    }
    
    $servername = "localhost";
    $username = "BigHomework";
    $password = "20010326@Jiao";
    $myDB ="BigHomework";
    
    echo "<br><br><br><div style='height:25px' align=center><form action='search.php' method='get'>
            搜索图书<input style='vertical-align: middle;height:100%;width:70%' type='text' name='searchnr' required/><button style='vertical-align: middle;height:100%'>搜索</button>
            <div><input type='checkbox' name='name' checked='checked'/>搜索书名
            <input type='checkbox' name='summary'/>搜索简介
            <input type='checkbox' name='major'/>搜索专业
            <input type='checkbox' name='tags'/>搜索标签
            <input type='checkbox' name='author'/>搜索作者
            <input type='checkbox' name='press'/>搜索出版社
            <input type='checkbox' name='publictime'/>搜索出版时间
            <input type='checkbox' name='isbn'/>搜索ISBN码
            </div>
        </form></div>";

    echo "<br><br><br>藏书一览";

    $dbh1=new PDO('mysql:host='.$servername.';port=3306;charset=utf8; dbname='.$myDB,$username,$password,array( 
        PDO::ATTR_PERSISTENT=>true 
        )); 
        if(!empty($_COOKIE['User'])){
            $sql1 = "SELECT * FROM NeceMessage WHERE username =".$_COOKIE['User'];
            $res = $dbh1->query($sql1);
            foreach($res as $row1){
                break;
            }
        }
    $sql1 = "SELECT * FROM BookMessage";
    $res = $dbh1->query($sql1);
    foreach($res as $row){
        $ibtb=0;
        echo "<br><br><br>
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
                <td style=\"height:40px;padding:10px\"><div><b>书名：<a href=\"search.php?searchnr=".$row['name']."&name=on\">".$row['name']."</a></b></div></td>
            </tr>
            <tr><td style=\"height:40px;padding:10px\"><div>作者：<a href=\"search.php?searchnr=".$row['author']."&author=on\">".$row['author']."</a></div></td></tr>
            <tr><td style=\"height:40px;padding:10px\"><div>出版社：<a href=\"search.php?searchnr=".$row['press']."&press=on\">".$row['press']."</a>&nbsp;&nbsp;&nbsp;出版日期：<a href=\"search.php?searchnr=".$row['publictime']."&publictime=on\">".$row['publictime']."</a></div></td></tr>
            <tr><td style=\"height:40px;padding:10px\"><div>ISBN码：<a href=\"search.php?searchnr=".$row['isbn']."&isbn=on\">".$row['isbn']."</a>&nbsp;&nbsp;&nbsp;价格：".$row['price']."&nbsp;&nbsp;&nbsp;索书号：".$row['identifier']."</div></td></tr>
            <tr><td style=\"height:40px;padding:10px\"><div>来源：".$row['origin']."</div></td></tr>
            <tr><td></td><td>简介：<div class=\"summary\">";

        if($row['summary']==NULL){
            echo "暂无简介";
        }else{
            echo $row['summary'];
        }
        
        echo "</div></td></tr>
        </table>
        <div style=\"padding:20px\">相关专业：<a href=\"search.php?searchnr=".$row['major']."&major=on\">".$row['major']."</a></div>
        <div style=\"padding:20px\">标签：";

        if($row['tags']==NULL){
            echo "暂无标签";
        }else{
            $pattern="/[，|,]/";
            $spr=preg_split($pattern, $row['tags'],-1,PREG_SPLIT_NO_EMPTY);
            foreach($spr as $sprr){
                echo "<a href=\"search.php?searchnr=".$sprr."&tags=on\">".$sprr."</a>&nbsp;&nbsp;&nbsp;";
            }
        }
        
        echo "</div>
        <div style=\"padding:20px\">借出记录：";

        if($row['borrowtags']==NULL){
            echo "无人借阅,借来看看吧~";
        }else{
            echo $row['borrowtags'];
        }

        if(!empty($_COOKIE['User'])&&!empty(preg_match("/.*".$row1['name'].".*/",$row['borrowtags'],$dir))){
            $ibtb=1;
        }
        
        echo "</div>
        <div style=\"padding:20px\">";

        if(!empty($_COOKIE['User'])){
            $ihrc=0;
            $sql2 = "SELECT * FROM NeceMessage WHERE username = ".$_COOKIE['User'];
            $res1 = $dbh1->query($sql2);
            foreach($res1 as $row1){
                if($row1['nowtype']>-1){
                    $ihrc=1;
                }
            }
            if($ihrc){
                if($ibtb){
                    setcookie('rtbook',1);
                    echo "<a href=\"rtbook.php?bookid=".$row['id']."\"><button><font color=green>还书</font></button></a>";
                }else{
                    if($row['booknumber']-$row['borrownumber']>0){
                        if((($row1['major']==$row['major'])&&($row1['mbtimes']>0))||(($row1['major']!=$row['major'])&&($row1['umbtimes']>0))){
                            echo "<a href=\"borrowbook.php?bookid=".$row['id']."\"><button><font color=green>借书</font></button></a>";
                        }else{
                            if($row1['major']==$row['major']){
                                echo "专业书借阅已达20本，请先归还已借阅的图书";
                            }else{
                                echo "非专业书借阅已达10本，请先归还已借阅的图书";
                            }
                        }
                    }
                }
            }
            if($_COOKIE['Adm']){
                echo "<form action=\"changebook.php\" method=\"post\">
                <input style=\"display:none\" type=\"text\" name=\"bookid\" value=".$row['id'].">
                <button><font color=red>修改书籍信息</font></button></form>
                <div align=right><a href=\"delbook.php?bookid=".$row['id']."\"><button><font color=red>删除书籍</font></button></a></div>";
            }
        }

        echo "</div>
    </div>";
    }

?>