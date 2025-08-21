CREATE TABLE `categories` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255),
  `slug` VARCHAR(255) UNIQUE
);

CREATE TABLE `authors` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255)
);

CREATE TABLE `publishers` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255)
);

CREATE TABLE `books` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `category_id` INT,
  `author_id` INT,
  `publisher_id` INT,
  `title` VARCHAR(255),
  `publication_date` DATE,
  `number_of_pages` INT,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`),
  FOREIGN KEY (`author_id`) REFERENCES `authors`(`id`),
  FOREIGN KEY (`publisher_id`) REFERENCES `publishers`(`id`)
);

-- Indexes on foreign keys (optional, MySQL automatically indexes FKs, but explicit is fine)
CREATE INDEX `idx_books_category_id` ON `books` (`category_id`);
CREATE INDEX `idx_books_author_id` ON `books` (`author_id`);
CREATE INDEX `idx_books_publisher_id` ON `books` (`publisher_id`);
