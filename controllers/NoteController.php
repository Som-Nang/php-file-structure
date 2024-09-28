<?php

namespace Controller;
use Core\App;
use Core\Database;

class NoteController
{
    protected $db;

    public function __construct()
    {
        $this->db =  App::resolve(Database::class);
    }

    public function index(){
        $id = 1;
        $query = "SELECT * FROM notes WHERE user_id = :id";
        $notes = $this->db->query($query, [':id' => $id])->get();

        view ("/notes/notes.view.php", ['heading' => 'My Notes', 'notes' => $notes]);
    }
}