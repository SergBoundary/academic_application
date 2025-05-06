function updateClock() {
    const clockElement = document.getElementById('dynamicClock');
    if (!clockElement) return;

    const now = new Date();
    const day = now.getDate().toString().padStart(2, '0');
    const month = (now.getMonth() + 1).toString().padStart(2, '0');
    const year = now.getFullYear();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');

    // Форматируем дату и время, например, как "день.месяц.год часы:минуты:секунды"
    const formattedDateTime = `${day}.${month}.${year} ${hours}:${minutes}:${seconds}`;

    // Обновляем содержимое элемента
    clockElement.textContent = formattedDateTime;
}

// Первоначальный вызов функции для немедленного отображения времени
updateClock();
// Обновляем каждую секунду
setInterval(updateClock, 1000);

//   autosize(document.getElementById('form_post_content'));

document.addEventListener("DOMContentLoaded", function () {

    const input = document.getElementById('avatarInput');
    const preview = document.getElementById('avatarPreview');

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const objectUrl = URL.createObjectURL(file);
        preview.src = objectUrl;

        // Выгрузка изображения из памяти
        preview.onload = () => URL.revokeObjectURL(objectUrl);
    });
});

document.addEventListener("DOMContentLoaded", function () {

    // AJAX for interaction
    // Функция для обработки ответа и обновления кнопок
    function updateInteraction(responseData, action, postId) {
        console.log('updateInteraction()', action, postId, responseData);
        // Найти все кнопки и счетчики для данного действия и поста
        // Здесь предполагается, что в data-атрибутах формы и счётчика указаны data-action и data-post-id
        var forms = document.querySelectorAll('form.ajax-interaction[data-action="' + action + '"][data-post-id="' + postId + '"]');
        var badges = document.querySelectorAll('.badge[data-action="' + action + '"][data-post-id="' + postId + '"]');

        // Если action вернул новый статус (например, 1 для активного, 0 для неактивного)
        // Обновляем стиль кнопок: если active (1) — btn-outline-primary, иначе — btn-outline-secondary
        var newClass = (responseData[action] == 1) ? 'btn-outline-primary' : 'btn-outline-secondary';

        forms.forEach(function (form) {
            var btn = form.querySelector('button');
            if (btn) {
                // Удаляем оба класса и добавляем нужный
                btn.classList.remove('btn-outline-secondary', 'btn-outline-primary');
                btn.classList.add(newClass);
            }
        });

        // Обновляем счетчик на badge
        // Предположим, сервер возвращает поле с количеством, например: likeCount, dislikeCount и т.д.
        var countField = action + 'Count';
        badges.forEach(function (badge) {
            var span = badge.querySelector('span');
            if (span && responseData[countField] !== undefined) {
                span.textContent = responseData[countField];
            }
        });
    }

    // Перехватываем отправку всех форм с классом ajax-interaction
    var ajaxForms = document.querySelectorAll('form.ajax-interaction');
    ajaxForms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var url = form.getAttribute('action');
            var method = form.getAttribute('method').toUpperCase();
            var formData = new FormData(form);
            // Если нужно передавать JSON, можно собрать данные и использовать JSON.stringify()

            // Отправляем AJAX-запрос через fetch()
            fetch(url, {
                method: method,
                body: formData,
                credentials: 'include'  // Для передачи cookies, если требуется
            })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then(function (data) {
                    console.log("AJAX response:", data);
                    var postId = form.dataset.postId;
                    ['liked', 'disliked', 'bookmarked', 'subscribed', 'shared'].forEach(function (act) {
                        if (data.hasOwnProperty(act) && data.hasOwnProperty(act + 'Count')) {
                            updateInteraction(data, act, postId);
                        }
                    });
                })
                .catch(function (error) {
                    console.error("Ошибка при отправке AJAX-запроса:", error);
                });
        });
    });
});