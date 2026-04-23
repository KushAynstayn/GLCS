CREATE TABLE import_errors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    import_id INT,
    row_num INT,
    error_message TEXT,
    raw_data TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);