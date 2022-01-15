CREATE DATABASE IF NOT EXISTS nix;
CREATE USER IF NOT EXISTS 'osavich'@'localhost' IDENTIFIED BY 'securepass';
GRANT ALL ON nix.* TO 'osavich'@'localhost';

USE nix;

CREATE TABLE IF NOT EXISTS `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(256) NOT NULL,
  `email` VARCHAR(256) NOT NULL,
  `password` VARCHAR(256) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT now(),
  `updated_at` TIMESTAMP NULL DEFAULT now()
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET utf8mb4 COLLATE 'utf8mb4_unicode_ci';

CREATE TABLE IF NOT EXISTS `products` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(256) NOT NULL UNIQUE,
  `price` VARCHAR(256) NOT NULL,
  `status` VARCHAR(256) NOT NULL,
  `amount` BIGINT NOT NULL,
  `photo` VARCHAR(256) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT now(),
  `updated_at` TIMESTAMP NULL DEFAULT now()
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET utf8mb4 COLLATE 'utf8mb4_unicode_ci';

CREATE TABLE IF NOT EXISTS `products_order` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` BIGINT NOT NULL REFERENCES `users`(`id`),
  `product_id` BIGINT NOT NULL REFERENCES `products`(`id`),
  `amount` BIGINT NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT now(),
  `updated_at` TIMESTAMP NULL DEFAULT now()
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARACTER SET utf8mb4 COLLATE 'utf8mb4_unicode_ci';

INSERT INTO products(name,price,status,amount,photo) VALUES ("COSMO XR-120","3000000$","Out of stock",10,"assets/images/blue.jpg");
INSERT INTO products(name,price,status,amount,photo) VALUES ("SPEEDER 9000","13000000$","Avalible",20,"assets/images/red.jpg");
INSERT INTO products(name,price,status,amount,photo) VALUES ("KARKANI 20-X","7000000$","Out of stock",10,"assets/images/green.jpg");
INSERT INTO products(name,price,status,amount,photo) VALUES ("LUNAR XR-PRO","5000000$","Out of stock",10,"assets/images/yellow.jpg");