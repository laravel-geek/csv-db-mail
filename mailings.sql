CREATE TABLE mailings (
                          id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                          name VARCHAR(255) NOT NULL,
                          text TEXT NOT NULL,
                          user_id INT NOT NULL,
                          sent BOOLEAN NOT NULL DEFAULT 0,
                          FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;