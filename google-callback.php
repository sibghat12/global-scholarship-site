<?php
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
                // If user doesn't exist, create new one
                $userdata = [
                    'user_email' => $email,
                    'user_login' => $email,
                    'first_name' => $user_info->given_name,
                    'last_name' => $user_info->family_name,
                    'display_name' => $user_info->given_name,
                ];
                $user_id = wp_insert_user($userdata);
                update_user_meta($user_id, 'avatar', $user_info->picture);
            } else {
                $user_id = $user->ID;
                // Update first name, last name, and avatar only if they are not already set
                if (!get_user_meta($user_id, 'first_name', true)) {
                    update_user_meta($user_id, 'first_name', $user_info->given_name);
                }
                if (!get_user_meta($user_id, 'last_name', true)) {
                    update_user_meta($user_id, 'last_name', $user_info->family_name);
                }
                if (!get_user_meta($user_id, 'display_name', true)) {
                    update_user_meta($user_id, 'display_name', $user_info->given_name);
                }
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
