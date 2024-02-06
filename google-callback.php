<?php
// require_once dirname( __FILE__, 1 ) . '/vendor/autoload.php';
/*

add_action('template_redirect', function() {
    if (strpos($_SERVER['REQUEST_URI'], '/google-auth') !== false) {
        my_handle_google_auth();
        exit;
    }
});

function my_handle_google_auth() {
    if (empty($_GET['credential'])) {
        // Handle error: No credential provided
        wp_redirect(home_url('/login?error=no_credential'));
        exit;
    }

    $client = new Google_Client(['client_id' => '332720383708-1t60jqsr5dsjeh4s0cphk8f6hta4u10l.apps.googleusercontent.com']); 
    $id_token = $_GET['credential'];
    $payload = $client->verifyIdToken($id_token);

    if ($payload) {
        $email = $payload['email']; 
        $user = get_user_by('email', $email);

        if (!$user) {
            // No existing user, create a new one
            $user_id = wp_create_user($email, wp_generate_password(), $email);
            if (!is_wp_error($user_id)) {
                // Update user's name based on Google account information
                wp_update_user([
                    'ID'          => $user_id,
                    'first_name'  => $payload['given_name'],
                    'last_name'   => $payload['family_name'],
                    'nickname'    => $payload['name'],
                    'display_name'=> $payload['name'],
                ]);

                // Assign a default membership to the new user
                // my_assign_default_membership($user_id);

                // Log the new user in
                // wp_set_current_user($user_id);
                // wp_set_auth_cookie($user_id);

                wp_redirect(home_url());
                exit;
            } else {
                wp_redirect(home_url('/login?error=registration_failed'));
                exit;
            }
        } else {
            // Existing user, log them in
            // wp_set_current_user($user->ID);
            // wp_set_auth_cookie($user->ID);

            wp_redirect(home_url());
            exit;
        }
    } else {
        // Invalid ID token
        wp_redirect(home_url('/login?error=invalid_token'));
        exit;
    }
}
*/
// function my_assign_default_membership($user_id) {
//     // Assuming you know the ID of the membership you want to assign
//     $membership_id = 'YOUR_DEFAULT_MEMBERSHIP_ID'; // Replace this with your actual membership ID

//     // This is a simplified example. Depending on your version of MemberPress,
//     // you might need to interact with MemberPress's classes and methods directly
//     // to properly assign a membership to a user.

//     // Check if MemberPress class exists and method is available
//     if (class_exists('MeprUser') && method_exists('MeprUser', 'add_membership')) {
//         $mepr_user = new MeprUser($user_id);
//         $mepr_user->add_membership($membership_id); // Simplified; actual implementation may vary
//     }
//     // Note: This is a generic approach. Please refer to MemberPress documentation or support
//     // for guidance on assigning memberships programmatically as the API may have changed.
// }

// function my_handle_google_auth() {
//     if (empty($_GET['credential'])) {
//         // Handle error: No credential provided
//         wp_redirect(home_url('/login?error=no_credential')); // Redirect to a login page with an error
//         exit;
//     }

//     $id_token = $_GET['credential'];
//     $client = new Google_Client(['client_id' => '332720383708-1t60jqsr5dsjeh4s0cphk8f6hta4u10l.apps.googleusercontent.com']); // Specify the CLIENT_ID
//     $payload = $client->verifyIdToken($id_token);

//     if ($payload) {
//         $email = $payload['email']; // User's email
//         $user = get_user_by('email', $email);

//         if ($user) {
//             // User exists, log them in
//             wp_clear_auth_cookie();
//             wp_set_current_user($user->ID);
//             wp_set_auth_cookie($user->ID);

//             // Redirect after successful login
//             wp_redirect(home_url());
//             exit;
//         } else {
//             // No user exists, create a new user account
//             $user_id = wp_create_user($email, wp_generate_password(), $email);

//             if (!is_wp_error($user_id)) {
//                 // Optionally update user information
//                 wp_update_user([
//                     'ID' => $user_id,
//                     'first_name' => $payload['given_name'], // User's given name (first name)
//                     'last_name' => $payload['family_name'], // User's family name (last name)
//                     'display_name' => $payload['name'], // User's full name
//                     'role' => 'subscriber' // Or any other default role
//                 ]);

//                 // Log the new user in
//                 wp_clear_auth_cookie();
//                 wp_set_current_user($user_id);
//                 wp_set_auth_cookie($user_id);

