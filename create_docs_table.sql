CREATE TABLE Docs (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    comment VARCHAR(100),
    status ENUM('discussion', 'insight', 'draft', 'archive') NOT NULL,
    role ENUM('admin', 'superior', 'employee', 'client') NOT NULL,
    filename VARCHAR(100) NOT NULL,
    guid VARCHAR(40) NOT NULL,
    created_at TIMESTAMP NOT NULL,
    updated_at TIMESTAMP NOT NULL
);

CREATE TABLE Users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    role ENUM('admin', 'superior', 'employee', 'client') NOT NULL,
    hashed_pass VARCHAR(100) NOT NULL
);
