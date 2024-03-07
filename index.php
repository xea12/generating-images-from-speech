<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nagrywanie i rozpoznawanie mowy</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }
        h2 {
            margin-top: 20px;
            margin-bottom: 10px;
            text-align: center;
        }
        button {

            margin: 10px auto;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            transition: background-color 0.3s ease;
        }
        button[disabled] {
            background-color: #6c757d; /* Kolor tła dla nieaktywnego przycisku */
            color: #fff; /* Kolor tekstu dla nieaktywnego przycisku */
            cursor: not-allowed; /* Zmiana kursora na not-allowed */
        }
        button:hover {
            background-color: #0056b3;
        }
        #transcription {
            margin: 20px auto;
            width: 80%;
            min-height: 150px;
            max-width: 600px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
        }
        form {
            text-align: center;
        }
        input[type="submit"] {
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #28a745;
            color: #fff;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<h2>Nagrywanie i rozpoznawanie mowy</h2>
<div style="display: flex; max-width: 500px; margin: 0 auto">
    <button id="startRecording">Rozpocznij nagrywanie</button>
    <button id="stopRecording" disabled>Zatrzymaj nagrywanie</button>
</div>

<div id="transcription"></div>
<form id="form" action="generuj_obrazek.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="transcript" id="transcriptField">
    <input type="submit" value="Wyślij tekst do generowania obrazka">
</form>
<audio controls id="audioPlayback" style="display: none;"></audio>

<script>
    const startRecordingButton = document.getElementById('startRecording');
    const stopRecordingButton = document.getElementById('stopRecording');
    const transcriptionDiv = document.getElementById('transcription');
    const transcriptField = document.getElementById('transcriptField');
    const form = document.getElementById('form');

    let recognition;
    let recording = false;

    startRecordingButton.addEventListener('click', startRecording);
    stopRecordingButton.addEventListener('click', stopRecording);

    function startRecording() {
        recognition = new webkitSpeechRecognition();
        recognition.lang = 'pl-PL';
        recognition.continuous = true;

        recognition.onstart = function () {
            recording = true;
            startRecordingButton.disabled = true;
            stopRecordingButton.disabled = false;
        };

        recognition.onresult = function (event) {
            let transcript = event.results[event.results.length - 1][0].transcript;
            transcriptionDiv.textContent = transcript; // Aktualizacja pola z transkrypcją
            transcriptField.value = transcript; // Aktualizacja ukrytego pola formularza
        };

        recognition.start();
    }

    function stopRecording() {
        if (recognition) {
            recording = false;
            recognition.stop();
            startRecordingButton.disabled = false;
            stopRecordingButton.disabled = true;

            // Ustaw wartość pola formularza na transkrypcję
            console.log(transcriptField.value); // Upewnij się, że wartość jest ustawiona poprawnie
        }
    }

    form.addEventListener('submit', function(event) {
        // Zatrzymaj domyślne zachowanie formularza
        event.preventDefault();

        // Prześlij formularz
        this.submit();
    });
</script>
</body>
</html>

