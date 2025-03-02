<?php
include 'db_config.php'; // تأكد من أن هذا الملف يحتوي على اتصال قاعدة البيانات

// التحقق من وجود Order_ID في الرابط
if (isset($_GET['Order_ID']) && is_numeric($_GET['Order_ID'])) {
    $order_id = $_GET['Order_ID'];

    // جلب بيانات الطلب باستخدام Order_ID
    $stmt = $conn->prepare("SELECT * FROM orders WHERE Order_ID = :Order_ID");
    $stmt->bindParam(':Order_ID', $order_id, PDO::PARAM_INT);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    // التحقق من وجود الطلب
    if (!$order) {
        echo "Order not found.";
        exit();
    }
} else {
    echo "Invalid Order ID.";
    exit();
}

// معالجة تحديث الطلب عند إرسال النموذج
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $status = $_POST['status']; // فقط حالة الطلب يتم تحديثها

    // تحديث حالة الطلب باستخدام Order_ID
    $stmt = $conn->prepare("UPDATE orders SET status = :status WHERE Order_ID = :Order_ID");
    $stmt->execute([
        ':status' => $status,
        ':Order_ID' => $order_id
    ]);

    // إعادة التوجيه إلى صفحة عرض الطلبات بعد التحديث
    header("Location: read_orders.php");
    exit();
}
?>

<!-- بداية HTML لعرض النموذج -->
<?php include '../html/includes/top.php'; ?>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?php include '../html/includes/sidebar.php'; ?>
        <div class="layout-page">
            <?php include '../html/includes/navbar.php'; ?>
            <div class="container-fluid m-4">
                <h1>Edit Order Status</h1>
                
                <form method="POST" action="?Order_ID=<?php echo $order['Order_ID']; ?>">
                    <input type="hidden" name="update" value="1">

                    <!-- عرض Order Date (غير قابل للتعديل) -->
                    <div class="mb-3">
                        <label class="form-label">Order Date:</label>
                        <p class="form-control-static"><?php echo htmlspecialchars($order['Order_date']); ?></p>
                    </div>

                    <!-- عرض Total Price (غير قابل للتعديل) -->
                    <div class="mb-3">
                        <label class="form-label">Total Price:</label>
                        <p class="form-control-static"><?php echo htmlspecialchars($order['total_price']); ?></p>
                    </div>

                    <!-- عرض User ID (غير قابل للتعديل) -->
                    <div class="mb-3">
                        <label class="form-label">User ID:</label>
                        <p class="form-control-static"><?php echo htmlspecialchars($order['Users_ID']); ?></p>
                    </div>

                    <!-- Status (قابل للتعديل) -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="pending" <?php echo ($order['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="processing" <?php echo ($order['status'] == 'processing') ? 'selected' : ''; ?>>Processing</option>
                            <option value="completed" <?php echo ($order['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                            <option value="cancelled" <?php echo ($order['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../html/includes/end.php'; ?>