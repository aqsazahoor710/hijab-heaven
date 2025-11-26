
<?php
$conn = new mysqli("localhost", "root", "", "shop_orders");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ab sirf orders table se data lete hain
$sql = "SELECT * FROM orders ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin - Orders</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      padding: 40px;
    }
    h1 {
      text-align: center;
      margin-bottom: 30px;
    }
    table {
      width: 98%;
      margin: auto;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0 0 10px #ccc;
    }
    th, td {
      padding: 18px; /* Bada size */
      border: 1px solid #ccc;
      text-align: left;
      font-size: 16px; /* Readable */
    }
    th {
      background: #000;
      color: white;
    }
    tr:nth-child(even) {
      background: #f9f9f9;
    }
  </style>
</head>
<body>

<h1>All Customer Orders</h1>
<table>
  <tr>
    <th>ID</th>
    <th>Customer</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Address</th>
    <th>City</th>
    <th>Postal Code</th>
    <th>Payment</th>
    <th>Product</th>
    <th>Quantity</th>
    <th>Price</th>
    <th>Order Date</th>
  
  </tr>

  <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars($row['phone']) ?></td>
      <td><?= htmlspecialchars($row['address']) ?></td>
      <td><?= htmlspecialchars($row['city']) ?></td>
      <td><?= htmlspecialchars($row['postal_code']) ?></td>
      <td><?= htmlspecialchars($row['payment']) ?></td>
      <td><?= htmlspecialchars($row['product_name']) ?></td>
      <td><?= $row['quantity'] ?: '-' ?></td>
      <td><?= $row['price'] ? 'Rs. ' . number_format($row['price']) : '-' ?></td>
      <td><?= $row['order_date'] ?></td>
     
    </tr>
  <?php endwhile; ?>
</table>

</body>
</html>
