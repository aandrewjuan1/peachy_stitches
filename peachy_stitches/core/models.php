<?php  

function insertCrocheter($pdo, $username, $password, $first_name, $last_name, 
    $date_of_birth, $phone_number, $email_address, $expertise) {

    // Check if username or email already exists
    $checkSql = "SELECT COUNT(*) FROM crocheters WHERE username = ? OR email_address = ?";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([$username, $email_address]);
    $count = $checkStmt->fetchColumn();

    if ($count > 0) {
        // If a user with this username or email already exists, return an error
        return ['error' => 'Username or email already exists'];
    }

    // If no conflict, proceed with insertion
    $sql = "INSERT INTO crocheters (username, password, first_name, last_name, 
        date_of_birth, phone_number, email_address, expertise) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$username, $password, $first_name, $last_name, 
        $date_of_birth, $phone_number, $email_address, $expertise]);

    if ($executeQuery) {
        return true;
    } else {
        return ['error' => 'Database insertion error'];
    }
}

function loginUser($pdo, $username, $password) {
    // Prepare the SQL statement to fetch user details
    $sql = "SELECT crocheter_id, username, password, first_name, last_name FROM crocheters WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);

    // Fetch user data if username exists
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        // Password is correct; return user data including first and last name
        return [
            'crocheter_id' => $user['crocheter_id'],
            'username' => $user['username'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name']
        ];
    }
    return false; // Login failed
}

function updateCrocheter($pdo, $username, $firstName, $lastName, $dateOfBirth, $phoneNumber, $emailAddress, $expertise, $password, $crocheterId) {
    // Base SQL query without password update
    $sql = "UPDATE crocheters SET username = ?, first_name = ?, last_name = ?, date_of_birth = ?, phone_number = ?, email_address = ?, expertise = ?";
    $params = [$username, $firstName, $lastName, $dateOfBirth, $phoneNumber, $emailAddress, $expertise];

    // If a new password is provided, include it in the update
    if (!empty($password)) {
        $sql .= ", password = ?";
        $params[] = password_hash($password, PASSWORD_BCRYPT);
    }

    $sql .= " WHERE crocheter_id = ?";
    $params[] = $crocheterId;

    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}


function deleteCrocheter($pdo, $crocheterId) {
    $sql = "DELETE FROM crocheters WHERE crocheter_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$crocheterId]);
}

function insertProject($pdo, $projectName, $typeOfCrochet, $crocheterId) {
    $sql = "INSERT INTO projects (project_name, type_of_crochet, crocheter_id, created_by) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$projectName, $typeOfCrochet, $crocheterId, $crocheterId]);
}

function updateProject($pdo, $projectName, $typeOfCrochet, $projectId, $crocheterId) {
    // SQL statement to update project details and set the current timestamp for last_updated_at
    $sql = "UPDATE projects SET project_name = ?, type_of_crochet = ?, last_updated_at = CURRENT_TIMESTAMP WHERE project_id = ?";
    $stmt = $pdo->prepare($sql);
    
    // Execute the query with the provided project details and the project ID
    return $stmt->execute([$projectName, $typeOfCrochet, $projectId]);
}

function deleteProject($pdo, $projectId) {
    $sql = "DELETE FROM projects WHERE project_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$projectId]);
}

function getAllCrocheters($pdo) {
    $sql = "SELECT * FROM crocheters";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getCrocheterByID($pdo, $crocheter_id) {
    $sql = "SELECT * FROM crocheters WHERE crocheter_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$crocheter_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

function getProjectsByCrocheter($pdo, $crocheter_id) {
    $sql = "SELECT 
                projects.project_id AS project_id,
                projects.project_name AS project_name,
                projects.type_of_crochet AS type_of_crochet,
                projects.date_added AS date_added,
                CONCAT(crocheters.first_name, ' ', crocheters.last_name) AS project_owner
            FROM projects
            JOIN crocheters ON projects.crocheter_id = crocheters.crocheter_id
            WHERE projects.crocheter_id = ? 
            GROUP BY projects.project_name;";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$crocheter_id]);
    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getAllProjects($pdo) {
    $sql = "SELECT 
                projects.project_id AS project_id,
                projects.project_name AS project_name,
                projects.type_of_crochet AS type_of_crochet,
                projects.date_added AS date_added,
                CONCAT(creator.first_name, ' ', creator.last_name) AS created_by,
                projects.last_updated_at AS last_updated_at  -- Include last_updated_at in the selection
            FROM projects
            JOIN crocheters AS creator ON projects.created_by = creator.crocheter_id
            ORDER BY projects.project_id";  // Use ORDER BY to ensure proper grouping

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getProjectByID($pdo, $project_id) {
    $sql = "SELECT 
                projects.project_id AS project_id,
                projects.project_name AS project_name,
                projects.type_of_crochet AS type_of_crochet,
                projects.date_added AS date_added,
                CONCAT(crocheters.first_name, ' ', crocheters.last_name) AS project_owner
            FROM projects
            JOIN crocheters ON projects.crocheter_id = crocheters.crocheter_id
            WHERE projects.project_id = ?";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$project_id]);
    if ($executeQuery) {
        return $stmt->fetch();
    }
}

?>
