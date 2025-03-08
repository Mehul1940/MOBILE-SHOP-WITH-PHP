<?php
require_once "/xampp/htdocs/Project/config/admincheck.php";
require_once "/xampp/htdocs/Project/config/db.php";

// Handle form submission for adding a new service
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_service'])) {
    $serviceName = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Insert the new service into the database
    $insertQuery = "INSERT INTO services (SERVICE_NAME, DESCRIPTION, PRICE) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssd", $serviceName, $description, $price);

    if ($stmt->execute()) {
        header("Location: /Project/admin/module/service.php"); // Redirect to services list page
        exit();
    } else {
        echo "Error adding service.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service</title>
    <link rel="stylesheet" href="/Project/assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(255, 255, 255);
            color: dimgray;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 500px;
            background:rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #444;
            border-radius: 5px;
            background-color: white;
            color: black;
        }

        button {
            width: 100%;
            padding: 10px;
            background:rgb(0, 181, 60);
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: rgb(0, 181, 60);
        }

        .cancel-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background: #ff3b3b;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }

        .cancel-btn:hover {
            background: #d32f2f;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="details">
            <h2>Add New Service</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="service_name">Service Name</label>
                    <input type="text" id="service_name" name="service_name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" required>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" step="0.01" required>
                </div>
                <button type="submit" name="add_service">Add Service</button>
                <a href="/Project/admin/module/service.php" class="cancel-btn">Cancel</a>
            </form>
        </div>
    </div>
    </div>
</body>

</html>