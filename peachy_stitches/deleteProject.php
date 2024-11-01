<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 
require_once 'core/auth.php'; 
requireAuth();

if (isset($_GET['project_id']) && !empty($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    $getProjectByID = getProjectByID($pdo, $project_id);

    if (!$getProjectByID) {
        die('Error: Project not found.');
    }
} else {
    die('Error: Project ID not provided.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Project</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Are you sure you want to delete this project?</h1>
    <div class="container" style="border-style: solid; height: 400px;">
        <h2>Project Name: <?php echo htmlspecialchars($getProjectByID['project_name']); ?></h2>
        <h2>Type of Crochet: <?php echo htmlspecialchars($getProjectByID['type_of_crochet']); ?></h2>
        <h2>Project Owner: <?php echo htmlspecialchars($getProjectByID['project_owner']); ?></h2>
        <h2>Date Added: <?php echo htmlspecialchars($getProjectByID['date_added']); ?></h2>

        <div class="deleteBtn" style="float: right; margin-right: 10px;">
            <form action="core/handleForms.php?project_id=<?php echo $project_id; ?>&crocheter_id=<?php echo $_GET['crocheter_id']; ?>" method="POST">
                <input type="submit" name="deleteProjectBtn" value="Delete">
            </form>
        </div>  
    </div>
</body>
</html>