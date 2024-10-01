<?php
session_start();
if (!isset($_SESSION['receipt'])) {
    header("Location: order.php");
    exit;
}

$receipt = $_SESSION['receipt'];
$totalPrice = $receipt['total_price'];
$totalPaid = $receipt['total_paid'];
$change = $totalPaid - $totalPrice;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #333;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        .change {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Receipt</h1>
    <p>Date & Time: <?php echo $receipt['date_time']; ?></p>
    <h2>Order Details:</h2>
    <ul>
        <?php foreach ($receipt['order'] as $product => $price): ?>
            <li><?php echo ucfirst($product) . ": " . number_format($price) . " PHP"; ?></li>
        <?php endforeach; ?>
    </ul>
    <p><strong>Total Price: </strong><?php echo number_format($totalPrice) . " PHP"; ?></p>
    <p><strong>Total Paid: </strong><?php echo number_format($totalPaid) . " PHP"; ?></p>

    <?php if ($totalPaid < $totalPrice): ?>
        <p class="error">Sorry, your balance is not enough.</p>
    <?php else: ?>
        <p class="change">Your change: <?php echo number_format($change) . " PHP"; ?></p>
    <?php endif; ?>

    <?php
    // Clear the receipt data after displaying
    unset($_SESSION['receipt']);
    ?>
</body>
</html>s