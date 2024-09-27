
    <?php
    use Core\Database;
    use Core\Validation;

//    require base_path("Core/validation.php");

    $config = require base_path("config.php");
    $id = 1;

    // $validation = new Validation;
    $db = new Database($config['database']);

    // dd(! Validation::email('somnangmega13.com'));
    $error = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        if (!Validation::string($_POST['body'], 1, 100)) {
            $error['body'] = 'body is required or can not more than 100';
        }


        if (empty($error)) {
            $db->query("INSERT INTO notes (body, user_id) VALUES (:body, :user_id)", [
                ':body' => $_POST['body'],
                ':user_id' => 1,
            ]);
        }
    }
    view ("/notes/note-create.view.php", [
            'heading' => 'Creat Notes',
            'error' => $error,
        ]
    );
