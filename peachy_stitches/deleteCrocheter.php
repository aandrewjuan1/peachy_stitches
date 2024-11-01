<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 
require_once 'core/auth.php'; 
requireAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Crocheter</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Are you sure you want to delete this crocheter?</h1>
    <?php $getCrocheterByID = getCrocheterByID($pdo, $_GET['crocheter_id']); ?>
    <div class="container" style="border-style: solid; width: 50%; height: 400px; margin-top: 20px;">
        <h2>Username: <?php echo htmlspecialchars($getCrocheterByID['username']); ?></h2>
        <h2>First Name: <?php echo htmlspecialchars($getCrocheterByID['first_name']); ?></h2>
        <h2>Last Name: <?php echo htmlspecialchars($getCrocheterByID['last_name']); ?></h2>
        <h2>Date Of Birth: <?php echo htmlspecialchars($getCrocheterByID['date_of_birth']); ?></h2>
        <h2>Phone Number: <?php echo htmlspecialchars($getCrocheterByID['phone_number']); ?></h2>
        <h2>Email Address: <?php echo htmlspecialchars($getCrocheterByID['email_address']); ?></h2>
        <h2>Expertise: <?php echo htmlspecialchars($getCrocheterByID['expertise']); ?></h2>
        <h2>Date Added: <?php echo htmlspecialchars($getCrocheterByID['date_added']); ?></h2>

        <div class="deleteBtn" style="float: right; margin-right: 10px;">
            <form action="core/handleForms.php?crocheter_id=<?php echo $_GET['crocheter_id']; ?>" method="POST">
                <input type="submit" name="deleteCrocheterBtn" value="Delete">
            </form>			
        </div>	
        <a href=""></a>
    </div>
</body>
</html>
