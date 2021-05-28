<?php 
session_start();
require_once("vendor/autoload.php");
require_once("functions.php");

use Hcode\Model\User;

$app = new \Slim\Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Hcode\Page();

	$page->setTpl("index");

});

$app->get('/admin', function() {
    
	User::verifyLogin();

	$page = new Hcode\PageAdmin();

	$page->setTpl("index");

});

$app->get('/admin/login', function() {
    
	$page = new Hcode\PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("login");

});

$app->post('/admin/login', function() {

	User::login(post('deslogin'), post('despassword'));

	header("Location: /admin");
	exit;

});

$app->get('/admin/logout', function() {

	User::logout();

	header("Location: /admin/login");
	exit;

});

$app->get("/admin/users", function(){

	User::verifylogin();

	$users = User::listAll();
	$page = new Hcode\PageAdmin();

	$page->setTpl("users", array(
		"users"=>$users
	));

});

$app->get("/admin/users/create", function(){

	User::verifylogin();

	$page = new Hcode\PageAdmin();

	$page->setTpl("users-create");

});

$app->get("/admin/users/:iduser/delete", function($iduser){

	User::verifylogin();
	

});


$app->get("/admin/users/:iduser", function($iduser){

	User::verifylogin();

	$page = new Hcode\PageAdmin();

	$page->setTpl("users-update");

});

$app->post("/admin/users/create", function () {

	User::verifyLogin();

    $user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

	$_POST['despassword'] = password_hash($_POST["despassword"], PASSWORD_DEFAULT, [

		"cost"=>12

	]);

	$user->setData($_POST);

    $user->save();



});

$app->post("/admin/users/:iduser", function($iduser){

	User::verifylogin();
	

});


$app->run();

?>