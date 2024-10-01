<?php
session_start();

$products = [
    'keyboard' => 5000,
    'headset' => 7000,
    'mouse' => 3500,
    'monitor' => 5500
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order = [];
    foreach ($products as $product => $price) {
        if (!empty($_POST[$product])) {
            $quantity = intval($_POST[$product]);
            if ($quantity > 0) {
                $order[$product] = $quantity * $price;
            }
        }
    }
    $totalPrice = array_sum($order);
    $totalPaid = intval($_POST['total_paid']);
    $dateTime = date("m/d/Y - h:i:s A");

    $_SESSION['receipt'] = [
        'order' => $order,
        'total_price' => $totalPrice,
        'total_paid' => $totalPaid,
        'date_time' => $dateTime
    ];

    header("Location: receipt.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order System</title>
    <style>
        table {
            width: 30%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        label {
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Order System</h1>
    <form method="POST">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price (IDR)</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product => $price): ?>
                    <tr>
                        <td><?php echo ucfirst($product); ?></td>
                        <td><?php echo number_format($price); ?></td>
                        <td>
                            <input type="number" name="<?php echo $product; ?>" min="0" placeholder="Qty" style="width: 60px;">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <label>
            Total Paid: 
            <input type="text" name="total_paid" required style="width: 100px;" pattern="[0-9]*" title="Please enter a valid amount">
        </label>
        <button type="submit">Submit Order</button>
    </form>
</body>
</html>