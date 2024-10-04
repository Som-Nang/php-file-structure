<?php

use Core\App;
use Core\Database;
//$config = require base_path("config.php");
//$db = new Database($config['database']);

$db = App::resolve(Database::class);

$id = 1;
$query = "SELECT * FROM notes WHERE user_id = :id";
$notes = $db->query($query, [':id' => $id])->get();

view ("/notes/notes.view.php", ['heading' => 'My Notes', 'notes' => $notes]);

