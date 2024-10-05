<?php
use Core\App;
use Core\Validation;
use Core\Database;

$db = App::resolve(Database::class);
$errors = [];
$data = [];
if (! Validation::string($_POST['body'], 1, 1000)) {
    $errors['body'] = 'A body of no more than 1,000 characters is required.';
}

if (! empty($errors)) {
  $data = array(
        'heading' => 'Create Note',
        'status' => $errors
  );
}else{
    $db->query('INSERT INTO notes(body, user_id) VALUES(:body, :user_id)', [
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