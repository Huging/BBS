<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>帖子管理</title>
    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- 可选的Bootstrap主题文件（一般不使用） -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"></script>

    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="background: #eeeef2">
<?php
/*
 * session里的name 获取id；
 * */
require_once '../DataBase.php';
session_start();
$name=$_SESSION['name'];
$sql_user="select Id from user where UserName ='$name'";   //从session里获取Id
foreach ($conn->query($sql_user) as $row){
    $ID=$row['Id'];
    break;
}
//print_r($as);
//echo $as['Id'];
$sql="select * from contents where user_id='$ID'";      //输出id对应的帖子
//foreach ($conn->query($sql)as $row){
//    echo $row['title'].'<br>';
//    echo $row['contents_str'].'<br>';
//    echo $row['date'].'<br>';
//}
if(!empty($_POST['sub'])){
    $ID=$_POST['id'];
    $sql_del_contents="delete from contents where id='$ID'";        //
    $sql_del_comment="delete from comment where contents_id='$ID'";        //
//    echo $sql_del_contents.$sql_del_comment;
    if ($conn->exec($sql_del_comment)||$conn->exec($sql_del_contents)){
        echo "<script>alert('删除成功')</script>";
    }
//    $conn->exec($sql_del_comment).'<br>';
//    $conn->exec($sql_del_contents);
}
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <!--标题-->
        <h3 class="panel-title" style="text-align: center;">
            <a href="../login.php" style="float: left;"><span class="glyphicon glyphicon-user"></span></a>
            <a href="../index.php"><span class="glyphicon glyphicon-home"></span></a>
            <a href="../add.php" style="float: right;"><span class="glyphicon glyphicon-edit"></span></a>
        </h3>
    </div>
    <div class="panel-body" style="padding: 10px">
        <div class="panel panel-default" style="margin-bottom: 10px">
            <div class="panel-heading">
                <h3 class="panel-title">
                    我的发帖
                </h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <tr>
                        <th style="width: 25%">ID</th>
                        <th>标题</th>
                        <th>操作</th>
                    </tr>
                    <tbody>
                    <?php
                    foreach ($conn->query($sql)as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row['Id'] ?></td>
                            <td><?php echo iconv_substr($row['title'],5,10) ?>...</td>
                            <td>
                                <form action="MyCard.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $row['Id'] ?>">
                                    <input type="submit" class="btn" value="删除" name="sub">|
                                    <a href="edit.php?id=<?php echo $row['Id']?>"><input type="button" class="btn" value="编辑"></a></td>
                                </form>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>