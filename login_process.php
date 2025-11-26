<?php
session_start();

$conn = new mysqli("localhost", "root", "", "shop_orders");
if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $_SESSION['email'] = $email;

    // Save sign-in
    $signin = $conn->prepare("INSERT INTO signin (email) VALUES (?)");
    if ($signin) {
        $signin->bind_param("s", $email);
        $signin->execute();
        $signin->close();
    }

    // Show SweetAlert popup
    echo '
    <html>
    <head>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
      <script>
        Swal.fire({
          icon: "success",
          title: "Signed In Successfully!",
          text: "Welcome back to Hijab Heaven 💫",
          confirmButtonColor: "#000",
          confirmButtonText: "Continue"
        }).then(() => {
          window.location.href = "hijab.html";
        });
      </script>
    </body>
    </html>
    ';
    exit();

} else {
    echo '
    <html>
    <head>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
      <script>
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Invalid email or password!",
          confirmButtonColor: "#000"
        }).then(() => {
          window.location.href = "login.html";
        });
      </script>
    </body>
    </html>
    ';
}

$stmt->close();
$conn->close();
?>

