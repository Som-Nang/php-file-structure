<?php
namespace Http\Controllers;
class HomeController
{
    public function index(){
        view("/index.view.php", [
            'heading' => 'Home',
        ]);
    }
    public function about(){
        view ("/about.view.php", ['heading' => 'About']);
    }
    public function contact(){
        view ("/contact.view.php", ['heading' => 'Contact']);
    }
}