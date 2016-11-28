<?php
ini_set('display_errors', '1');
require 'vendor/autoload.php';

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

session_start();

// Instantiate the app
$settings = require __DIR__ . '/src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/src/dependencies.php';

// Register routes
require __DIR__ . '/src/routes.php';


// Run app
$app->run();





////////////////////////////////////////////////////
//////////////////     USERS     ///////////////////
////////////////////////////////////////////////////


//
// $app->post('/users',function($request, $response){
//     // global $database;
//
// 	if( isset($_POST['name']) ){
//     return $response->write( json_encode( array("name" => $_POST['name']) ) );
//   }
	// {
	// 	$user_name = $_POST['user_name'];
	//
	// 	$previous_user = $database->query("SELECT * FROM Users WHERE user_name='$user_name'");
	//
	// 	if( $previous_user->num_rows > 0 ) //user already exists with that user_name
	// 	{
	// 		return $response->write( json_encode( array("error" => -1) ) );
	// 	}
	// 	else
	// 	{
	// 		$database->query("INSERT INTO Users(user_name) VALUES('$user_name')");
	//
	// 		$new_user = $database->query("SELECT * FROM Users WHERE user_name='$user_name'");
	//
	// 		if( $new_user->num_rows > 0 ) //success
	// 		{
	// 			return $response->write( json_encode( array("user" => $new_user->fetch_assoc()) ) );
	// 		}
	// 		else //query must have failed
	// 		{
	// 			return $response->write( json_encode( array("error" => -2) ) );
	// 		}
	// 	}
	// }

// 		return $response->write( json_encode( array("error" => -3) ) );
// });
//
// $app->get('/users',function($request, $response){
//     return $response->write( json_encode( array("working" => 1) ) );
//
//
// });



?>
