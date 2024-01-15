<?php
if(isset($_POST['id'])){
    require '../db_conn.php';
    $id = $_POST['id'];

    if(empty($id)){
        echo 'error';
    }else{
        $todos = $conn->prepare("select id, checked from todos where id=?");
        $todos->execute(([$id])); 

        $todo = $todos->fetch();
        $uId = $todo['id'];
        $checked = $todo['checked'];
        $uChecked = $checked ? 0:1;

        $res = $conn->query("update todos set checked=$uChecked where id=$uId");

        if($res){
            echo $checked;
        }else{
            echo "error";
        }
        $conn = null;
        exit();
    }
}else{
    header("location: ../index.php?mess=error");
}
