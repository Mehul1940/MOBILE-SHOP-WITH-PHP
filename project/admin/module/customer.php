<?php require_once "/xampp/htdocs/Project/config/db.php" ?>
<?php require_once "/xampp/htdocs/Project/config/admincheck.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
    <link rel="stylesheet" href="/Project/assets/css/style.css">
    <script src="/Project/assets/js/main.js" defer></script>
</head>

<body>
    <div class="container">
        <!-- Include Navigation -->
        <?php require_once "../Nav.php" ?>

        <!-- Main Content -->
        <div class="main">
            <?php require_once "../main.php" ?>

            <!-- Customer Table -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Customers</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>CUSTOMER ID</td>
                                <td>CUSTOMER NAME</td>
                                <td>EMAIL</td>
                                <td>PHONE</td>
                                <td>STATUS</td> <!-- Display the status -->
                              
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Query to fetch customer details including the status
                            $sql = "SELECT CUSTOMER_ID, CUSTOMER_NAME, EMAIL, PHONE, ADDRESS, STATUS FROM customer";
                            $result = $conn->query($sql);

                            // Check for Results
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $status = ($row["STATUS"] == 'active') ? 'Active' : 'Inactive';
                                    echo '<tr>
                                        <td>' . htmlspecialchars($row["CUSTOMER_ID"]) . '</td>
                                        <td>' . htmlspecialchars($row["CUSTOMER_NAME"]) . '</td>
                                        <td>' . htmlspecialchars($row["EMAIL"]) . '</td>
                                        <td>' . htmlspecialchars($row["PHONE"]) . '</td>
                                        <td>' . $status . '</td> <!-- Display the status -->
                                        <td>';
                                    echo '</td>
                                    </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="7">No customers found</td></tr>';
                            }

                            // Close Connection
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- IonIcons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- JavaScript for status change -->
    <script>
        function changeStatus(customerId, newStatus) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "/Project/admin/update/update_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert("Customer status updated!");
                    location.reload(); // Reload the page to reflect changes
                }
            };
            xhr.send("customerId=" + customerId + "&status=" + newStatus);
        }
    </script>
</body>

</html>
