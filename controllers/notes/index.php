<?php
use Core\Database;
use Core\App;
//$config = require base_path("config.php");
//$db = new Database($config['database']);

$db = App::container()->resolve('Core\Database');
dd($db);

$id = 1;
$query = "SELECT * FROM notes WHERE user_id = :id";
$notes = $db->query($query, [':id' => $id])->get();

view ("/notes/notes.view.php", ['heading' => 'My Notes', 'notes' => $notes]);

