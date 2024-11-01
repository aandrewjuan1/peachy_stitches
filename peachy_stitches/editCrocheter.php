<?php 
require_once 'core/handleForms.php';
require_once 'core/models.php';
require_once 'core/auth.php'; 
requireAuth();

// Fetch crocheter data for pre-filling form
$crocheter = getCrocheterByID($pdo, $_GET['crocheter_id']); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Crocheter</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Edit Crocheter Profile</h1>
    <form action="core/handleForms.php?crocheter_id=<?php echo $_GET['crocheter_id']; ?>" method="POST">
        <p>
            <label for="username">Username</label> 
            <input type="text" name="username" value="<?php echo htmlspecialchars($crocheter['username']); ?>" required>
        </p>
        <p>
            <label for="firstName">First Name</label> 
            <input type="text" name="firstName" value="<?php echo htmlspecialchars($crocheter['first_name']); ?>" required>
        </p>
        <p>
            <label for="lastName">Last Name</label> 
            <input type="text" name="lastName" value="<?php echo htmlspecialchars($crocheter['last_name']); ?>" required>
        </p>
        <p>
            <label for="dateOfBirth">Date of Birth</label> 
            <input type="date" name="dateOfBirth" value="<?php echo htmlspecialchars($crocheter['date_of_birth']); ?>" required>
        </p>
        <p>
            <label for="phoneNumber">Phone Number</label> 
            <input type="text" name="phoneNumber" value="<?php echo htmlspecialchars($crocheter['phone_number']); ?>" required>
        </p>
        <p>
            <label for="emailAddress">Email Address</label> 
            <input type="email" name="emailAddress" value="<?php echo htmlspecialchars($crocheter['email_address']); ?>" required>
        </p>
        <p>
            <label for="expertise">Expertise</label> 
            <input type="text" name="expertise" value="<?php echo htmlspecialchars($crocheter['expertise']); ?>" required>
        </p>
        <p>
            <label for="password">New Password</label> 
            <input type="password" name="password">
        </p>
        <p>
            <label for="repeatPassword">Repeat New Password</label> 
            <input type="password" name="repeatPassword">
        </p>
        <p>
            <input type="submit" name="editCrocheterBtn" value="Save Changes">
        </p>
    </form>
</body>
</html>
