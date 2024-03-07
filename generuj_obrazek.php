<?php

require_once 'config/config.php';
require 'vendor/autoload.php';
$pathSH = __DIR__ . '/drukuj.sh';
$nazwaDrukarki = 'XP-3100';
use GuzzleHttp\Client;
$prompt = '';
$client = new Client();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["transcript"]) && $_POST["transcript"] !== "") {
        $prompt = $_POST["transcript"];
    } elseif (isset($_POST["prompt"]) && $_POST["prompt"] !== "") {
        $prompt = $_POST["prompt"];
    }

    //Create a steampunk-inspired piece representing the human mind as a complex mechanism. Use intricate details and metallic colors to emphasize the mechanical aspects.
    //Stwórz inspirowane steampunkiem dzieło przedstawiające ludzki umysł jako złożony mechanizm. Użyj skomplikowanych detali i metalicznych kolorów, aby podkreślić mechaniczne aspekty.
    //$prompt = "Generate a surreal landscape image featuring floating islands, upside-down mountains, and unconventional flora. Include a dreamlike quality, pushing the boundaries of reality. Conjure a scene that has imaginative and otherworldly elements.";

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
            //exec($pathSH . ' ' . $nazwaDrukarki);
        } else {
            echo "Wystąpił problem podczas zapisywania obrazka.\n";
        }
    } catch (\GuzzleHttp\Exception\ClientException $e) {
        echo "Błąd podczas wywoływania API: " . $e->getMessage() . "\n";
    }


}