<?php
include '../db_config.php';

$emailError = $passwordError = $Email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($Email)) {
        $emailError = "Email is required";
    }
    if (empty($password)) {
        $passwordError = "Password is required";
    }

    if (empty($emailError) && empty($passwordError)) {
        $sql = "SELECT email, password, role FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $Email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                if ($user['role'] == 'Admin') {
                    header('Location: ../admin/html/index.php');
                    exit();
                } elseif ($user['role'] == 'Customer') {
                    header('Location: ../home_page/index.php');
                    exit();
                }
            } else {
                $passwordError = "Invalid Email or Password.";
            }
        } else {
            $emailError = "Invalid Email or Password.";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <h2>Log in</h2>
        <form id="loginForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo $Email; ?>">
            <span class="error-message" id="email-error"><?php echo $emailError; ?></span>

            <input type="password" id="password" name="password" placeholder="Password">
            <span class="error-message" id="password-error"><?php echo $passwordError; ?></span>

            <button type="submit">Login</button>
        </form>

        <div class="signup">
            <b>I don't have an account yet</b>
            <a style="text-decoration: none; color:#F72C5B;" href="../SignUp/SignUp.php"><b>Register a new account</a>
        </div>
    </div>
</body>
</html>