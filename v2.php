<?php 
error_reporting(0);
echo "

           _             _       _____ _____  
     /\   | |           | |     |_   _|  __ \ 
    /  \  | | ____ _ ___| |__     | | | |  | |
   / /\ \ | |/ / _` |_  / '_ \    | | | |  | |
  / ____ \|   < (_| |/ /| | | |  _| |_| |__| |
 /_/    \_\_|\_\__,_/___|_| |_| |_____|_____/ 
        -----------------------------    
            MASS EMAIL GRABBER V.2
        -----------------------------                              
  Facebook:  https://facebook.com/justakazh
  Github  :  httos://github.com/justakazh
    
  *Want to recode? Don't forget Copyright dude!                                            



";


$host = $argv[1];
$user = $argv[2];
$pass = $argv[3];
$db = $argv[4];

$conn = mysqli_connect($host, $user, $pass) or die("gagal  konek");
$q1 = mysqli_query($conn, "SHOW DATABASES");
while ($database = mysqli_fetch_array($q1)) {
    $q2 = mysqli_query($conn, "SHOW TABLES FROM ".$database['Database']);
    while ($table  = mysqli_fetch_array($q2)) {
        $q3 = mysqli_query($conn, "SHOW COLUMNS FROM ".$database['Database'].".".$table["Tables_in_".$database['Database']]." IN ". $database['Database']);
        while ($columns = mysqli_fetch_array($q3)) {
            if(preg_match("/email/", $columns['Field'])){

                $final_query = mysqli_query($conn, "SELECT ".$columns["Field"]." FROM ".$database['Database'].".".$table['Tables_in_'.$database['Database']]);
                while ($email = mysqli_fetch_array($final_query)) {
                    if (strstr($email[$columns['Field']], "@")) {
                        echo $email[$columns['Field']]."\n";
                        $file = "result-mail.txt";
                        $f = fopen($file, "a");
                        fwrite($f, $email[$columns['Field']]."\n");
                    }
                }

            }
        }
    }
}
?>
