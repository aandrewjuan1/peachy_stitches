<?php 
require_once 'core/dbConfig.php';
require_once 'core/models.php';
require_once 'core/auth.php'; 
requireAuth();

// Fetch the logged-in user's name from the session
$userFullName = isset($_SESSION['user']['first_name'], $_SESSION['user']['last_name']) 
    ? $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name'] 
    : 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Project List</title>
	<link rel="stylesheet" href="styles.css">

</head>
<body>

	<h1>Welcome, <?php echo htmlspecialchars($userFullName); ?>!</h1>
	<a href="projects.php">My Projects</a>
	<a href="profile.php" class="button">View Profile</a>
	<!-- Add a logout button -->
	<form action="logout.php" method="POST" style="display:inline;">
		<button type="submit" name="logoutBtn">Logout</button>
	</form>

	<h1>List of all projects from different crocheters:</h1>
	<?php
		// Fetch all projects from the database
		$projects = getAllProjects($pdo);
	?>

	<table>
		<thead>
			<tr>
				<th>Project Name</th>
				<th>Type of Crochet</th>
				<th>Created By</th>
				<th>Date Added</th>
				<th>Last Updated At</th>
			</tr>
		</thead>
		<tbody>
			<?php if ($projects && count($projects) > 0): ?>
				<?php foreach ($projects as $project): ?>
					<tr>
						<td><?php echo htmlspecialchars($project['project_name']); ?></td>
						<td><?php echo htmlspecialchars($project['type_of_crochet']); ?></td>
						<td><?php echo htmlspecialchars($project['created_by']); ?></td>
						<td><?php echo htmlspecialchars($project['date_added']); ?></td>
						<td><?php echo htmlspecialchars($project['last_updated_at'] ?? 'N/A'); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="7">No projects found.</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>

</body>
</html>
