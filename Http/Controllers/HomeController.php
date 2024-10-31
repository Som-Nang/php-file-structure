<?php

namespace Http\Controllers;

// use Core\Authenticator;
// use Core\Database;
// use Core\App;

class HomeController
{

    public function index()
    {

        view("/index.view.php", [
            'heading' => 'Home',
        ]);
    }
    public function about()
    {
        view("/about.view.php", ['heading' => 'About']);
    }
    public function contact()
    {
        view("/contact.view.php", ['heading' => 'Contact']);
    }
}
