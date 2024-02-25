<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : get_current_user_id();

// allows users to view their own data or the current user is an administrator.
if ($user_id !== get_current_user_id() && !current_user_can('manage_options')) {
    echo 'You do not have permission to view this profile.';
    exit;
}

echo "<h1>Profile Page: $user_id </h1>";

// Retrieve all user meta data for the user
$user_meta = get_user_meta($user_id);
// echo '<pre>';
// print_r($user_meta );
// echo '</pre>';

echo '<h2>User Meta Data</h2>';
echo '<ul>';
foreach ($user_meta as $key => $values) { // Note: $values is an array
    echo '<li><strong>' . esc_html($key) . ':</strong> ' . esc_html($values[0]) . '</li>';
}
echo '</ul>';