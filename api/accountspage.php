<?php 

$db = SQLite3('/tmp/db.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

$visits = $db->querySingle('SELECT count(user) FROM "cipher"');

var_dump($visits);
echo("value: $visits");

$db->close();


?>