# Лабораторная работа №3. Массивы и Функции

## Студент
**Gachayev Dmitrii I2302**  
**Выполнено 10.03.2025**  

## Цель работы
Освоить работу с массивами в PHP, применяя различные операции: создание, добавление, удаление, сортировка и поиск. Закрепить навыки работы с функциями, включая передачу аргументов, возвращаемые значения и анонимные функции.
## 1. Работа с массивами.
Необходимо разработать систему управления банковскими транзакциями с возможностью:
- добавления новых транзакций;
- удаления транзакций;
- сортировки транзакций по дате или сумме;
- поиска транзакций по описанию.
### 1.1 Подготовка среды
Создаю новый php файл `index.php`, включаю строгую типизацию:
```php
<?php

declare(strict_types=1);
```
### 1.2 Создание массива студентов.

Создаю массив `$transactions`, содержащий информацию о банковских транзакциях. Каждая транзакция представлена в виде ассоциативного массива с полями:

- `id` – уникальный идентификатор транзакции;
- `date` – дата совершения транзакции (YYYY-MM-DD);
- `amount` – сумма транзакции;
- `description` – описание назначения платежа;
- `merchant` – название организации, получившей платеж.

Массив `$transactions`:

```php
$transactions = [
    [
        "id" => 1,
        "date" => "2023-05-10",
        "amount" => 250.75,
        "description" => "Electronics purchase",
        "merchant" => "Tech Store",
    ],
    [
        "id" => 2,
        "date" => "2023-06-22",
        "amount" => 120.00,
        "description" => "Monthly gym membership",
        "merchant" => "Fitness Club",
    ],
    [
        "id" => 3,
        "date" => "2023-07-05",
        "amount" => 45.30,
        "description" => "Coffee and snacks",
        "merchant" => "Café Aroma",
    ],
];
```
### 1.3 Вывод списка транзакций.

Использую `foreach`, чтобы вывести список студентов в HTML-таблице:

*В следующих пунктах таблица будет изменена для удовлетворения других условий (например, добавления столбца с общей суммой)*

```php
<table border='1'>
    <thead>
        <tr>
            <th>ID</th>
            <th>Дата</th>
            <th>Сумма</th>
            <th>Описание</th>
            <th>Магазинн</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($transactions as $transaction) { ?>
        <tr>
            <td><?= $transaction["id"] ?></td>
            <td><?= $transaction["date"] ?></td>
            <td><?= number_format($transaction["amount"], 2) ?> $</td>
            <td><?= $transaction["description"] ?></td>
            <td><?= $transaction["merchant"] ?></td>
        </tr>
    <?php } ?>
</tbody>
</table>

```

### 1.4 Реализация функций.
`calculateTotalAmount(array $transactions): float`:

```php
function calculateTotalAmount(array $transactions): float {
    $total = 0;
    foreach ($transactions as $transaction) {
        $total += $transaction["amount"];
    }
    return $total;
}
```

Проверить ее можно по выводу общей суммы в таблице:

![image](screenshots/Screenshot_1.png)

В таблицу интегрировал так:

```php
 <td><?= calculateTotalAmount($transactions) ?> $</td>
```

`findTransactionByDescription(string $descriptionPart)`:

```php
function findTransactionByDescription(string $descriptionPart) {
    global $transactions;
    foreach ($transactions as $transaction) {
        if (strpos($transaction["description"], $descriptionPart) !== false) {
            return $transaction;
        }
    }
    return null;
}
```

В `index.php` сделал проверку для функции:


```php
$searchResult = findTransactionByDescription("Coffee");
if ($searchResult) {
    echo  "1. findTransactionByDescription is called <br>" . print_r($searchResult, true) . "<br>";
} else {
    echo "i did something wrong in findTransactionByDescription)<br>";
}
```

До таблицы должен выводиться текст и инфа о транзакции.

`findTransactionById(int $id)`:

```PHP
function findTransactionById(int $id) {
    global $transactions;
    foreach ($transactions as $transaction) {
        if ($transaction["id"] === $id) {
            return $transaction;
        }
    }
    return null;
}
```
Также добавил проверку до таблицы:

