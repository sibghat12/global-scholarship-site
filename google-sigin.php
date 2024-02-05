<?php

require_once dirname( __FILE__, 1 ) . '/vendor/autoload.php';

add_action('template_redirect', function() {
    if (strpos($_SERVER['REQUEST_URI'], '/google-auth') !== false) {
        my_handle_google_auth();
        exit;
    }
});
function my_handle_google_auth() {
    if (empty($_GET['credential'])) {
        // Handle error: No credential provided
        wp_redirect(home_url());
        exit;
    }

    $id_token = $_GET['credential'];
    $client = new Google_Client(['client_id' => '332720383708-1t60jqsr5dsjeh4s0cphk8f6hta4u10l.apps.googleusercontent.com']); // Specify the CLIENT_ID
    $payload = $client->verifyIdToken($id_token);

    if ($payload) {
        $user_id = $payload['sub']; // Google user ID

        // Proceed to authenticate or create a WordPress user
        // Example: Check if a WordPress user with this Google user ID exists

        wp_redirect(home_url()); // Redirect to the homepage or dashboard
        exit;
    } else {
        // Invalid ID token
        wp_redirect(home_url('/login?error=invalid_token')); // Redirect to a login page with an error
        exit;
    }
}


// $CLIENT_ID = "332720383708-1t60jqsr5dsjeh4s0cphk8f6hta4u10l.apps.googleusercontent.com";

// $client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify your client ID
// $payload = $client->verifyIdToken($_POST['token']);
// if ($payload) {
//     $userId = $payload['sub'];
//     echo '<pre>';
//     print_r($userId);
//     echo '</pre>';
    
//     // Check if this Google user exists in your WordPress database
//     // Log the user in or create a new user account as necessary
// } else {
//     // Invalid ID token
//     die('Token verification failed.');
// }


// $client = new Google_Client(['client_id' => $CLIENT_ID]); // Ensure you have the correct client ID here
// $id_token = $_POST['token'];
// try {
//     $payload = $client->verifyIdToken($id_token);
//     if ($payload) {
//         $userid = $payload['sub'];
//         // Proceed with user verification and authentication
//     } else {
//         // Invalid ID Token
//         die('Invalid ID Token');
//     }
// } catch (Exception $e) {
//     die('Exception caught: ' . $e->getMessage());
// }


// /**
//  * @throws \Google\Exception
//  */
// function getClient() {
// 	$client = new Google_Client();

// 	$client->setApplicationName( 'Google Sheets and PHP' );

// 	$client->setScopes( array( Google_Service_Sheets::SPREADSHEETS ) );

// 	$client->setAccessType( 'offline' );

// 	$client->setAuthConfig( __DIR__ . '/credentials.json' );

// 	return $client;
// }

// /**
//  * @throws \Google\Exception
//  */
// function getValuesGS() {
// 	$authorization_group = get_field( 'sync_authorization_data', 'options' );
// 	$spreadsheet_id      = $authorization_group['spreadsheet_id'];
// 	$sheet_range         = $authorization_group['sheet_range'];

// 	$client  = getClient();
// 	$service = new Google_Service_Sheets( $client );

// 	$spreadsheetId = $spreadsheet_id; //It is present in your URL

// 	$get_range = $sheet_range;
// 	//Request to get data from spreadsheet.

// 	$response = $service->spreadsheets_values->get( $spreadsheetId, $get_range );

// 	$values = $response->getValues();

// 	return $values;
// }