//                 // Redirect after successful registration and login
//                 wp_redirect(home_url());
//                 exit;
//             } else {
//                 // Handle user creation failure
//                 wp_redirect(home_url('/login?error=registration_failed'));
//                 exit;
//             }
//         }
//     } else {
//         // Invalid ID token
//         wp_redirect(home_url('/login?error=invalid_token')); // Redirect to a login page with an error
//         exit;
//     }
// }

// function my_handle_google_auth() {
//     if (empty($_GET['credential'])) {
//         // Handle error: No credential provided
//         wp_redirect(home_url());
//         exit;
//     }

//     $id_token = $_GET['credential'];
//     $client = new Google_Client(['client_id' => '332720383708-1t60jqsr5dsjeh4s0cphk8f6hta4u10l.apps.googleusercontent.com']); // Specify the CLIENT_ID
//     $payload = $client->verifyIdToken($id_token);

//     if ($payload) {
//         $user_id = $payload['sub']; // Google user ID

//         // Proceed to authenticate or create a WordPress user
//         // Example: Check if a WordPress user with this Google user ID exists

//         wp_redirect(home_url()); // Redirect to the homepage or dashboard
//         exit;
//     } else {
//         // Invalid ID token
//         wp_redirect(home_url('/login?error=invalid_token')); // Redirect to a login page with an error
//         exit;
//     }
// }


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

// require_once(ABSPATH . 'wp-load.php');

// $client_id = '332720383708-1t60jqsr5dsjeh4s0cphk8f6hta4u10l.apps.googleusercontent.com';
// $client_secret = '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';
// $redirect_uri = site_url('/google-callback'); // Should match the one set in Google Cloud Console
// // Check if the user is already logged in to prevent unnecessary redirects
// if (is_user_logged_in()) {
//     error_log('User is logged in, redirecting to home.');

//     wp_redirect(home_url());
//     exit;
// } else {
//     error_log('User is not logged in, something went wrong.');

    
//     // Assuming this script is only reached through the Google OAuth flow with a 'code' parameter
//     if (isset($_GET['code'])) {
//         $code = $_GET['code'];
    
//         $token_url = 'https://oauth2.googleapis.com/token';
//         $params = [
//             'client_id' => $client_id,
//             'client_secret' => $client_secret,
//             'code' => $code,
//             'redirect_uri' => $redirect_uri,
//             'grant_type' => 'authorization_code',
//         ];
    
//         $curl = curl_init();
//         curl_setopt($curl, CURLOPT_URL, $token_url);
//         curl_setopt($curl, CURLOPT_POST, true);
//         curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
//         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//         $response = curl_exec($curl);
//         curl_close($curl);
    
//         $response = json_decode($response);
//         if (isset($response->access_token)) {
//             $access_token = $response->access_token;
    
//             $userinfo_url = 'https://www.googleapis.com/oauth2/v3/userinfo';
//             $headers = ['Authorization: Bearer ' . $access_token];
//             $curl = curl_init($userinfo_url);
//             curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//             curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//             $user_info = curl_exec($curl);
//             curl_close($curl);
//             $user_info = json_decode($user_info);
    
//             // Assuming the email is returned in the user info
//             if (isset($user_info->email)) {
//                 $email = $user_info->email;
//                 $user = get_user_by('email', $email);
//                 if (!$user) {
//                     // User does not exist, create a new user
//                     $user_id = wp_create_user($email, wp_generate_password(), $email);
//                     // Optionally set user's display name or any other user meta
//                 } else {
//                     $user_id = $user->ID;
//                 }
    
//                 // Log the user in
//                 wp_set_current_user($user_id);
//                 wp_set_auth_cookie($user_id);
    
//                 // Redirect to the desired page, e.g., the homepage or dashboard
//                 wp_redirect(home_url());
//                 exit;
//             }
//         }
//     }
    
//     // Redirect here if there's no 'code' parameter or if authentication fails
//     wp_redirect(home_url());
//     exit;
// }

// $code = $_GET['code'];

// $token_url = 'https://oauth2.googleapis.com/token';
// $params = [
//     'client_id' => $client_id,
//     'client_secret' => $client_secret,
//     'code' => $code,
//     'redirect_uri' => $redirect_uri,
//     'grant_type' => 'authorization_code',
// ];

