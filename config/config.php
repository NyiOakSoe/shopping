<?php

$pdo=new pdo('mysql:dbhost=localhost;dbname=shop','root','',[
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING
]);