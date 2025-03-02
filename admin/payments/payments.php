<?php
include 'db_config.php'; 
$stmt = $conn->prepare("SELECT * FROM payments");
$stmt->execute();
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<?php include '../html/includes/top.php'; ?>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?php include '../html/includes/sidebar.php'; ?>
        <div class="layout-page">
            <?php include '../html/includes/navbar.php'; ?>


    <div class="container mt-5">
        <h1 class="text-center">Payments Table</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Payment Date</th>
                    <th>Payment Status</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Order ID</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($payment['Payment_ID']); ?></td>
                        <td><?php echo htmlspecialchars($payment['Payment_Date']); ?></td>
                        <td><?php echo htmlspecialchars($payment['Payment_status']); ?></td>
                        <td><?php echo htmlspecialchars($payment['Amount']); ?></td>
                        <td><?php echo htmlspecialchars($payment['Payment_Method']); ?></td>
                        <td><?php echo htmlspecialchars($payment['Order_ID']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php include '../html/includes/end.php'; ?>