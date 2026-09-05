
CREATE TABLE IF NOT EXISTS parameter_groups (
    group_id INT AUTO_INCREMENT PRIMARY KEY,
    group_name VARCHAR(100),
    display_order INT
);

CREATE TABLE IF NOT EXISTS test_parameters (
    parameter_id INT AUTO_INCREMENT PRIMARY KEY,
    param_name VARCHAR(100),
    category_id INT,
    group_id INT,
    unit VARCHAR(20),
    method VARCHAR(255),
    interpretation TEXT,
    notes TEXT
);

CREATE TABLE IF NOT EXISTS parameter_reference_range (
    range_id INT AUTO_INCREMENT PRIMARY KEY,
    parameter_id INT,
    gender ENUM('Male','Female','Child'),
    min_value FLOAT,
    max_value FLOAT
);

CREATE TABLE IF NOT EXISTS doctors (
    doctor_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    designation VARCHAR(100),
    signature_path VARCHAR(255),
    stamp_path VARCHAR(255)
);

-- Sample insert for group
INSERT INTO parameter_groups (group_name, display_order) VALUES
('Liver Enzymes', 1),
('Proteins', 2);
