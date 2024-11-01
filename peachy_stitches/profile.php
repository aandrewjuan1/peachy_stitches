<?php 
require_once 'core/dbConfig.php';
require_once 'core/models.php';
require_once 'core/auth.php'; 
requireAuth(); // Ensure the user is authenticated

// Get the logged-in user's ID from the session
$crocheterId = $_SESSION['user']['crocheter_id'];

// Fetch the user's profile from the database
$userProfile = getCrocheterByID($pdo, $crocheterId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>User Profile</h1>

    <?php if ($userProfile): ?>
        <h2>Welcome, <?php echo htmlspecialchars($userProfile['first_name'] . ' ' . $userProfile['last_name']); ?>!</h2>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($userProfile['username']); ?></p>
        <p><strong>Email Address:</strong> <?php echo htmlspecialchars($userProfile['email_address']); ?></p>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($userProfile['phone_number']); ?></p>
        <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($userProfile['date_of_birth']); ?></p>
        <p><strong>Expertise:</strong> <?php echo htmlspecialchars($userProfile['expertise']); ?></p>
    <?php else: ?>
        <p>User profile not found.</p>
    <?php endif; ?>
    
    <a href="editcrocheter.php?crocheter_id=<?php echo $userProfile['crocheter_id']; ?>">Edit</a>
    <a href="deletecrocheter.php?crocheter_id=<?php echo $userProfile['crocheter_id']; ?>">Delete</a>

    <!-- Button to go back to projects -->
     <br>
    <a href="index.php">Back to Projects</a>
</body>
</html>
