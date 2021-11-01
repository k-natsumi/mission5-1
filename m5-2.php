<?php
/*---DB接続設定---*/
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    /*---テーブルの作成---*/
    $sql = "CREATE TABLE IF NOT EXISTS mission5"
    ."("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date DATETIME DEFAULT CURRENT_TIMESTAMP,"
    . "password char(10)"
    .");";
    $stmt = $pdo->query($sql);

// 削除 //
    if(!empty($_POST["delete"]) && !empty($_POST["delete_pass"])){
        $delete = $_POST["delete"];
        $delete_pass=$_POST["delete_pass"];
       
        $id = $delete;
        $password = $delete_pass;
        var_dump($password);
        $sql = 'delete from mission5 where id=:id AND password=:password';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
    }


// 編集 //
    if(!empty($_POST["edit"]) && !empty($_POST["edit_pass"])){
        $edit=$_POST["edit"];
        $edit_pass=$_POST["edit_pass"];
        $id = $edit; //変更する投稿番号
        $password = $edit_pass;
        $sql = 'SELECT * FROM mission5 WHERE id=:id AND password=:password';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            $edname= $row['name'];
            $edcom= $row['comment'];
            $ednum= $row['id'];
            
        }
    }
    
// 新規投稿 //
        if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass"])){
            if(!empty($_POST["editnumber"])){
                $hd_edit = $_POST["editnumber"];
                $edit_pass=$_POST["edit_pass"];
                $id = $hd_edit;
                $name=$_POST["name"];
                $comment=$_POST["comment"];
                $pass=$_POST["pass"];
        
                $sql = 'UPDATE mission5 SET name=:name,comment=:comment,password=:password WHERE id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindParam(':password', $pass, PDO::PARAM_STR);
                $stmt->execute();
            }else{
                
                $name=$_POST["name"];
                $comment=$_POST["comment"];
                $pass=$_POST["pass"];
                $sql = $pdo -> prepare("INSERT INTO mission5 (name, comment, password) VALUES (:name, :comment, :password)");
            //echo "Hello";
            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql -> bindParam(':password', $pass, PDO::PARAM_STR);
            //var_dump ($pass);            
            $sql -> execute();
            }
        }
        
        
?>

   
<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission5-1</title>
</head>
<body>
    <span style="font-size:  22px;">みんなのマイブーム教えてください！</span><br>
    <span style="font-size:  12px;">ちなみに、私のマイブームは色々な料理にデスソースをかけて食べることです！</span>
<form action="" method="post">
    <input type="text" name="name" placeholder="名前"
    value="<?php
        if(isset ($edname)){
                echo $edname;
            }?>">
        <br>
    <input type="text" name="comment" placeholder="コメント"
    value="<?php
            if(isset ($edcom)){
                echo $edcom;
            }?>">
    <br>
    <input type="hidden" name="editnumber" placeholder="編集判断番号"
    value="<?php
            if(isset ($edname)){
                echo $ednum;
            }?>">
    <input type="password" name="pass" placeholder="パスワード">
    <input type="submit" value="送信" name="submit"><br>
    <br>

    <input type="number" name="delete" placeholder="削除対象番号"><br>
    <input type="password" name="delete_pass" placeholder="パスワード">
    <input type="submit" value="削除" name="delete_submit"><br>
    <br>

    <input type="number" name="edit" placeholder="編集対象番号"><br>
    <input type="password" name="edit_pass" placeholder="パスワード">
    <input type="submit" value="編集" name="edit_submit">
    
    </form>

</body>
</html>


<?php
 /*---テーブルに登録されたデータを取得し、表示---*/
$sql = 'SELECT * FROM mission5';
 $stmt = $pdo->query($sql);
 $results = $stmt->fetchAll();
 foreach ($results as $row) {
     //$rowの中にはテーブルのカラム名が入る
     echo $row['id'] . ' ';
     echo $row['name'] . ' ';
     echo $row['comment'] .' ';
     echo $row['date'].'<br>';
     echo "<hr>";
 }
 ?>