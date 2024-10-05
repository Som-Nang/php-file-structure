<?php

namespace Http\Controllers;

use Core\App;
use Core\Database;
use Core\Validation;

class NoteController
{
    protected $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }
    public function index()
    {
        $id = $_SESSION['user']['userID'];
        // Code for listing notes

        $query = "SELECT * FROM notes WHERE user_id = :id";
        $notes = $this->db->query($query, [':id' => $id])->get();

         view("/notes/notes.view.php", [
            'heading' => 'My Notes',
            'notes' => $notes
        ]);
    }

    public function show()
    {
        $currentUserId = $_SESSION['user']['userID'];

        $note = $this->db->query('select * from notes where id = :id', [
            'id' => $_GET['id']
        ])->findOrFail();

        authorize($note['user_id'] === $currentUserId);

        view("notes/note-show.view.php", [
            'heading' => 'Note',
            'note' => $note
        ]);
    }

    public function create()
    {
        view("notes/note-create.view.php", [
            'heading' => 'Create Note',
            'errors' => []
        ]);
    }

    public function store()
    {
        if (! Validation::string($_POST['body'], 1, 1000)) {
            $errors['body'] = 'A body of no more than 1,000 characters is required.';
        }

        if (! empty($errors)) {
            $data = array(
                'heading' => 'Create Note',
                'status' => $errors
            );
        }else{
            $this->db->query('INSERT INTO notes(body, user_id) VALUES(:body, :user_id)', [
                'body' => $_POST['body'],
                'user_id' =>  $_SESSION['user']['userID']
            ]);

            $data = array(
                'heading' => 'Create Note',
                'status' => 'success'
            );
        }

        header('Content-Type: application/json');
        echo json_encode($data);

        die();
    }

    public function edit()
    {
        $currentUserId = $_SESSION['user']['userID'];

        $note = $this->db->query('select * from notes where id = :id', [
            'id' => $_GET['id']
        ])->findOrFail();

        authorize($note['user_id'] === $currentUserId);

        view("notes/note-edit.view.php", [
            'heading' => 'Edit Note',
            'errors' => [],
            'note' => $note
        ]);
    }

    public function update()
    {
        $currentUserId = $_SESSION['user']['userID'];

    // find the corresponding note
            $note = $this->db->query('select * from notes where id = :id', [
                'id' => $_POST['id']
            ])->findOrFail();

    // authorize that the current user can edit the note
            authorize($note['user_id'] === $currentUserId);

    // validate the form
            $errors = [];

            if (! Validation::string($_POST['body'], 1, 1000)) {
                $errors['body'] = 'A body of no more than 1,000 characters is required.';
            }

    // if no validation errors, update the record in the notes database table.
            if (count($errors)) {
                 view('notes/note-edit.view.php', [
                    'heading' => 'Edit Note',
                    'errors' => $errors,
                    'note' => $note
                ]);
            }

            $this->db->query('update notes set body = :body where id = :id', [
                'id' => $_POST['id'],
                'body' => $_POST['body']
            ]);

    // redirect the user
            header('location: /notes');
            die();
    }

    public function destroy()
    {
        $currentUserId = $_SESSION['user']['userID'];

        $note = $this->db->query('select * from notes where id = :id', [
            'id' => $_POST['id']
        ])->findOrFail();

        authorize($note['user_id'] === $currentUserId);

        $this->db->query('delete from notes where id = :id', [
            'id' => $_POST['id']
        ]);

        header('location: /notes');
        exit();
    }
}