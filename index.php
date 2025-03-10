<?php

declare(strict_types=1);

/**
 * @var array $transactions Массив транзакций, каждая содержит:
 * - int "id" — идентификатор транзакции.
 * - string "date" — дата транзакции (в формате YYYY-MM-DD).
 * - float "amount" — сумма транзакции.
 * - string "description" — описание покупки.
 * - string "merchant" — название магазина.
 */
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
        "date" => "2025-03-01",
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

/**
 * Сортирует транзакции по дате.
 *
 * @param array $a Первая транзакция.
 * @param array $b Вторая транзакция.
 * @return int Разница во времени.
 */
usort($transactions, function ($a, $b) {
    return strtotime($a["date"]) - strtotime($b["date"]);
});

/**
 * Сортирует транзакции по сумме (по убыванию).
 *
 * @param array $a Первая транзакция.
 * @param array $b Вторая транзакция.
 * @return int -1, 0 или 1 в зависимости от сравнения сумм.
 */
usort($transactions, function ($a, $b) {
    return $b['amount'] <=> $a['amount'];
});

/**
 * Вычисляет общую сумму всех транзакций.
 *
 * @param array $transactions Массив транзакций.
 * @return float Общая сумма всех транзакций.
 */
function calculateTotalAmount(array $transactions): float {
    $total = 0;
    foreach ($transactions as $transaction) {
        $total += $transaction["amount"];
    }
    return $total;
}

/**
 * Ищет транзакцию по части описания.
 *
 * @param string $descriptionPart Часть описания для поиска.
 * @return array|null Найденная транзакция или null, если не найдено.
 */
function findTransactionByDescription(string $descriptionPart) {
    global $transactions;
    foreach ($transactions as $transaction) {
        if (strpos($transaction["description"], $descriptionPart) !== false) {
            return $transaction;
        }
    }
    return null;
}

/**
 * Ищет транзакцию по ID.
 *
 * @param int $id Идентификатор транзакции.
 * @return array|null Найденная транзакция или null, если не найдено.
 */
function findTransactionById(int $id) {
    global $transactions;
    foreach ($transactions as $transaction) {
        if ($transaction["id"] === $id) {
            return $transaction;
        }
    }
    return null;
}

/**
 * Вычисляет количество дней, прошедших с даты транзакции.
 *
 * @param string $date Дата транзакции (формат YYYY-MM-DD).
 * @return int Количество дней с даты транзакции.
 */
function daysSinceTransaction(string $date): int {
    $transactionDate = new DateTime($date);
    $today = new DateTime();
    $interval = $transactionDate->diff($today);
    return $interval->days;
}

/**
 * Добавляет новую транзакцию в массив.
 *
 * @param int $id Идентификатор транзакции.
 * @param string $date Дата транзакции (формат YYYY-MM-DD).
 * @param float $amount Сумма транзакции.
 * @param string $description Описание транзакции.
 * @param string $merchant Магазин или сервис.
 * @return void
 */
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

?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php

// Проверка findTransactionByDescription
$searchResult = findTransactionByDescription("Coffee");
if ($searchResult) {
    echo  "1. findTransactionByDescription is called <br>" . print_r($searchResult, true) . "<br>";
} else {
    echo "i did something wrong in findTransactionByDescription)<br>";
}

// Проверка findTransactionById()
$searchById = findTransactionById(2);
if ($searchById) {
    echo "2. findTransactionById is called <br>" . print_r($searchById, true)."<br>";
} else {
    echo "mistakes were made in findTransactionById <br>";
}


// Проверка daysSinceTransaction()
echo "3. daysSinceTransaction is called <br>" . daysSinceTransaction($transactions[0]['date']) . "<br>";

//Проверка addTransaction
echo "4. a new transaction was added, should be in the table";
addTransaction(4, "2024-03-01", 99.99, "New purchase", "Online Store");

?>


<table border='1'>
    <thead>
        <tr>
            <th>ID</th>
            <th>Дата</th>
            <th>Сумма</th>
            <th>Описание</th>
            <th>Магазин</th>
            <th>Дней с момента</th>
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
            <td><?= daysSinceTransaction($transaction["date"]) ?></td>
        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5">Общая сумма:</td>
            <td><?= calculateTotalAmount($transactions) ?> $</td>
        </tr>
    </tfoot>
</table>

</body>
</html>

