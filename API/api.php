<?php
// Подключаем необходимые классы
require_once 'URLShortener/URLShortener.php';

// Проверяем, приходит ли запрос в формате JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    // Получаем данные JSON-запроса
    $data = json_decode(file_get_contents('php://input'));

    if (!$data) {
        http_response_code(400);
        echo json_encode(['error' => 'Некорректные данные.']);
        exit;
    }

    // Действие зависит от значения поля 'action' в JSON-запросе
    if (isset($data->action)) {
        if ($data->action === 'shorten') {
            // Действие "Сократить ссылку"
            if (isset($data->url)) {
                $originalURL = $data->url;
                $shortener = new URLShortener();
                $shortenedURL = $shortener->shortenURL($originalURL);

                if ($shortenedURL) {
                    echo json_encode(['shortenedURL' => $shortenedURL]);
                } else {
                    echo json_encode(['error' => 'Ошибка при сокращении ссылки.']);
                }
            } else {
                echo json_encode(['error' => 'Отсутствует URL для сокращения.']);
            }
        } elseif ($data->action === 'getOriginal') {
            // Действие "Получить исходную ссылку"
            if (isset($data->shortenedURL)) {
                $shortenedURL = $data->shortenedURL;
                $shortener = new URLShortener();
                $originalURL = $shortener->redirectToOriginalURL($shortenedURL);

                if ($originalURL) {
                    echo json_encode(['originalURL' => $originalURL]);
                } else {
                    echo json_encode(['error' => 'URL не найден.']);
                }
            } else {
                echo json_encode(['error' => 'Отсутствует короткая ссылка.']);
            }
        } else {
            echo json_encode(['error' => 'Неизвестное действие.']);
        }
    } else {
        echo json_encode(['error' => 'Отсутствует поле "action" в запросе.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Некорректный запрос.']);
}
?>
