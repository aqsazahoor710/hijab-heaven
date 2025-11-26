
<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "shop_orders");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Form data
$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];

// Check if user already exists
$check = $conn->prepare("SELECT * FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('❌ Account already exists with this email'); window.location.href='createaccount.html';</script>";
} else {
    // Insert new user
    $sql = $conn->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssss", $fname, $lname, $email, $password);

    if ($sql->execute()) {
        // Redirect after success
        header("Location: createthanku.html");
        exit();
    } else {
        echo "❌ Error: " . $conn->error;
    }

    $sql->close();
}

$check->close();
$conn->close();
?>
