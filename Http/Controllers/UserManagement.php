<?php

namespace Http\Controllers;

error_reporting(E_ALL & ~E_DEPRECATED);

use Core\App;
use Core\Database;
use Core\Validation;
use FileUpload\FileUploadFactory;
use FileUpload\PathResolver;
use FileUpload\FileSystem;
use FileUpload\Validator;
use FileUpload\FileNameGenerator;
use PharIo\Manifest\Email;

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
        $data = [];
        $message = [];
        $errors = [];

        if (! Validation::string($_POST['username'], 10, 100)) {
            $errors['username'] = 'username can content at least 10 to 100 characters .';
        }
        if (isset($_POST['password'])) {
            if (! Validation::string($_POST['password'], 6, 16)) {
                $errors['password'] = 'Password could content at least 6 to 16 characters .';
            }
        }



        if (! Validation::email($_POST['email'])) {
            $errors['email'] = 'Please enter a valid email';
        }
        if (! Validation::string($_POST['role'])) {
            $errors['role'] = 'Please select a role!';
        }
        if (! Validation::string($_POST['dpt_id'])) {
            $errors['function'] = 'Please select a function!';
        }

        if (! empty($errors)) {
            $data = array(
                'errors' => $errors
            );
        } else {
            $message = 'success';
            $roleAuthFunction = '';
            $getProfile = '';
            if ($_POST['role'] === 'ADMIN') {
                $roleAuthFunction = \Delight\Auth\Role::ADMIN;
            } elseif ($_POST['role'] === 'EMPLOYEE') {
                $roleAuthFunction = \Delight\Auth\Role::EMPLOYEE;
            } elseif ($_POST['role'] === 'MANAGER') {
                $roleAuthFunction = \Delight\Auth\Role::MANAGER;
            }

            if (isset($_FILES['files']) && !empty($_FILES['files']['name'])) {

                $fileName = $_POST['username'] . '_' . date("Y-m-d_H-i-s");
                $fileExtension = pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION);
                $fullFileName = $fileName . '.' . $fileExtension;


                $factory = new FileUploadFactory(
                    new PathResolver\Simple("./profile-uploaded"),
                    new FileSystem\Simple(),
                    [
                        new Validator\Simple('2M', ['image/png', 'image/jpg']),
                    ]
                );
                // var_dump($_FILES['files']);
                $instance = $factory->create($_FILES['files'], $_SERVER);

                // Override filename logic if necessary
                $instance->setFileNameGenerator(new FileNameGenerator\Custom($fullFileName));

                list($files, $headers) = $instance->processAll();

                // Output headers and other information
                foreach ($headers as $header => $value) {
                    header($header . ': ' . $value);
                }

                if ($files[0]->completed) {
                    $getProfile =  $files[0]->getFileName();
                }
            }
            if (isset($_POST['staffId']) && !empty($_POST['staffId'])) {
                $this->db->query('UPDATE admin_users SET 
                username = :username,
                email = :email,
                dpt_id = :dpt_id, 
                description =  :description, 
                phone_num = :phone_number
                    WHERE id = :staffId', [
                    'dpt_id' => $_POST['dpt_id'],
                    'email' =>  $_POST['email'],
                    'username' =>  $_POST['username'],
                    'description' =>   $_POST['description'],
                    'phone_number' =>  $_POST['phone_number'],
                    'staffId' => $_POST['staffId']
                ]);


                try {
                    auth()->admin()->removeRoleForUserById($_POST['staffId'],  \Delight\Auth\Role::MANAGER);
                    auth()->admin()->removeRoleForUserById($_POST['staffId'],  \Delight\Auth\Role::EMPLOYEE);
                    auth()->admin()->removeRoleForUserById($_POST['staffId'],  \Delight\Auth\Role::ADMIN);
                    auth()->admin()->addRoleForUserById($_POST['staffId'], $roleAuthFunction);
                } catch (\Delight\Auth\UnknownIdException $e) {
                    $message = 'Unknown user ID or address';
                }

                if ($getProfile != '') {
                    $this->db->query('UPDATE admin_users SET 
                    profile_pic = :profile_pic
                        WHERE id = :staffId', [
                        'profile_pic' => $getProfile,
                        'staffId' => $_POST['staffId']
                    ]);
                }
            } else {
                try {

                    $userId = auth()->admin()->createUser(
                        $_POST['email'],
                        $_POST['password'],
                        $_POST['username']
                    );

                    $this->db->query('UPDATE admin_users SET dpt_id = :dpt_id, description =  :description, phone_num = :phone_number, profile_pic = :profile_pic 
                WHERE email = :email AND username = :username', [
                        'dpt_id' => $_POST['dpt_id'],
                        'email' =>  $_POST['email'],
                        'username' =>  $_POST['username'],
                        'description' =>   $_POST['description'],
                        'phone_number' =>  $_POST['phone_number'],
                        'profile_pic' =>   $getProfile,
                    ]);

                    if ($userId) {
                        try {
                            auth()->admin()->addRoleForUserByEmail($_POST['email'], $roleAuthFunction);
                        } catch (\Delight\Auth\InvalidEmailException $e) {
                            $message = 'Unknown email address';
                        }
                    }
                } catch (\Delight\Auth\InvalidEmailException $e) {
                    $message = 'Invalid email address';
                } catch (\Delight\Auth\InvalidPasswordException $e) {
                    $message = 'Invalid password';
                } catch (\Delight\Auth\UserAlreadyExistsException $e) {
                    $message = 'User already exists';
                }
            }


            $data = array(
                'message' => $message
            );
        }


        header('Content-Type: application/json');
        echo json_encode($data);


        die();
    }

    public function edit()
    {
        $staffId = $_GET['staffId'];
        $html = '';


        $queryDpt = "SELECT * FROM tbl_dpt";
        $dpt = $this->db->query($queryDpt)->get();

        $query = "SELECT admin_users.*,tbl_dpt.dpt_name,tbl_dpt.ID AS dptId FROM admin_users
        JOIN tbl_dpt ON tbl_dpt.ID = admin_users.dpt_id WHERE admin_users.id = :staffId";
        $staff = $this->db->query($query, ['staffId' => $staffId])->get();

        if (!empty($staff)) {
            $html .= '<div class="relative p-4 w-full  max-w-7xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Create New Staff
                        </h3>
                        <button type="button" id="closeModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" >
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form class="p-4 md:p-5">
                        <div class="flex">
                            <div class="w-1/3 flex items-start justify-center">
                                <div class="profile-pic">
                                    <label class="-label" for="fileEdit">
                                        <span class="glyphicon glyphicon-camera"></span>
                                        <span>Change Image</span>
                                    </label>
                                    <input id="fileEdit" name="propic" type="file" onchange="loadFileEdit(event)" accept="image/*" />
                                    <img src="' . ($staff[0]['profile_pic'] != NULL ? '/public/profile-uploaded/' . $staff[0]['profile_pic'] : 'https://media.istockphoto.com/id/1337144146/vector/default-avatar-profile-icon-vector.jpg?s=612x612&w=0&k=20&c=BIbFwuv7FxTWvh5S3vB6bkT0Qv8Vn8N5Ffseq84ClGI=') . '" id="outputEditFile" width="200" />
                                </div>
                            </div>

                            <div class="grid gap-4 mb-4 grid-cols-2 w-full">
                                <div class="col-span-2">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                                    <input value="' . ($staff[0]['username'] ?? '') . '"type="text" name="name" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Username" required="">
                                    <label for="name" id="error_username" class="text-red-500 text-sm hidden"></label>
                                </div>
                                <div class="col-span-2">
                                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone Number</label>
                                    <input value="' . ($staff[0]['phone_num'] ?? '') . '" type="number" name="phone" id="phone_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Phone Number" required="">
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                    <input value="' . ($staff[0]['email'] ?? '') . '"type="text" name="email" id="email" class="bg-gray-50 border border-danger-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Email" required="">
                                    <label for="email" id="error_email" class="text-red-500 text-sm hidden"></label>
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                    <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Password" required="">
                                    <label for="password" id="error_password" class="text-red-500 text-sm hidden"></label>
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                                    <select id="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option selected>' . array_values(auth()->admin()->getRolesForUserById($staffId))[0] . '</option>
                                        <option value="EMPLOYEE">EMPLOYEE</option>
                                        <option value="MANAGER">MANAGER</option>
                                        <option value="ADMIN">ADMIN</option>

                                    </select>
                                    <label for="role" id="error_role" class="text-red-500 text-sm hidden"></label>
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="dpt_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
                                    <select id="dpt_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option value="' . $staff[0]['dptId'] . '">' . $staff[0]['dpt_name'] . '</option>';
            foreach ($dpt as $key => $item):
                $html .= '<option value="' . $item['ID'] . '">' . $item['dpt_name'] . '</option>';
            endforeach;
            $html .= '</select>
                                    <label for="dpt_id" id="error_function" class="text-red-500 text-sm hidden"></label>
                                </div>
                                <div class="col-span-2">
                                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                    <textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write description here">' . ($staff[0]['description'] ?? '') . '</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="w-full flex items-end justify-end">
                            <button type="button" id="save" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                Save
                            </button>
                        </div>

                    </form>
                </div>
            </div>
            
            ';
        }
        $data = array(
            'html' => $html,
        );

        // Encode the response data as JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function destroy()
    {
        if (isset($_POST['deleteID']) && !empty($_POST['deleteID'])) {
            $message = 'success';

            if (auth()->admin()->doesUserHaveRole($_POST['deleteID'], \Delight\Auth\Role::ADMIN)) {
                $message  = 'ADMIN can not be delete!';
            } else {
                try {
                    auth()->admin()->deleteUserById($_POST['deleteID']);
                } catch (\Delight\Auth\UnknownIdException $e) {
                    $message  = 'Unknown ID';
                }
            }



            header('Content-Type: application/json');
            echo json_encode($message);

            die();
        }
    }
}
