<?php

require_once 'config/config.php';
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["transcript"])) {
    $prompt = $_POST["transcript"];
    $prompt = "Generate a surreal landscape image featuring floating islands, upside-down mountains, and unconventional flora. Include a dreamlike quality, pushing the boundaries of reality. Conjure a scene that has imaginative and otherworldly elements.";

    try {
        $response = $client->request('POST', 'https://api.openai.com/v1/images/generations', [
            'headers' => [
                'Authorization' => 'Bearer ' . API_KEY,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'dall-e-2',
                'prompt' => $prompt,
                'n' => 1,
                'size' => '512x512',
            ],
        ]);

        $body = $response->getBody();
        $array = json_decode($body, true);

        $imageData = file_get_contents($array['data'][0]['url']); // Pobierz dane obrazka
        $fileName = 'image/generated_image.jpg'; // Ustaw nazwę pliku

        // Zapisz obrazek do pliku
        if (file_put_contents($fileName, $imageData) !== false) {
            echo "Wysłany prompt : " . $prompt . "<br>";
            echo "<br>";
            echo "Obrazek został zapisany jako: " . $fileName . "\n";
            exec('/opt/lampp/htdocs/ai/drukuj.sh');
        } else {
            echo "Wystąpił problem podczas zapisywania obrazka.\n";
        }
    } catch (\GuzzleHttp\Exception\ClientException $e) {
        echo "Błąd podczas wywoływania API: " . $e->getMessage() . "\n";
    }


}