```php
$searchById = findTransactionById(2);
if ($searchById) {
    echo "2. findTransactionById is called <br>" . print_r($searchById, true)."<br>";
} else {
    echo "mistakes were made in findTransactionById <br>";
}
```
Должен выводиться текст и инфа о транзакции.

`daysSinceTransaction(string $date): int`:

```php
function daysSinceTransaction(string $date): int {
    $transactionDate = new DateTime($date);
    $today = new DateTime();
    $interval = $transactionDate->diff($today);
    return $interval->days;
}
```

Проверить можно по столбцу в таблице:

![image](screenshots/Screenshot_2.png)

В таблицу интегрировал так:

```php
 <td><?= daysSinceTransaction($transaction["date"]) ?></td>
```

`addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void`:

```php
function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void {
    global $transactions;
    $transactions[] = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant,
    ];
}
```

Проверить можно по таблице, в ней появится добавленная транзакция:

![image](screenshots/Screenshot_3.png)


## 1.5 Сортировка

Сортировка используя `usort`:

*ВАЖНО: Сортировка распространяется только на существующие в массиве `$transactions` транзакции (новая добавленная транзакция не сортируется)*

```php
usort($transactions, function ($a, $b) {
    return strtotime($a["date"]) - strtotime($b["date"]);
 });

```

```php
usort($transactions, function ($a, $b) {
    return $b['amount'] <=> $a['amount'];
 });

```

## 2. Работа с файловой системой.

### 1. Создание директории для картинок

Создаю директорию `/image` и сохраняю в нее 21 случайную картинку с расширением `.jpg`

### 2. Создание файла с разметкой

Создаю файл `index2.php` с веб-страницей с хедером, меню, контентом и футером:

```php
<?php
$dir = 'image/';
$files = scandir($dir);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
            background-color: #f8f8f8;
        }
        header {
            background: #333;
            color: white;
            padding: 15px;
            font-size: 24px;
        }
        nav {
            background: #444;
            padding: 10px;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 10px;
        }
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .gallery img {
            width: 100%;
            height: auto;
            border-radius: 5px;
            transition: transform 0.3s;
        }
        .gallery img:hover {
            transform: scale(1.1);
        }
        footer {
            background: #333;
            color: white;
            padding: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header>
    Галерея изображений
</header>

<nav>
    <a href="#">Главная</a>
    <a href="#">О нас</a>
    <a href="#">Контакты</a>
</nav>

<div class="gallery">
    <?php
    if ($files !== false) {
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == 'jpg') {
                echo "<img src='$dir$file' alt='Изображение'>";
            }
        }
    } else {
        echo "<p>Ошибка загрузки изображений</p>";
    }
    ?>
</div>

<footer>
    © 2025 Галерея изображений
</footer>

</body>
</html>

```

### 3. Вывожу картинки из директории на веб-страницу в виде галереи

Реализую задачу следующими фрагментами кода:

Определяю папку и сканирую директорию с картинками:

```php
<?php
$dir = 'image/';
$files = scandir($dir);
?>
```
Проверяю, удалось ли получить список файлов, прохожу по каждому файлу в папке, проверяю, является ли он jpg изображением и вывожу <img> с найденным файлом

```php
<?php
    if ($files !== false) {
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == 'jpg') {
                echo "<img src='$dir$file' alt='Изображение'>";
            }
        }
    } else {
        echo "<p>error</p>";
    }
    ?>
```

## Документация
Код задокументирован, используя стандарт `PHPDoc`
## Контрольные вопросы

1. Что такое массивы в PHP?

Массивы в PHP — это структуры данных, позволяющие хранить несколько значений в одной переменной. Они могут быть индексными, ассоциативными и многомерными.

2. Каким образом можно создать массив в PHP?

- С помощью array() - `$arr = array(1, 2, 3);`
- С помощью [] - `$arr = [1, 2, 3];`
- Ассоциативный массив - `$user = ["name" => "Alex", "age" => 25];`

3. Для чего используется цикл `foreach`?

Цикл `foreach` используется для перебора элементов массива без необходимости отслеживать индексы.

Полноценный код обеих частей можно найти в файлах `index.php` и `index2.php`
