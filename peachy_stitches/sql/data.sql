CREATE TABLE crocheters (
    crocheter_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255), -- Password column for authentication
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    date_of_birth DATE,
    phone_number VARCHAR(20),
    email_address VARCHAR(100),
    expertise TEXT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE projects (
    project_id INT AUTO_INCREMENT PRIMARY KEY,
    project_name VARCHAR(50),
    type_of_crochet TEXT,
    crocheter_id INT,
    created_by INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key with ON DELETE CASCADE for automatic deletion
    FOREIGN KEY (created_by) REFERENCES crocheters(crocheter_id) ON DELETE CASCADE,
    FOREIGN KEY (crocheter_id) REFERENCES crocheters(crocheter_id) ON DELETE CASCADE
);


-- Insert crocheters with hashed passwords
INSERT INTO crocheters (username, password, first_name, last_name, date_of_birth, phone_number, email_address, expertise)
VALUES 
('alice', '$2y$10$C6UzMDM.H6dfI/f/IKqxU.uy8F9yN1Z5Z9AIX2a/dfVQcFgGs7yWy', 'Alice', 'Smith', '1985-06-15', '123-456-7890', 'alice@example.com', 'Beginner'),
('bob', '$2y$10$7q5/MNqN1qx.uVHFIPf9qOZGVWjdK/6C6UKd6xVUmSc4JWjBeoBPC', 'Bob', 'Johnson', '1990-11-20', '234-567-8901', 'bob@example.com', 'Intermediate'),
('charlie', '$2y$10$1dVI9A/NbQWyiyTFn4ICn.ZEG/XA7LC7ZKHsFcTC0JULG0v5yZLgy', 'Charlie', 'Lee', '1978-03-30', '345-678-9012', 'charlie@example.com', 'Advanced');

-- Insert example data into projects
INSERT INTO projects (project_name, type_of_crochet, crocheter_id, created_by)
VALUES
('Lace Doily', 'Lace Crochet', 1, 1),       -- Created and last updated by Alice
('Stuffed Animal', 'Amigurumi', 2, 2),      -- Created and last updated by Bob
('Tunisian Blanket', 'Tunisian Crochet', 3, 3), -- Created by Cathy, last updated by Alice
('Granny Square Scarf', 'Granny Square', 1, 1); -- Created by Alice, last updated by Bob
