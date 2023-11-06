




// document.getElementById("submitButton").addEventListener("click", function (event) {
//     event.preventDefault();

//     const urlInput = document.getElementById("urlInput");
//     const urlError = document.getElementById("urlError");

//     if (!isValidURL(urlInput.value)) {
//         urlError.innerText = "Некорректный URL";
//         return;
//     }

//     // Определите, какое действие нужно выполнить (сокращение ссылки или получение исходной ссылки)
//     const action = "shorten"; // Или "getOriginal" в зависимости от вашего выбора.

//     // Создайте объект с данными для JSON-запроса
//     const requestData = {
//         action,
//         url: urlInput.value, // Или shortenedURL для получения исходной ссылки
//     };

//     // Отправка JSON-запроса на сервер
//     fetch('api.php', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//         },
//         body: JSON.stringify(requestData),
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.shortenedURL) {
//             // Обработка успешного ответа при сокращении ссылки
//             // Ваш код здесь, например, обновление интерфейса с короткой ссылкой
//             const shortenedURL = data.shortenedURL;
//             // Пример: 
//             alert(`Короткая ссылка: ${shortenedURL}`);
//         } else if (data.originalURL) {
//             // Обработка успешного ответа при получении исходной ссылки
//             // Ваш код здесь, например, перенаправление пользователя
//             const originalURL = data.originalURL;
//             window.location.href = originalURL;
//         } else {
//             // Обработка ошибки
//             urlError.innerText = data.error || 'Произошла ошибка.';
//         }
//     })
//     .catch(error => {
//         // Обработка сетевой ошибки
//         urlError.innerText = 'Произошла сетевая ошибка.';
//     });
// });