<?php
$heading = "NOTE";


$config = require("config.php");
$id = 1;
$db = new Database($config['database']);
$query = "SELECT * FROM notes WHERE user_id = :id";
$notes = $db->query($query, [':id' => $id])->get();

require "view/view.note.php";
