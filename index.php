<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сервис сокращения ссылок</title>
</head>
<body>
    <form method="POST" action="">
        Введите URL для сокращения:
        <input type="text" name="url" id="urlInput">
        <span id="urlError" style="color: red;"></span>
        <input type="submit" value="Сократить" id="submitButton">
    </form>

    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once 'URLShortener/URLShortener.php';

        $originalURL = $_POST['url'];
        $shortener = new URLShortener();
        $shortenedURL = $shortener->shortenURL($originalURL);
        echo "Короткая ссылка: <a href='index.php?s=$shortenedURL' target='_blank'>$shortenedURL</a>";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['s'])) {
        require_once 'URLShortener/URLShortener.php';

        $shortenedURL = $_GET['s'];
        $shortener = new URLShortener();
        $originalURL = $shortener->redirectToOriginalURL($shortenedURL);
        if ($originalURL) {
            header("Location: $originalURL");
            exit;
        } else {
            echo "URL не найден.";
        }
    }
    ?>

    <script >

        
function isValidURL(url) {
    const pattern = /^https?:\/\/.+\..+/i;
    return pattern.test(url);
}

document.getElementById("submitButton").addEventListener("click", function (event) {
    const urlInput = document.getElementById("urlInput");
    const urlError = document.getElementById("urlError");

    if (!isValidURL(urlInput.value)) {
        urlError.innerText = "Некорректный URL";
        event.preventDefault();
    } else {
        urlError.innerText = "";
    }
});
    </script>
</body>
</html>


