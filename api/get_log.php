<?php
    session_start();
    //Если жетона безопасности (т.е., в нашем случае, переменная с названием user)
    // нет? "не пущаем"
    if (!isset($_SESSION["user"])) {
        echo('<meta http-equiv="refresh" content="2; URL=../login.php">');
        die("Требуется логин");
    }

    $user = $_SESSION["user"];

    //echo getenv('MYAPP_CONFIG');
    include (getenv('MYAPP_CONFIG'));
            
            //Оставим уязвимость SQL-Injection для спортивных упражнений
            $sql = "SELECT ID, Number1, Number2, Result, UserID
             FROM log
             WHERE UserID='$user'
            ";


            $conn = mysqli_connect($DB_URL,$DB_USER,$DB_PWD,$DB_NAME);
            // нудная, но необходимая процедура передачи параметров в sql выражение,
            // что гарантирует защиту от sql-injection.
            $statement = mysqli_prepare($conn, $sql);
            mysqli_stmt_execute($statement);
            echo(mysqli_error($conn));
            $cursor = mysqli_stmt_get_result($statement);
            $result = mysqli_fetch_all($cursor);

            echo(mysqli_error($conn));
            
            mysqli_close($conn);

            //var_dump($result);
            echo(json_encode($result));
            
        ?>
 