<?php 

$db = new SQLite3('/tmp/db.sqlite');

var_dump($db->querySingle('SELECT count(id) from cipher'));

$db->close();


?>