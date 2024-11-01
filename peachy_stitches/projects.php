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
    <title><?php echo htmlspecialchars($userProfile['first_name'] . ' ' . $userProfile['last_name']); ?> - Projects</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <nav>
        <a href="index.php">Return to Projects</a>
    </nav>
    
    <h1>Username: <?php echo htmlspecialchars($userProfile['username']); ?></h1>
    
    <h2>Add New Project</h2>
    <form action="core/handleForms.php?crocheter_id=<?php echo $crocheterId; ?>" method="POST">
        <p>
            <label for="projectName">Project Name:</label> 
            <input type="text" name="projectName" required>
        </p>
        <p>
            <label for="typeOfCrochet">Type of Crochet:</label> 
            <input type="text" name="typeOfCrochet" required> 
            <input type="submit" name="insertNewProjectBtn" value="Add Project">
        </p>
    </form>

    <h2>My Projects</h2>
    <table style="width:100%; margin-top: 20px; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Project ID</th>
                <th>Project Name</th>
                <th>Type of Crochet</th> 
                <th>Project Owner</th>
                <th>Date Added</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $getProjectsByCrocheter = getProjectsByCrocheter($pdo, $crocheterId); 
        if (!empty($getProjectsByCrocheter)) {
            foreach ($getProjectsByCrocheter as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['project_id']); ?></td>      
                    <td><?php echo htmlspecialchars($row['project_name']); ?></td>      
                    <td><?php echo htmlspecialchars($row['type_of_crochet']); ?></td> 
                    <td><?php echo htmlspecialchars($row['project_owner']); ?></td>      
                    <td><?php echo htmlspecialchars($row['date_added']); ?></td>
                    <td>
                        <a href="editproject.php?project_id=<?php echo $row['project_id']; ?>&crocheter_id=<?php echo $crocheterId; ?>">Edit</a> |
                        <a href="deleteproject.php?project_id=<?php echo $row['project_id']; ?>&crocheter_id=<?php echo $crocheterId; ?>">Delete</a>
                    </td>      
                </tr>
            <?php }
        } else { ?>
            <tr>
                <td colspan="6">No projects found.</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</body>
</html>
