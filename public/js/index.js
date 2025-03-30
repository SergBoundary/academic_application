function updateClock() {
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
    document.getElementById('dynamicClock').textContent = formattedDateTime;
  }

  // Первоначальный вызов функции для немедленного отображения времени
  updateClock();
  // Обновляем каждую секунду
  setInterval(updateClock, 1000);

  autosize(document.getElementById('form_post_content'));