<?php
    include "head.php";
?>
<body>
    <!-- Login Form -->
    <form method="post" name="login" class="login-form">
        <input type="email" name="email" placeholder="email" required> <br>
        <input type="password" name="password" placeholder="Password" required> <br>
        <input type="submit" value="Login">
    </form>
    <!-- Hide navbar -->
    <script>
        document.getElementsByTagName("nav")[0].style.display = "none";
    </script>
    <?php
        // Check if the form is submitted
        require 'db.php';
        session_start();
        if (isset($_POST['email']) && isset($_POST['password'])) {
            // Get the form data
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            // Check if the user is valid, query database
            $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                // If the user is valid, find role and set session
                header("Location: admin_dashboard.php");
                $row = mysqli_fetch_assoc($result);
                $role = $row['role'];
                $_SESSION["role"] = $role;
                $_SESSION["user_id"] = $_POST['email'];
                // Redirect to the appropriate page
                if ($role == 'admin') {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: user_dashboard.php");
                }
            } else {
                // If the user is invalid, alert user
                echo "<script>alert('Invalid email or password');</script>";
            }
        }
    ?>
</body>