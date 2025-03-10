<?php

declare(strict_types=1);
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

function calculateTotalAmount(array $transactions): float {
    $total = 0;
    foreach ($transactions as $transaction) {
        $total += $transaction["amount"];
    }
    return $total;
}

function findTransactionByDescription(string $descriptionPart) {
    global $transactions;
    foreach ($transactions as $transaction) {
        if (strpos($transaction["description"], $descriptionPart) !== false) {
            return $transaction;
        }
    }
    return null;
}

function findTransactionById(int $id) {
    global $transactions;
    foreach ($transactions as $transaction) {
        if ($transaction["id"] === $id) {
            return $transaction;
        }
    }
    return null;
}


function daysSinceTransaction(string $date): int {
    $transactionDate = new DateTime($date);
    $today = new DateTime();
    $interval = $transactionDate->diff($today);
    return $interval->days;
}

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
echo "A new transaction was added";
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

