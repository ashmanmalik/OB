<?php 


$db = new SQLite3('/tmp/db.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);


$visits = $db->querySingle('SELECT COUNT(id) FROM "visits"');

echo("User visits: $visits");

$db->close();

?>