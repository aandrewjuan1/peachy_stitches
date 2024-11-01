<?php 
require_once 'core/auth.php';
redirectIfAuthenticated(); // Redirects to projects if the user is already logged in
$errors = $_SESSION['errors'] ?? [];
$form_data = $_SESSION['form_data'] ?? [];
unset($_SESSION['errors'], $_SESSION['form_data']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Peachy Stitches Registration</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<h1>Welcome to Peachy Stitches! Register to become one of our crocheters! (˶˃ ᵕ ˂˶) .ᐟ.ᐟ</h1>
	<form action="core/handleForms.php" method="POST">
		<p>
			<label for="username">Username</label> 
			<input type="text" name="username" value="<?= htmlspecialchars($form_data['username'] ?? '') ?>" required>
			<span class="error"><?= $errors['username'] ?? '' ?></span>
		</p>
		<p>
			<label for="password">Password</label> 
			<input type="password" name="password" required>
			<span class="error"><?= $errors['password'] ?? '' ?></span>
		</p>
		<p>
			<label for="repeatPassword">Repeat Password</label> 
			<input type="password" name="repeatPassword" required>
			<span class="error"><?= $errors['repeatPassword'] ?? '' ?></span>
		</p>
		<p>
			<label for="firstName">First Name</label> 
			<input type="text" name="firstName" value="<?= htmlspecialchars($form_data['firstName'] ?? '') ?>" required>
			<span class="error"><?= $errors['firstName'] ?? '' ?></span>
		</p>
		<p>
			<label for="lastName">Last Name</label> 
			<input type="text" name="lastName" value="<?= htmlspecialchars($form_data['lastName'] ?? '') ?>" required>
			<span class="error"><?= $errors['lastName'] ?? '' ?></span>
		</p>
		<p>
			<label for="dateOfBirth">Date of Birth</label> 
			<input type="date" name="dateOfBirth" value="<?= htmlspecialchars($form_data['dateOfBirth'] ?? '') ?>" required>
			<span class="error"><?= $errors['dateOfBirth'] ?? '' ?></span>
		</p>
        <p>
			<label for="phoneNumber">Phone Number</label> 
			<input type="text" name="phoneNumber" value="<?= htmlspecialchars($form_data['phoneNumber'] ?? '') ?>" required>
			<span class="error"><?= $errors['phoneNumber'] ?? '' ?></span>
		</p>
        <p>
			<label for="emailAddress">Email Address</label> 
			<input type="email" name="emailAddress" value="<?= htmlspecialchars($form_data['emailAddress'] ?? '') ?>" required>
			<span class="error"><?= $errors['emailAddress'] ?? '' ?></span>
		</p>
		<p>
			<label for="expertise">Expertise</label> 
			<input type="text" name="expertise" value="<?= htmlspecialchars($form_data['expertise'] ?? '') ?>" required>
			<span class="error"><?= $errors['expertise'] ?? '' ?></span>
		</p>
        <p>
            <input type="submit" name="insertCrocheterBtn" value="Register">
		</p>
	</form>
    <a href="login.php">Login</a>
</body>
</html>
