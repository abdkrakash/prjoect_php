<?php
include 'db_config.php';

// Fetch all orders from the database
$stmt = $conn->query("SELECT * FROM orders");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../html/includes/top.php'; ?>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?php include '../html/includes/sidebar.php'; ?>
        <div class="layout-page">
            <?php include '../html/includes/navbar.php'; ?>
            <div class="container-fluid m-4">
                <h1>Orders</h1>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>User ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo $order['Order_ID']; ?></td>
                                <td><?php echo $order['Order_date']; ?></td>
                                <td><?php echo $order['total_price']; ?></td>
                                <td><?php echo $order['status']; ?></td>
                                <td><?php echo $order['Users_ID']; ?></td>
                                <td>
                                    <a class="btn btn-warning" href="update_orders.php?Order_ID=<?php echo $order['Order_ID']; ?>">Edit</a>
                                    <a class="btn btn-danger" href="delete_orders.php?Order_ID=<?php echo $order['Order_ID']; ?>" onclick="return confirm('Are you sure you want to delete this order?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <br>
            </div>
        </div>
    </div>
</div>
<?php include '../html/includes/end.php'; ?>