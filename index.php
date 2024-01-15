<?php
require 'db_conn.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="main-section">
        <!-- form sesction start -->
        <div class="add-section">
            <form action="app/add.php" method="post" autocomplete="off" >
                <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error' ) { ?>
                    <input type="text" name="title" placeholder="This field is required" style="border-color: #ff6666;" >
                    <button>Add &nbsp; <span>&#43;</span></button>
                <?php } else { ?>    
                    <input type="text" name="title" placeholder="What do you want to do?">
                    <button>Add &nbsp; <span>&#43;</span></button>
                <?php } ?>    
            </form>
        </div>
        <!-- form section end -->
        <!-- show todo section start -->
        <?php
            $todos = $conn->query("select * from todos order by id desc");
        ?>
        <div class="show-todo-section">
            <!-- if todo list is empty start -->
            <?php if($todos->rowCount() <= 0) { ?>
                <div class="todo-item">
                    <div class="empty">
                        <img src="img/f.png" width="100%">
                        <img src="img/Ellipsis.gif" width="80px">
                    </div>
                </div> 
            <?php } ?> 
            <!-- if todo list is empty end -->
            
            <!-- if todo list contains task start -->
            <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
            <div class="todo-item">
                <span id="<?php echo $todo['id']; ?>" class="remove-to-do" >x</span>
                <?php if($todo['checked']) { ?>
                    <input type="checkbox" class="check-box" checked 
                    data-todo-id = "<?php echo $todo['id']; ?>"
                    >
                    <h2 class="checked"><?php echo $todo['title']; ?></h2>
                <?php } else { ?>    
                    <input type="checkbox" class="check-box" 
                    data-todo-id = "<?php echo $todo['id']; ?>"
                    >
                    <h2><?php echo $todo['title']; ?></h2>
                <?php } ?>    
                <br>
                <small>created: <?php echo $todo['date_time'] ?></small>
            </div> 
            <?php } ?>
            <!-- if todo list contains task end -->
        </div>
        <!-- show todo section end -->
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('.remove-to-do').click(function(){
            const id = $(this).attr('id')
                $.post('app/remove.php',
                {
                    id: id
                },
                (data)=>{
                    $(this).parent().hide(600)
                }
            )
        })

        $(".check-box").click(function(e){
            const id = $(this).attr('data-todo-id');
            $.post('app/check.php',
                {
                    id: id
                },
                (data)=>{
                    if(data != 'error'){
                        const h2 = $(this).next()
                        if(data === '1'){
                            h2.removeClass('checked')
                        }else{
                            h2.addClass('checked')
                        }
                    }
                }
            )
        })
    })
</script>
</html>