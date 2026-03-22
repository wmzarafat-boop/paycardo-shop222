<?php
// Save this file as get-code.php in your topup-hut/public folder

session_start();

// Read credentials
$credentials = json_decode(file_get_contents(__DIR__ . '/../credentials.json'), true);
$clientId = $credentials['installed']['client_id'];

if (!isset($_GET['code'])) {
    // Redirect to Google
    $authUrl = "https://accounts.google.com/o/oauth2/auth?" . http_build_query([
        'client_id' => $clientId,
        'redirect_uri' => 'http://localhost/get-code.php',
        'response_type' => 'code',
        'scope' => 'https://www.googleapis.com/auth/drive',
        'access_type' => 'offline',
        'prompt' => 'consent'
    ]);
    
    header('Location: ' . $authUrl);
    exit;
}

// We got the code!
$code = $_GET['code'];

// Exchange for tokens
$tokenUrl = 'https://oauth2.googleapis.com/token';

$postData = http_build_query([
    'client_id' => $clientId,
    'client_secret' => $credentials['installed']['client_secret'],
    'redirect_uri' => 'http://localhost/get-code.php',
    'grant_type' => 'authorization_code',
    'code' => $code
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $tokenUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
curl_close($ch);

$tokenData = json_decode($response, true);

if (isset($tokenData['refresh_token'])) {
    echo "<h2>SUCCESS!</h2>";
    echo "<p>Copy this refresh token:</p>";
    echo "<textarea style='width:100%;height:100px;'>" . $tokenData['refresh_token'] . "</textarea>";
    echo "<p>Or copy from here: <code>" . $tokenData['refresh_token'] . "</code></p>";
    
    // Save to .env
    $envPath = __DIR__ . '/../.env';
    $envContent = file_get_contents($envPath);
    $envContent = preg_replace(
        '/GOOGLE_DRIVE_REFRESH_TOKEN=.*/',
        'GOOGLE_DRIVE_REFRESH_TOKEN=' . $tokenData['refresh_token'],
        $envContent
    );
    file_put_contents($envPath, $envContent);
    echo "<p><strong>.env file has been updated!</strong></p>";
} else {
    echo "<h2>Error</h2>";
    echo "<pre>" . print_r($tokenData, true) . "</pre>";
}
