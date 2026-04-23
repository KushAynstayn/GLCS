CREATE TABLE imports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255),
    file_path TEXT,
    uploaded_by INT,
    total_rows INT DEFAULT 0,
    inserted_rows INT DEFAULT 0,
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);