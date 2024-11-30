<?php
$jsonFilePath = 'datas.json';
$jsonData = file_get_contents($jsonFilePath);
$dataArray = json_decode($jsonData, true);

if ($dataArray === null) {
    die('JSON verisi okunamadı veya bozuk!');
}

$quizData = [];
for ($i = 0; $i < 10; $i++) {
    $questionItem = $dataArray[array_rand($dataArray)];

    $randomAnswers = [];
    while (count($randomAnswers) < 3) {
        $answerItem = $dataArray[array_rand($dataArray)];
        if ($answerItem['english'] !== $questionItem['english'] && !in_array($answerItem['english'], $randomAnswers)) {
            $randomAnswers[] = $answerItem['english'];
        }
    }

    $correctAnswer = $questionItem['english'];
    $randomAnswers[] = $correctAnswer;

    shuffle($randomAnswers);

    $quizData[] = [
        "question" => $questionItem['turkish'] ?? 'Soru yok',
        "answers" => $randomAnswers,
        "correct" => $correctAnswer
    ];
}

header('Content-Type: application/json');
echo json_encode($quizData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
