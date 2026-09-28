-- Add avatar column to users table
USE tfa3camacho;

ALTER TABLE users ADD COLUMN avatar VARCHAR(255) DEFAULT NULL AFTER full_name;
