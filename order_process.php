
<?php
$conn = new mysqli("localhost", "root", "", "shop_orders");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form se values lena
$firstname = $_POST['firstname'];
$lastname  = $_POST['lastname'];
$email     = $_POST['email'];
$phone     = $_POST['phone'];
$address   = $_POST['address'];
$apartment = $_POST['apartment'];
$city      = $_POST['city'];
$postal    = $_POST['postalcode'];
$payment   = $_POST['payment'];

// Full name & address
$fullname = trim($firstname . " " . $lastname);
$fulladdress = trim($address . " " . $apartment);

// Product info
$product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
$quantity     = isset($_POST['quantity']) && $_POST['quantity'] !== '' ? intval($_POST['quantity']) : 1;

$price_per_item = isset($_POST['price']) && $_POST['price'] !== '' ? floatval($_POST['price']) : 0;
$price = $price_per_item * $quantity; // total price calculation

$order_date = date("Y-m-d H:i:s");

// Orders table me insert
$order_sql = "INSERT INTO orders 
(name, email, phone, address, city, postal_code, payment, product_name, quantity, price, order_date)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($order_sql);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// s=string, i=integer, d=double (float)
$stmt->bind_param(
    "ssssssssids",
    $fullname,      // s
    $email,         // s
    $phone,         // s
    $fulladdress,   // s
    $city,          // s
    $postal,        // s
    $payment,       // s
    $product_name,  // s
    $quantity,      // i
    $price,         // d
    $order_date     // s
);

if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

// Last inserted order ka ID lena
$order_id = $conn->insert_id;

$stmt->close();
$conn->close();

// Redirect ke sath order_id bhejna
header("Location: thankucash.php?order_id=" . $order_id);
exit();
?>
