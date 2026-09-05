
-- Doctors Table
CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    signature VARCHAR(255),
    stamp VARCHAR(255)
);

-- Test Parameters Table
CREATE TABLE test_parameters (
    parameter_id INT AUTO_INCREMENT PRIMARY KEY,
    param_name VARCHAR(255),
    category_id INT,
    group_id INT,
    unit VARCHAR(50),
    method TEXT,
    interpretation TEXT,
    notes TEXT
);

-- Parameter Reference Range Table
CREATE TABLE parameter_reference_range (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parameter_id INT,
    gender ENUM('male', 'female', 'child'),
    min_value FLOAT,
    max_value FLOAT
);

-- Test Results Table
CREATE TABLE test_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    test_id INT,
    parameter_id INT,
    result_value VARCHAR(255)
);

-- Parameter Groups Table
CREATE TABLE parameter_groups (
    group_id INT AUTO_INCREMENT PRIMARY KEY,
    group_name VARCHAR(255)
);

-- Test Parameter Mapping
CREATE TABLE test_parameter_map (
    id INT AUTO_INCREMENT PRIMARY KEY,
    test_id INT,
    parameter_id INT
);

-- Templates Table
CREATE TABLE templates (
    template_id INT AUTO_INCREMENT PRIMARY KEY,
    test_name VARCHAR(255),
    html_content TEXT
);
