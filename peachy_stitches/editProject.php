<?php
require_once 'core/models.php';
require_once 'core/dbConfig.php'; 
require_once 'core/auth.php'; 
requireAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<a href="projects.php?crocheter_id=<?php echo $_GET['crocheter_id']; ?>">View The Projects</a>
	<h1>Edit the crochet project!</h1>
	<?php $getProjectByID = getProjectByID($pdo, $_GET['project_id']); ?>
	<form action="core/handleForms.php?project_id=<?php echo $_GET['project_id']; ?>
	&crocheter_id=<?php echo $_GET['crocheter_id']; ?>" method="POST">
		<p>
			<label for="projectName">Project Name</label> 
			<input type="text" name="projectName" 
			value="<?php echo $getProjectByID['project_name']; ?>">
		</p>
		<p>
			<label for="typeOfCrochet">Type of Crochet</label> 
			<input type="text" name="typeOfCrochet" 
			value="<?php echo $getProjectByID['type_of_crochet']; ?>">
			<input type="submit" name="editProjectBtn">
		</p>
	</form>
</body>
</html>