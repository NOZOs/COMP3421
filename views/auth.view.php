<?php
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
unset($_SESSION['errors'], $_SESSION['success']);
?>

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="style.css">

<body>

    <div class="container">

    <div class="toggle-box">
        <div class="toggle-panel toggle-left">
            <h1>Welcome Back!</h1>
            <p>Do not have an Account?</p>
            <button class="btn register-btn">Register</button>
        </div>

        <div class="toggle-panel toggle-right">
            <h1>Hellow, Welcome!</h1>
            <p>Already have an Account?</p>
            <button class="btn login-btn">Login</button>
        </div>
    </div>

        <!-- Login page -->
        <div class="form-box login">
        <div class="form">
            <h1>Login</h1>
            <?php if (isset($errors['login'])): ?>
                <div class="error-message"><?= $errors['login'] ?></div>
            <?php endif; ?>
            <form method="POST" action="controllers/login.controller.php">
                <div class="input-box">
                    <input type="text" name="identifier" placeholder="Username or Email" required>
                    <i class='bx bx-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bx-lock'></i>
                </div>
                <button type="submit" name="login" class="btn">Login</button>
            </form>
        </div>
        </div>

        <!-- Register page -->
        <div class="form-box register">
        <div class="form">
            <h1>Register</h1>
            <?php if (isset($errors['register'])): ?>
                <div class="error-message"><?= $errors['register'] ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success-message"><?= $success ?></div>
            <?php endif; ?>
            <form method="POST" action="controllers/register.controller.php">
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username" required>
                    <i class='bx bx-user'></i>
                </div>
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class='bx bx-envelope'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bx-lock'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    <i class='bx bx-lock'></i>
                </div>
                <div class="role-select">
                    <select name="role" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" name="register" class="btn">Register</button>
            </form>
        </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>