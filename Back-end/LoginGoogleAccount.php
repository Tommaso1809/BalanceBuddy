<?php
require_once __DIR__ . '/vendor/autoload.php';

session_start();

// Database connection settings
$db_host = "localhost";
$db_name = "balancebuddy_db";
$db_user = "root";
$db_pass = "";

// Google API settings
$client_id = '878030414701-gcvrcv2m94el0iid34tdldvejll0kkqc.apps.googleusercontent.com';
$client_secret = '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';
$redirect_uri = 'http://localhost/home.php';

// Create Google API client
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope('email');
$client->addScope('profile');

// Check if user has logged in
if (isset($_SESSION['access_token'])) {
    // Connect to the MySQL database
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

    // Get the user's profile information
    $oauth = new Google_Service_Oauth2($client);
    $google_info = $oauth->userinfo->get();
    $email = $google_info->email;
    $google_id = $google_info->id;

    // Check if user exists in the database
    $query = $db->prepare("SELECT * FROM accounts WHERE google_id = :google_id LIMIT 1");
    $query->bindParam(':google_id', $google_id);
    $query->execute();
    $user = $query->fetch();

    // If user doesn't exist, insert them into the database
    if (!$user) {
        $query = $db->prepare("INSERT INTO accounts (google_id, email) VALUES (:google_id, :email)");
        $query->bindParam(':google_id', $google_id);
        $query->bindParam(':email', $email);
        $query->execute();
        $user = $db->query("SELECT * FROM accounts WHERE google_id = $google_id")->fetch();
    }

    // Display user information
    echo "Welcome, " . $user['email'] . ". Your user ID is: " . $user['id'] . ". <a href='logout.php'>Logout</a>";

    // Close the database connection
    $db = null;
} else {
    // Redirect user to the Google login page
    $auth_url = $client->createAuthUrl();
    header("Location: $auth_url");
    exit;
}

?>