// $curl = curl_init();
// curl_setopt($curl, CURLOPT_URL, $token_url);
// curl_setopt($curl, CURLOPT_POST, true);
// curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// $response = curl_exec($curl);
// curl_close($curl);

// $response = json_decode($response);
// $access_token = $response->access_token;

// $userinfo_url = 'https://www.googleapis.com/oauth2/v3/userinfo';
// $headers = ['Authorization: Bearer ' . $access_token];
// $curl = curl_init($userinfo_url);
// curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// $user_info = curl_exec($curl);
// curl_close($curl);
// $user_info = json_decode($user_info);

// // Here, implement your logic to check if the user exists in WordPress, create a new user or log the user in
// // This part is highly dependent on your site's specific needs and security considerations

// // Example user handling could be:
// $email = $user_info->email; // Assuming the email is returned in the user info
// $user = get_user_by('email', $email);
// if (!$user) {
//     // User does not exist, create a new user
//     $user_id = wp_create_user($email, wp_generate_password(), $email);
//     // Set user's display name or any other user meta
// } else {
//     $user_id = $user->ID;
// }

// // Log the user in
// wp_set_current_user($user_id);
// wp_set_auth_cookie($user_id);

// // Redirect to the desired page, e.g., the homepage or dashboard
// wp_redirect(home_url());
// exit;

require_once(ABSPATH . 'wp-load.php');

$client_id = '332720383708-1t60jqsr5dsjeh4s0cphk8f6hta4u10l.apps.googleusercontent.com';
$client_secret = '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';
$redirect_uri = site_url('/google-callback'); // Make sure this matches exactly with the one set in Google Cloud Console

// Check for any OAuth error parameters first
if (isset($_GET['error'])) {
    error_log('OAuth error: ' . $_GET['error']);
    // Redirect to an error page or display an error message
    wp_redirect(home_url('/error/')); // Adjust the path as needed
    exit;
}

// Check if the user is already logged in to prevent unnecessary redirects
// if (is_user_logged_in()) {
//     error_log('User is logged in, redirecting to home.');
//     wp_redirect(home_url());
//     exit;
// }

// Check if the user is already logged in to prevent unnecessary redirects
// if (is_user_logged_in()) {
//     error_log('User is logged in, redirecting to a safe page.');

//     // Example of redirecting to a different page based on user role
//     $user = wp_get_current_user();
//     if (in_array('administrator', (array) $user->roles)) {
//         // Redirect administrators to the dashboard
//         // wp_redirect(admin_url());
//     } else {
//         // Redirect other users to a profile or custom page
//         // wp_redirect(home_url('/member-dashboard/')); // Adjust the URL as needed
//     }
//     // exit;
// }

// Process the Google OAuth flow if we have a 'code' parameter
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $token_url = 'https://oauth2.googleapis.com/token';
    $params = [
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $code,
        'redirect_uri' => $redirect_uri,
        'grant_type' => 'authorization_code',
    ];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $token_url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);

    // Check for CURL errors
    if (curl_errno($curl)) {
        error_log('CURL Error: ' . curl_error($curl));
    }

    curl_close($curl);

    $response = json_decode($response);
    if (isset($response->access_token)) {
        $access_token = $response->access_token;

        $userinfo_url = 'https://www.googleapis.com/oauth2/v3/userinfo';
        $headers = ['Authorization: Bearer ' . $access_token];
        $curl = curl_init($userinfo_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $user_info = curl_exec($curl);
        curl_close($curl);
        $user_info = json_decode($user_info);

        if (isset($user_info->email)) {
            $email = $user_info->email;
            $user = get_user_by('email', $email);
            if (!$user) {
                error_log('Creating new user with email: ' . $email);
                $user_id = wp_create_user($email, wp_generate_password(), $email);
            } else {
                $user_id = $user->ID;
                error_log('User found with email: ' . $email . '. ID: ' . $user_id);
            }

            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);

            if (is_user_logged_in()) {
                error_log('User successfully logged in.');
                wp_redirect(home_url());
                exit;
            } else {
                error_log('User login failed.');
                // Redirect to a login page with an error message
                wp_redirect(home_url('/login/?login=failed')); // Adjust as needed
                exit;
            }
        } else {
            error_log('No email found in the user info.');
        }
    } else {
        error_log('Access token not received. Response: ' . json_encode($response));
    }
}

// Redirect if 'code' parameter is missing or if authentication fails
// wp_redirect(home_url('/login/?auth=failed')); // Adjust the path as needed
// exit;
