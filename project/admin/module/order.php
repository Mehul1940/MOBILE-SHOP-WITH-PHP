<?php require_once "/xampp/htdocs/Project/config/db.php" ?>
<?php require_once "/xampp/htdocs/Project/config/admincheck.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
    <link rel="stylesheet" href="/project/assets/css/modal.css">
    <link rel="stylesheet" href="/project/assets/css/style.css">
    <script src="/Project/assets/js/updateOrder.js" defer></script>
    <script src="/Project/assets/js/main.js" defer></script>
</head>

<body>
    <div class="container">
        <?php require_once "/xampp/htdocs/Project/admin/Nav.php" ?>

        <div class="main">
            <?php require_once "/xampp/htdocs/Project/admin/main.php" ?>

            <!-- Customer Table -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Orders</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Customer Name</th>
                                <th>Delivery Address</th>
                                <th>Order Date</th>
                                <th>Delivery Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT orders.ORDER_ID, orders.CUSTOMER_ID, orders.TOTAL_AMT, 
                           orders.DELIVERY_ADDRESS, orders.DELIVERY_STATUS, orders.ORDER_DATE, 
                           customer.CUSTOMER_NAME
                           FROM orders
                           LEFT JOIN customer ON orders.CUSTOMER_ID = customer.CUSTOMER_ID";

                            $result = $conn->query($sql);

                            if (!$result) {
                                die("Query failed: " . $conn->error);
                            }

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>
                                <td>' . htmlspecialchars($row["ORDER_ID"]) . '</td>
                                <td>' . htmlspecialchars($row["CUSTOMER_NAME"] ?? 'N/A') . '</td>
                                <td>' . htmlspecialchars($row["DELIVERY_ADDRESS"]) . '</td>
                                <td>' . htmlspecialchars($row["ORDER_DATE"]) . '</td>
                                <td>
                                    <span class="status-badge ' . (strtolower($row['DELIVERY_STATUS']) === 'completed' ? 'status-success' : 'status-warning') . '">
                                        ' . htmlspecialchars(ucfirst(strtolower($row['DELIVERY_STATUS']))) . '
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm update-btn"
                                            data-id="' . $row["ORDER_ID"] . '"
                                            data-customer="' . $row["CUSTOMER_ID"] . '"
                                            data-amount="' . $row["TOTAL_AMT"] . '"
                                            data-address="' . $row["DELIVERY_ADDRESS"] . '"
                                            data-status="' . $row["DELIVERY_STATUS"] . '">
                                        Update
                                    </button>
                                    
                                    <a href="/Project/admin/module/order_detail.php?order_id=' . $row["ORDER_ID"] . '" class="btn btn-primary view-details-btn">
                                        View Detail
                                    </a>
                                </td>
                            </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center">No orders found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Update Order Modal -->
            <div id="updateOrderModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Update Order</h2>
                        <span class="close-btn" id="closeModal">&times;</span>
                    </div>
                    <hr style=" margin-bottom: 15px;">
                    <form id="updateOrderForm" action="/Project/admin/update/update_order.php" method="post">
                        <div class="form-group">
                            <label for="order_id">Order ID</label>
                            <input type="text" id="order_id" name="order_id" readonly>
                        </div>
                        <div class="form-group">
                            <label for="customer_id">Customer ID</label>
                            <input type="text" id="customer_id" name="customer_id" readonly>
                        </div>
                        <div class="form-group" hidden>
                            <label for="total_amt">Total Amount</label>
                            <input type="number" id="total_amt" name="total_amt" readonly>
                        </div>
                        <div class="form-group">
                            <label for="delivery_address">Delivery Address</label>
                            <input type="text" id="delivery_address" name="delivery_address">
                        </div>
                        <div class="form-group">
                            <label for="delivery_status">Delivery Status</label>
                            <select id="delivery_status" name="delivery_status" required>
                                <option value="Pending">Pending</option>
                                <option value="Shipped">Shipped</option>
                                <option value="Delivered">Delivered</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <button type="button" class="btn btn-secondary" id="cancelModal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

</body>

</html>