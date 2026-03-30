<?php
// Test script to see EXACTLY what login.php outputs for a POST request
$url = 'http://127.0.0.1:8000/api/login.php';
$data = ['username' => '2023IT04', 'password' => '2023IT04'];

$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data)
    ]
];
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) {
    echo "Request failed!";
} else {
    echo "Response:\n$result";
}
?>
