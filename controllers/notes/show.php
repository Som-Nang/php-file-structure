<?php
use Core\Database;

$config = require base_path("config.php");
$id = $_GET['id'];
$db = new Database($config['database']);

$currentUser = 1;
$forbidden = 403;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "SELECT notes.*, user.name FROM notes
                              JOIN user ON user.id = notes.user_id
                              WHERE notes.id = :id";
    $note = $db->query($query, [':id' => $id])->findOrFail();

    if (!$note) {
        abort();
    }
    authorize($note['user_id'] === $currentUser);

      $db->query('DELETE FROM notes WHERE id = :id',[
          'id' => $id
      ]);

      header('location: /notes');
      exit();

} else {
    $query = "SELECT notes.*, user.name FROM notes
                              JOIN user ON user.id = notes.user_id
                              WHERE notes.id = :id";
    $note = $db->query($query, [':id' => $id])->findOrFail();

    if (!$note) {
        abort();
    }
    authorize($note['user_id'] === $currentUser);

    view ("/notes/note-show.view.php", [
            'heading' => 'Note',
            'note' => $note
        ]
    );

}
