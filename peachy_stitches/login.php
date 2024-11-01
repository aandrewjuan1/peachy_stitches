<?php
require_once 'core/auth.php';
redirectIfAuthenticated(); // Redirects to projects if the user is already logged in
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Peachy Stitches Log In</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<h1>Welcome Back to Peachy Stitches! Please Log In (˶˃ ᵕ ˂˶) .ᐟ.ᐟ</h1>
	<form action="core/handleForms.php" method="POST">
		<p>
			<label for="username">Username</label> 
			<input type="text" name="username" required>
			<?php if (isset($_SESSION['errors']['username'])): ?>
				<span class="error"><?= $_SESSION['errors']['username'] ?></span>
			<?php endif; ?>
		</p>
		<p>
			<label for="password">Password</label> 
			<input type="password" name="password" required>
			<?php if (isset($_SESSION['errors']['password'])): ?>
				<span class="error"><?= $_SESSION['errors']['password'] ?></span>
			<?php endif; ?>
		</p>
        <p>
            <input type="submit" name="loginBtn" value="Log In">
        </p>
        <?php if (isset($_SESSION['errors']['general'])): ?>
			<p class="error"><?= $_SESSION['errors']['general'] ?></p>
		<?php endif; ?>
	</form>
    <a href="register.php">Create an account</a>

</body>
</html>
