<?php 
require_once 'dbConfig.php';
require_once 'models.php';
session_start();


if (isset($_POST['loginBtn'])) {
    // Get and sanitize input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validation and error messages
    $errors = [];
    if (empty($username)) {
        $errors['username'] = "Username is required.";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required.";
    }

    // If there are errors, redirect back to login page
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../login.php");
        exit;
    }

    // Attempt login
    $user = loginUser($pdo, $username, $password);
    if ($user) {
        // Store user information in session including full name and redirect to projects.php
        $_SESSION['user'] = $user;
        header("Location: ../index.php");
        exit;
    } else {
        // Set a general error for failed login
        $_SESSION['errors']['general'] = "Invalid username or password.";
        header("Location: ../login.php");
        exit;
    }
}


if (isset($_POST['insertCrocheterBtn'])) {

    // Gather and sanitize input data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $repeatPassword = trim($_POST['repeatPassword']);
    $first_name = trim($_POST['firstName']);
    $last_name = trim($_POST['lastName']);
    $date_of_birth = trim($_POST['dateOfBirth']);
    $phone_number = trim($_POST['phoneNumber']);
    $email_address = trim($_POST['emailAddress']);
    $expertise = trim($_POST['expertise']);

    // Initialize errors array
    $errors = [];

    // Validation for each field
    if (!preg_match('/^[a-zA-Z0-9]{3,20}$/', $username)) {
        $errors['username'] = "Username must be alphanumeric and 3-20 characters long.";
    }

    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
        $errors['password'] = "Password must be at least 8 characters long, with at least one letter and one number.";
    }

    if ($password !== $repeatPassword) {
        $errors['repeatPassword'] = "Passwords do not match.";
    }

    if (!preg_match('/^[a-zA-Z]{1,50}$/', $first_name)) {
        $errors['firstName'] = "First name must contain only letters and be up to 50 characters.";
    }

    if (!preg_match('/^[a-zA-Z]{1,50}$/', $last_name)) {
        $errors['lastName'] = "Last name must contain only letters and be up to 50 characters.";
    }

    $dob_timestamp = strtotime($date_of_birth);
    if (!$dob_timestamp || $dob_timestamp > strtotime('-18 years') || $dob_timestamp < strtotime('-100 years')) {
        $errors['dateOfBirth'] = "Date of Birth must be a valid date for someone at least 18 years old.";
    }

    if (!preg_match('/^\d{7,15}$/', $phone_number)) {
        $errors['phoneNumber'] = "Phone number must be numeric and contain 7-15 digits.";
    }

    if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
        $errors['emailAddress'] = "Please enter a valid email address.";
    }

    if (strlen($expertise) > 255) {
        $errors['expertise'] = "Expertise must be less than 255 characters.";
    }

    // Redirect with errors if any validation fails
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header("Location: ../register.php");
        exit;
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Attempt to insert the crocheter into the database
        $result = insertCrocheter($pdo, $username, $hashed_password, $first_name, $last_name, $date_of_birth, $phone_number, $email_address, $expertise);

        // Check if insert was successful or if there's a conflict
        if ($result === true) {
            header("Location: ../index.php");
            exit;
        } else {
            // If the result contains an error, redirect back to the form with the error message
            $_SESSION['errors'] = ['general' => $result['error']];
            $_SESSION['form_data'] = $_POST;
            header("Location: ../register.php");
            exit;
        }
    }
}


if (isset($_POST['editCrocheterBtn'])) {
    $crocheterId = $_GET['crocheter_id'];
    $username = $_POST['username'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $phoneNumber = $_POST['phoneNumber'];
    $emailAddress = $_POST['emailAddress'];
    $expertise = $_POST['expertise'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeatPassword'];

    // Check if password fields match
    if (!empty($password) && $password !== $repeatPassword) {
        echo "Passwords do not match!";
        exit();
    }

    // Update the crocheter's profile, including password only if provided
    $query = updateCrocheter($pdo, $username, $firstName, $lastName, $dateOfBirth, $phoneNumber, $emailAddress, $expertise, $password, $crocheterId);

    if ($query) {
        header("Location: ../profile.php");
        exit();
    } else {
        echo "Edit failed";
    }
}


if (isset($_POST['deleteCrocheterBtn'])) {
    $query = deleteCrocheter($pdo, $_GET['crocheter_id']);

    if ($query) {
        // Destroy the session to log out the user
		session_start();
		session_unset();
		session_destroy();

		// Redirect to login page
		header("Location: ../login.php");
		exit;
    } else {
        echo "Deletion failed";
    }
}

if (isset($_POST['insertNewProjectBtn'])) {
    $query = insertProject($pdo, $_POST['projectName'], $_POST['typeOfCrochet'], $_GET['crocheter_id']);

    if ($query) {
        header("Location: ../projects.php?crocheter_id=" . $_GET['crocheter_id']);
        exit();
    } else {
        echo "Insertion failed";
    }
}

if (isset($_POST['editProjectBtn'])) {
    $query = updateProject($pdo, $_POST['projectName'], $_POST['typeOfCrochet'], $_GET['project_id'], $_GET['crocheter_id']);

    if ($query) {
        header("Location: ../projects.php?crocheter_id=" . $_GET['crocheter_id']);
        exit();
    } else {
        echo "Update failed";
    }
}

if (isset($_POST['deleteProjectBtn'])) {
    $query = deleteProject($pdo, $_GET['project_id']);

    if ($query) {
        header("Location: ../projects.php?crocheter_id=" . $_GET['crocheter_id']);
        exit();
    } else {
        echo "Deletion failed";
    }
}

?>
