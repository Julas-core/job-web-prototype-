-- Users table (Login info)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Job Seeker Profile
CREATE TABLE job_seeker (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    fullname VARCHAR(255),
    profession_title VARCHAR(255),
    skill_level VARCHAR(50),
    city VARCHAR(100),
    primary_interest VARCHAR(255),
    bio TEXT,
    portofilio_link TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Company Profile
CREATE TABLE company (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    company_name VARCHAR(255),
    contact_name VARCHAR(255),
    description TEXT,
    representative VARCHAR(100),
    location VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Jobs table
CREATE TABLE jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT,
    title VARCHAR(255),
    description TEXT,
    location VARCHAR(255),
    type VARCHAR(100),
    requirements TEXT,
    salary VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE
);

-- Applications table
CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_id INT NOT NULL,
    user_id INT NULL,
    seeker_id INT NULL,
    fullname VARCHAR(255),
    skill_level VARCHAR(100),
    expected_salary VARCHAR(100),
    resumee VARCHAR(500),
    cover TEXT,
    telegram VARCHAR(255),
    portfolio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (seeker_id) REFERENCES job_seeker(id) ON DELETE SET NULL
);