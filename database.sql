CREATE DATABASE IF NOT EXISTS task_tracker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE task_tracker;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('manager','team_leader','team_member','client') NOT NULL DEFAULT 'team_member',
  role_label VARCHAR(80) NOT NULL,
  field_name VARCHAR(190) NULL,
  client_scope VARCHAR(500) NULL,
  phone VARCHAR(40) NULL,
  whatsapp_no VARCHAR(40) NULL,
  status ENUM('Active','On Leave','Inactive') NOT NULL DEFAULT 'Active',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS clients (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  company_name VARCHAR(190) NOT NULL,
  name VARCHAR(150) NOT NULL,
  contact_person VARCHAR(150) NULL,
  email VARCHAR(190) NULL,
  phone VARCHAR(40) NULL,
  whatsapp_no VARCHAR(40) NULL,
  website VARCHAR(500) NULL,
  work_model VARCHAR(100) NULL,
  status ENUM('Active','On Hold','Inactive') NOT NULL DEFAULT 'Active',
  platforms VARCHAR(500) NULL,
  monthly_deliverables TEXT NULL,
  owner VARCHAR(150) NULL,
  notes TEXT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_clients_status(status)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS client_members (
  client_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  assignment_type VARCHAR(80) NOT NULL DEFAULT 'Owner',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(client_id,user_id),
  FOREIGN KEY(client_id) REFERENCES clients(id) ON DELETE CASCADE,
  FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tasks (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  client_id INT UNSIGNED NULL,
  assigned_user_id INT UNSIGNED NULL,
  created_by INT UNSIGNED NULL,
  title VARCHAR(255) NOT NULL,
  platform VARCHAR(80) NULL,
  content_type VARCHAR(80) NULL,
  task_type VARCHAR(80) NULL,
  publish_at DATETIME NULL,
  due_date DATE NULL,
  status VARCHAR(60) NOT NULL DEFAULT 'Planned',
  approval_chain TEXT NULL,
  notes TEXT NULL,
  work_url VARCHAR(1000) NULL,
  proof_url VARCHAR(1000) NULL,
  attachment_link VARCHAR(1000) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_tasks_client(client_id), INDEX idx_tasks_assigned(assigned_user_id), INDEX idx_tasks_due(due_date), INDEX idx_tasks_publish(publish_at), INDEX idx_tasks_status(status),
  FOREIGN KEY(client_id) REFERENCES clients(id) ON DELETE SET NULL,
  FOREIGN KEY(assigned_user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS task_attachments (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  task_id BIGINT UNSIGNED NOT NULL,
  original_name VARCHAR(255) NOT NULL,
  stored_path VARCHAR(1000) NOT NULL,
  mime_type VARCHAR(150) NULL,
  file_size BIGINT UNSIGNED NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY(task_id) REFERENCES tasks(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS approvals (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  task_id BIGINT UNSIGNED NULL,
  client_id INT UNSIGNED NULL,
  item VARCHAR(255) NOT NULL,
  creator_user_id INT UNSIGNED NULL,
  approval_chain TEXT NULL,
  approval_rule VARCHAR(255) NULL,
  current_step VARCHAR(100) NOT NULL DEFAULT 'Pending',
  status ENUM('Pending','Approved','Revision','Rejected') NOT NULL DEFAULT 'Pending',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY(task_id) REFERENCES tasks(id) ON DELETE SET NULL,
  FOREIGN KEY(client_id) REFERENCES clients(id) ON DELETE SET NULL,
  FOREIGN KEY(creator_user_id) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_approvals_client(client_id), INDEX idx_approvals_status(status)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS approval_actions (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  approval_id BIGINT UNSIGNED NOT NULL,
  actor_user_id INT UNSIGNED NULL,
  action ENUM('Approved','Revision','Rejected') NOT NULL,
  comment TEXT NULL,
  acted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY(approval_id) REFERENCES approvals(id) ON DELETE CASCADE,
  FOREIGN KEY(actor_user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS calendar_events (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  task_id BIGINT UNSIGNED NULL,
  client_id INT UNSIGNED NULL,
  assigned_user_id INT UNSIGNED NULL,
  event_date DATE NOT NULL,
  event_time TIME NULL,
  title VARCHAR(255) NOT NULL,
  platform VARCHAR(80) NULL,
  content_type VARCHAR(80) NULL,
  approval_chain TEXT NULL,
  status VARCHAR(60) NOT NULL DEFAULT 'Scheduled',
  work_url VARCHAR(1000) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY(task_id) REFERENCES tasks(id) ON DELETE SET NULL,
  FOREIGN KEY(client_id) REFERENCES clients(id) ON DELETE SET NULL,
  FOREIGN KEY(assigned_user_id) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_calendar_date(event_date), INDEX idx_calendar_client(client_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS bulk_imports (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  client_id INT UNSIGNED NULL,
  month_key CHAR(7) NOT NULL,
  filename VARCHAR(255) NOT NULL,
  notes TEXT NULL,
  imported_rows INT UNSIGNED NOT NULL DEFAULT 0,
  created_by INT UNSIGNED NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY(client_id) REFERENCES clients(id) ON DELETE SET NULL,
  FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS attendance (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  attendance_date DATE NOT NULL,
  punch_in DATETIME NULL,
  punch_out DATETIME NULL,
  status ENUM('Present','Late','On Leave','Absent') NOT NULL DEFAULT 'Present',
  notes TEXT NULL,
  UNIQUE KEY uq_attendance_user_date(user_id,attendance_date),
  FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_attendance_date(attendance_date)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS leaves (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  leave_date DATE NOT NULL,
  leave_type VARCHAR(80) NOT NULL,
  reason TEXT NULL,
  status ENUM('Pending','Approved','Rejected','Upcoming') NOT NULL DEFAULT 'Upcoming',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS campaigns (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  client_id INT UNSIGNED NULL,
  title VARCHAR(255) NOT NULL,
  platform VARCHAR(80) NOT NULL,
  type VARCHAR(80) NULL,
  start_at DATETIME NULL,
  end_at DATETIME NULL,
  schedule_rule VARCHAR(255) NULL,
  objective TEXT NULL,
  status VARCHAR(60) NOT NULL DEFAULT 'Ready',
  created_by INT UNSIGNED NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY(client_id) REFERENCES clients(id) ON DELETE SET NULL,
  FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_campaigns_client(client_id), INDEX idx_campaigns_start(start_at)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS client_connections (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  client_id INT UNSIGNED NOT NULL,
  platform VARCHAR(100) NOT NULL,
  account_name VARCHAR(255) NOT NULL,
  status VARCHAR(80) NOT NULL DEFAULT 'Not connected',
  connected_on DATE NULL,
  available_actions VARCHAR(500) NULL,
  oauth_provider VARCHAR(100) NULL,
  external_account_id VARCHAR(255) NULL,
  token_ciphertext TEXT NULL,
  token_expires_at DATETIME NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY(client_id) REFERENCES clients(id) ON DELETE CASCADE,
  INDEX idx_connections_client(client_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS client_metrics (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  client_id INT UNSIGNED NOT NULL,
  metric_date DATE NOT NULL,
  views BIGINT UNSIGNED NOT NULL DEFAULT 0,
  leads BIGINT UNSIGNED NOT NULL DEFAULT 0,
  likes BIGINT UNSIGNED NOT NULL DEFAULT 0,
  followers BIGINT UNSIGNED NOT NULL DEFAULT 0,
  engagement_rate DECIMAL(8,2) NULL,
  notes TEXT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_metric_client_date(client_id,metric_date),
  FOREIGN KEY(client_id) REFERENCES clients(id) ON DELETE CASCADE,
  INDEX idx_metrics_client_date(client_id,metric_date)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS meetings (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  client_id INT UNSIGNED NULL,
  meeting_date DATE NOT NULL,
  meeting_time TIME NOT NULL,
  title VARCHAR(255) NOT NULL,
  participants TEXT NULL,
  agenda TEXT NULL,
  notes TEXT NULL,
  followups TEXT NULL,
  status VARCHAR(60) NOT NULL DEFAULT 'Scheduled',
  created_by INT UNSIGNED NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY(client_id) REFERENCES clients(id) ON DELETE SET NULL,
  FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_meetings_date(meeting_date), INDEX idx_meetings_client(client_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS notifications (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NULL,
  title VARCHAR(255) NOT NULL,
  message TEXT NULL,
  source VARCHAR(100) NULL,
  is_read TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_notifications_user(user_id,is_read)
) ENGINE=InnoDB;
