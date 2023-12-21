<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <header>
        <h2>Πόσα Άτομα?</h2>
        </header>
        <section>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            Capacity: <input type="text" name="cap">
            <input type="submit" name="Set">
        </form>
        
        </section>
        <?php
            $error="";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $d=$_POST['cap'];
                $p=intval($d);
                if(intval($p>0)){
                    setcookie("capacity",$d);//Save Capacity in cookie, it uses from orderTableSelector
                    header("Location: orderTableSelector.php");//Moove to orderTableSelector
                }else{
                    echo " *Set a Capacity";
                }

            }
        
        
        ?>
        
    </body>
</html>