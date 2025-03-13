<?php
$file = 'data.txt';

// Hole die aktuellen Daten, wenn die Datei existiert
$currentData = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

// Überprüfe die Eingaben
if (isset($_GET['n'], $_GET['p'], $_GET['r'])) {
    $playerName = preg_replace('/[^a-zA-Z0-9]/', '', $_GET['n']);  // Nur alphanumerische Namen
    $newPosition = preg_replace('/[^0-9,.-]/', '', $_GET['p']);   // Positionsfilter
    $newRotation = preg_replace('/[^0-9,.-]/', '', $_GET['r']);   // Rotationsfilter

    // Benutze ein assoziatives Array für schnelle Bearbeitung
    $playerData = [];
    foreach ($currentData as $line) {
        [$name, $data] = explode('|', $line, 2);
        if ($name !== $playerName) {
            $playerData[$name] = $data;
        }
    }

    // Aktualisiere den Spieler oder füge ihn hinzu
    $playerData[$playerName] = $newPosition . '*' . $newRotation;

    // Speichere die Daten als Zeilen in der Datei
    $newData = [];
    foreach ($playerData as $name => $data) {
        $newData[] = $name . '|' . $data;
    }
    file_put_contents($file, implode("\n", $newData));

    echo "Data stored successfully!";
} else {
    echo "Missing parameters.";
}
?>
