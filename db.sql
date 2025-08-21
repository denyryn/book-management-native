CREATE TABLE `categories` (
  `id` integer PRIMARY KEY AUTOINCREMENT,
  `name` varchar(255),
  `slug` varchar(255) UNIQUE
);

CREATE TABLE `books` (
  `id` integer PRIMARY KEY AUTOINCREMENT,
  `category_id` integer,
  `author_id` integer,
  `publisher_id` integer,
  `title` varchar(255),
  `publication_date` date,
  `number_of_pages` integer
);

CREATE TABLE `authors` (
  `id` integer PRIMARY KEY AUTOINCREMENT,
  `name` varchar(255)
);

CREATE TABLE `publishers` (
  `id` integer PRIMARY KEY AUTOINCREMENT,
  `name` varchar(255)
);

-- Foreign key constraints
ALTER TABLE `books` ADD FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
ALTER TABLE `books` ADD FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`);
ALTER TABLE `books` ADD FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`id`);

-- Indexes on foreign keys
CREATE INDEX `idx_books_category_id` ON `books` (`category_id`);
CREATE INDEX `idx_books_author_id` ON `books` (`author_id`);
CREATE INDEX `idx_books_publisher_id` ON `books` (`publisher_id`);
