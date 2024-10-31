<?php

namespace Http\Controllers;

use Core\App;
use Core\Database;
use FileUpload\FileUploadFactory;
use FileUpload\PathResolver;
use FileUpload\FileSystem;
use FileUpload\Validator;
use FileUpload\FileNameGenerator;


class UserManagement
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

        $query = "SELECT admin_users.*,tbl_dpt.dpt_name FROM admin_users
        JOIN tbl_dpt ON tbl_dpt.ID = admin_users.dpt_id";
        $users = $this->db->query($query)->get();

        $queryDpt = "SELECT * FROM tbl_dpt";
        $dpt = $this->db->query($queryDpt)->get();

        view("/UserManagement/index.view.php", [
            'heading' => 'User Management',
            'users' => $users,
            'dpt' => $dpt
        ]);
    }

    public function store()
    {
        $message = 'success';
        $roleAuthFunction = '';
        if ($_POST['role'] === 'ADMIN') {
            $roleAuthFunction = \Delight\Auth\Role::ADMIN;
        } elseif ($_POST['role'] === 'EMPLOYEE') {
            $roleAuthFunction = \Delight\Auth\Role::EMPLOYEE;
        } elseif ($_POST['role'] === 'MANAGER') {
            $roleAuthFunction = \Delight\Auth\Role::MANAGER;
        }

        $factory = new FileUploadFactory(
            new PathResolver\Simple("./views/assets/profile-uploaded"),
            new FileSystem\Simple(),
            [
                new Validator\Simple('2M', ['image/png', 'image/jpg']),
            ]
        );
        // var_dump($_FILES['files']);
        $instance = $factory->create($_FILES['files'], $_SERVER);

        // Override filename logic if necessary
        $instance->setFileNameGenerator(new FileNameGenerator\Simple());

        list($files, $headers) = $instance->processAll();

        // Output headers and other information
        foreach ($headers as $header => $value) {
            header($header . ': ' . $value);
        }
        echo json_encode(['files' => $files]);

        foreach ($files as $file) {
            if ($file->completed) {
                echo $file->getRealPath();
                var_dump($file->isFile());
            }
        }



        // try {

        //     $userId = auth()->admin()->createUser(
        //         $_POST['email'],
        //         $_POST['password'],
        //         $_POST['username']
        //     );

        //     $this->db->query('UPDATE admin_users SET dpt_id = :dpt_id, description =  :description, phone_num = :phone_number, profile_pic = :profile_pic 
        //     WHERE email = :email AND username = :username', [
        //         'dpt_id' => $_POST['dpt_id'],
        //         'email' =>  $_POST['email'],
        //         'username' =>  $_POST['username'],
        //         'description' =>   $_POST['description'],
        //         'phone_number' =>  $_POST['phone_number'],
        //         'profile_pic' =>   $_POST['profile_pic'] ?? '',
        //     ]);

        //     if ($userId) {
        //         try {
        //             auth()->admin()->addRoleForUserByEmail($_POST['email'], $roleAuthFunction);
        //         } catch (\Delight\Auth\InvalidEmailException $e) {
        //             $message = 'Unknown email address';
        //         }
        //     }
        // } catch (\Delight\Auth\InvalidEmailException $e) {
        //     $message = 'Invalid email address';
        // } catch (\Delight\Auth\InvalidPasswordException $e) {
        //     $message = 'Invalid password';
        // } catch (\Delight\Auth\UserAlreadyExistsException $e) {
        //     $message = 'User already exists';
        // }

        header('Content-Type: application/json');
        echo json_encode($message);

        die();
    }
}
