<?php
// $host = 'sql105.infinityfree.com';
// $dbname = 'if0_41914146_biblio'; 
// $username = 'if0_41914146';
// $password = 'JMWqbcFw6P'; 



$db = mysqli_connect("sql105.infinityfree.com","if0_41914146","JMWqbcFw6P","if0_41914146_biblio");
if(!$db){
        die("connection failed :" . mysqli_connect_error());
}

// Automatiquement créer les tables si elles n'existent pas
include_once "init_db.php";
initializeDatabase($db);


?>