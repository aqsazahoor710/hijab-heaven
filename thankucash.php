

<?php
$conn = new mysqli("localhost", "root", "", "shop_orders");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

// Default values
$name = "Customer";
$email = "N/A";
$product = "-";
$quantity = "-";
$price = "-";

if ($order_id > 0) {
    $sql = "SELECT name, email, product_name, quantity, price 
            FROM orders 
            WHERE id = $order_id LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $product = $row['product_name'] ?: "-";
        $quantity = $row['quantity'] ?: "-";
        $price = $row['price'] ? "Rs. " . number_format($row['price']) : "-";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Thank You – Hijab Heaven</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet"/>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #fef6f0;
      font-family: 'Times New Roman', Times, serif;
      color: #000;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
      justify-content: center;
    }
    .container {
      background-color: #fff;
      padding: 40px;
      border-radius: 20px;
      max-width: 700px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      text-align: center;
      margin-top: 50px;
      margin-bottom: 50px;
    }
    h1 {
      font-family: 'Times New Roman', Times, serif;
      color: #000;
      font-size: 2.5em;
      margin-bottom: 10px;
      opacity: 0;
      margin-top: 5px;
      transform: translateY(30px);
      animation: fadeup 2s ease-out forwards;
    }
    @keyframes fadeup {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    .message {
      font-size: 1.1em;
      margin: 15px 0 25px;
    }
    .info {
      background-color: #eef1f1;
      padding: 20px;
      border-radius: 12px;
      text-align: left;
      margin-bottom: 30px;
    }
    .info p {
      margin: 8px 0;
    }
    .btn {
      display: inline-block;
      padding: 12px 30px;
      background-color: #000;
      color: white;
      border: none;
      border-radius: 30px;
      font-size: 1em;
      text-decoration: none;
      margin-top: 20px;
      transition: background 0.3s;
      font-style: italic;
    }
    .btn:hover {
      background-color: #8d9193;
    }
    .footer {
      margin-top: 40px;
      font-style: italic;
      font-size: 1em;
      color: #000;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Thank You, <?php echo htmlspecialchars($name); ?>!</h1>
    <p class="message">
      Your order has been placed successfully and is now being prepared with love.  
      We're honored to be part of your modest fashion journey.
    </p>

    <div class="info">
      <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
      <p><strong>Order Number:</strong> #HH<?php echo str_pad($order_id, 4, "0", STR_PAD_LEFT); ?></p>
      <p><strong>Product:</strong> <?php echo htmlspecialchars($product); ?></p>
      <p><strong>Quantity:</strong> <?php echo htmlspecialchars($quantity); ?></p>
      <p><strong>Price:</strong> <?php echo $price; ?></p>
      <p><strong>Estimated Delivery:</strong> 3–5 working days</p>
      <p><strong>Tracking:</strong> You’ll receive a link via email/SMS soon.</p>
    </div>

    <a href="./hijab.html" class="btn">Continue Shopping</a>

    <div class="footer">
      Stay graceful. Stay powerful. <br> Hijab Heaven 🌸
    </div>
  </div>
</body>
</html>
