<?php
if(isset($_POST['title'])){
    require '../db_conn.php';
    $title = $_POST['title'];

    if(empty($title)){
        header("location: ../index.php?mess=error");
    }else{
        $stmt = $conn->prepare("insert into todos(title) value(?)");
        $res = $stmt->execute(([$title])); 

        if($res){
            header("location: ../index.php?mess=success");
        }else{
            header("location: ../index.php");
        }
        $conn = null;
        exit();
    }
}else{
    header("location: ../index.php?mess=error");
}

?>