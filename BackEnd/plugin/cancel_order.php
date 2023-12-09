<?php
session_start();
include('dbcon.php');


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["orderId"])) {
        // Get the order ID from the form submission
        $orderId = $_POST["orderId"];

        // Update the order status to 3 (Cancelled) in your Firebase database
        include('dbcon.php');
        $ref_table = "Requests";
        $database->getReference($ref_table)->getChild($orderId)->getChild("status")->set(3);

        // Redirect the user back to the page where they initiated the cancellation
        header("Location: purchase_order.php"); // Replace "previous_page.php" with the actual page URL
        exit();
    }
}

// Redirect the user to the homepage if the cancellation form is accessed directly without a POST request
// header("Location: index.php"); // Replace "index.php" with the actual homepage URL
// exit();
?>
