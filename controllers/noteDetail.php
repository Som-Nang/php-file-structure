<?php
$heading = "NOTE DETAIL";

$config = require("config.php");
$id = $_GET['id'];
$db = new Database($config['database']);
$query = "SELECT notes.*, user.name FROM notes
                          JOIN user ON user.id = notes.user_id
                          WHERE notes.id = :id";
$note = $db->query($query, [':id' => $id])->findOrFail();
$currentUser = 1;
$forbidden = 403;

if (!$note) {
    abort();
}
authorize($note['user_id'] === $currentUser);
require "view/view.noteDetail.php";
