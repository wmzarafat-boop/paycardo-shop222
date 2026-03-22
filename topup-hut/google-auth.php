<?php

// Simple Google Drive Authentication Script
// This will help you get the refresh token

// Read credentials
$credentials = json_decode(file_get_contents(__DIR__ . '/credentials.json'), true);

// Build OAuth URL manually
$clientId = $credentials['installed']['client_id'];
$redirectUri = 'http://localhost';

$authUrl = "https://accounts.google.com/o/oauth2/auth?" . http_build_query([
    'client_id' => $clientId,
    'redirect_uri' => $redirectUri,
    'response_type' => 'code',
    'scope' => 'https://www.googleapis.com/auth/drive',
    'access_type' => 'offline',
    'prompt' => 'consent'
]);

echo "====================================\n";
echo "GOOGLE DRIVE AUTHENTICATION\n";
echo "====================================\n\n";
echo "1. Open this URL in your browser:\n\n";
echo "$authUrl\n\n";
echo "2. Login with your Google account\n";
echo "3. Click 'Allow' for all permissions\n";
echo "4. You will be redirected to localhost with an error (that's normal)\n";
echo "5. Look at the URL in your browser address bar\n";
echo "6. Copy the 'code=' parameter value\n";
echo "7. Paste it below:\n\n";
echo "====================================\n";
echo "Enter authorization code: ";

$code = trim(fgets(STDIN));

if ($code && strlen($code) > 20) {
    // Exchange code for tokens
    $tokenUrl = 'https://oauth2.googleapis.com/token';
    
    $postData = http_build_query([
        'client_id' => $clientId,
        'client_secret' => $credentials['installed']['client_secret'],
        'redirect_uri' => $redirectUri,
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
        echo "\n====================================\n";
        echo "SUCCESS! Copy this to your .env file:\n\n";
        echo "GOOGLE_DRIVE_REFRESH_TOKEN=" . $tokenData['refresh_token'] . "\n\n";
        echo "====================================\n";
        echo "\nYour .env file has been updated!\n";
        
        // Update .env file
        $envPath = __DIR__ . '/.env';
        $envContent = file_get_contents($envPath);
        $envContent = preg_replace(
            '/GOOGLE_DRIVE_REFRESH_TOKEN=.*/',
            'GOOGLE_DRIVE_REFRESH_TOKEN=' . $tokenData['refresh_token'],
            $envContent
        );
        file_put_contents($envPath, $envContent);
        
        echo "Done! You can now test Google Drive uploads.\n";
    } else {
        echo "\nError getting refresh token:\n";
        print_r($tokenData);
    }
} else {
    echo "\nInvalid code. Please run the script again and copy the full code.\n";
}
