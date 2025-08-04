-- ===============================================
-- Agent Referral System Database Schema
-- Tech Stack: React + Node.js + MySQL/PostgreSQL
-- ===============================================

-- Users table สำหรับ Authentication
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'agent', 'manager') DEFAULT 'agent',
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Agents table สำหรับข้อมูลเอเจนต์
CREATE TABLE agents (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    agent_code VARCHAR(20) UNIQUE NOT NULL,
    id_card VARCHAR(13) UNIQUE NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    phone VARCHAR(15),
    address TEXT,
    registration_date DATE NOT NULL,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Projects table สำหรับโครงการ
CREATE TABLE projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    project_code VARCHAR(20) UNIQUE NOT NULL,
    project_name VARCHAR(100) NOT NULL,
    project_type ENUM('condo', 'house', 'townhome', 'commercial') NOT NULL,
    location VARCHAR(255),
    price_range_min DECIMAL(15,2),
    price_range_max DECIMAL(15,2),
    sales_team VARCHAR(50),
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Customers table สำหรับข้อมูลลูกค้า
CREATE TABLE customers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    agent_id INT NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    phone VARCHAR(15),
    id_card VARCHAR(13),
    email VARCHAR(100),
    project_id INT,
    budget_min DECIMAL(15,2),
    budget_max DECIMAL(15,2),
    status ENUM('new', 'contacted', 'interested', 'visit_scheduled', 'visited', 'negotiating', 'closed_won', 'closed_lost') DEFAULT 'new',
    source ENUM('referral', 'walk_in', 'online', 'phone', 'other') DEFAULT 'referral',
    notes TEXT,
    is_duplicate BOOLEAN DEFAULT false,
    duplicate_customer_id INT,
    sena_approved BOOLEAN DEFAULT false,
    approved_by INT,
    approved_at TIMESTAMP NULL,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (agent_id) REFERENCES agents(id),
    FOREIGN KEY (project_id) REFERENCES projects(id),
    FOREIGN KEY (duplicate_customer_id) REFERENCES customers(id),
    FOREIGN KEY (approved_by) REFERENCES users(id),
    FOREIGN KEY (created_by) REFERENCES users(id),
    FOREIGN KEY (updated_by) REFERENCES users(id)
);

-- Visits table สำหรับข้อมูลการนัดหมายชมโครงการ
CREATE TABLE visits (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    visit_date DATE NOT NULL,
    visit_time TIME,
    status ENUM('scheduled', 'completed', 'cancelled', 'no_show') DEFAULT 'scheduled',
    notes TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id),
    FOREIGN KEY (updated_by) REFERENCES users(id)
);

-- Sales table สำหรับข้อมูลการขาย
CREATE TABLE sales (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    unit_number VARCHAR(20),
    sale_price DECIMAL(15,2) NOT NULL,
    commission_rate DECIMAL(5,2) DEFAULT 3.00,
    commission_amount DECIMAL(15,2),
    contract_date DATE,
    transfer_date DATE,
    status ENUM('reserved', 'contracted', 'transferred', 'cancelled') DEFAULT 'reserved',
    notes TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id),
    FOREIGN KEY (updated_by) REFERENCES users(id)
);

-- Leads table สำหรับข้อมูล Lead ที่ยังไม่ได้เป็นลูกค้า
CREATE TABLE leads (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    phone VARCHAR(15),
    email VARCHAR(100),
    source ENUM('website', 'facebook', 'google', 'referral', 'walk_in', 'other') DEFAULT 'other',
    interest_project_id INT,
    budget_range VARCHAR(50),
    status ENUM('new', 'contacted', 'qualified', 'converted', 'lost') DEFAULT 'new',
    notes TEXT,
    assigned_to INT,
    converted_customer_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (interest_project_id) REFERENCES projects(id),
    FOREIGN KEY (assigned_to) REFERENCES agents(id),
    FOREIGN KEY (converted_customer_id) REFERENCES customers(id)
);

-- Requests table สำหรับคำร้องต่างๆ
CREATE TABLE requests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    request_type ENUM('commission', 'transfer', 'cancellation', 'other') NOT NULL,
    subject VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('pending', 'in_review', 'approved', 'rejected') DEFAULT 'pending',
    approved_by INT,
    approved_at TIMESTAMP NULL,
    rejection_reason TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (approved_by) REFERENCES users(id),
    FOREIGN KEY (created_by) REFERENCES users(id),
    FOREIGN KEY (updated_by) REFERENCES users(id)
);

-- Activity logs table สำหรับ audit trail
CREATE TABLE activity_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    action VARCHAR(50) NOT NULL,
    table_name VARCHAR(50) NOT NULL,
    record_id INT NOT NULL,
    old_values JSON,
    new_values JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- ===============================================
-- Create Indexes for Performance
-- ===============================================
CREATE INDEX idx_agents_agent_code ON agents(agent_code);
CREATE INDEX idx_agents_status ON agents(status);
CREATE INDEX idx_customers_agent_id ON customers(agent_id);
CREATE INDEX idx_customers_project_id ON customers(project_id);
CREATE INDEX idx_customers_status ON customers(status);
CREATE INDEX idx_customers_created_at ON customers(created_at);
CREATE INDEX idx_visits_customer_id ON visits(customer_id);
CREATE INDEX idx_visits_visit_date ON visits(visit_date);
CREATE INDEX idx_sales_customer_id ON sales(customer_id);
CREATE INDEX idx_leads_assigned_to ON leads(assigned_to);
CREATE INDEX idx_leads_status ON leads(status);
CREATE INDEX idx_requests_customer_id ON requests(customer_id);
CREATE INDEX idx_requests_status ON requests(status);
CREATE INDEX idx_activity_logs_user_id ON activity_logs(user_id);
CREATE INDEX idx_activity_logs_table_record ON activity_logs(table_name, record_id);

-- ===============================================
-- Sample Data
-- ===============================================

-- Insert sample users
INSERT INTO users (email, password, role) VALUES 
('admin@sena.co.th', '$2b$10$hashedpassword', 'admin'),
('agent001@sena.co.th', '$2b$10$hashedpassword', 'agent'),
('manager@sena.co.th', '$2b$10$hashedpassword', 'manager');

-- Insert sample projects
INSERT INTO projects (project_code, project_name, project_type, location, price_range_min, price_range_max, sales_team) VALUES
('PROJ001', 'The Reserve Phahol-Pradipat', 'condo', 'Phahol-Pradipat, Bangkok', 3500000.00, 8500000.00, 'Team A'),
('PROJ002', 'Baan Sena Ville', 'house', 'Rangsit, Pathum Thani', 4500000.00, 12000000.00, 'Team B'),
('PROJ003', 'Town Plus Ramkhamhaeng', 'townhome', 'Ramkhamhaeng, Bangkok', 2800000.00, 4200000.00, 'Team C');