<?php
/**
 * Database Initialization Script
 * Creates all necessary tables for the Library Management System.
 */

function initializeDatabase($db) {
    $tables = [
        "admin" => "CREATE TABLE IF NOT EXISTS `admin` (
            `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
            `nom` VARCHAR(100),
            `prenom` VARCHAR(100),
            `username` VARCHAR(50) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `email` VARCHAR(100),
            `image` VARCHAR(255) DEFAULT 'default.jpg'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "lecteurs" => "CREATE TABLE IF NOT EXISTS `lecteurs` (
            `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
            `first` VARCHAR(100),
            `last` VARCHAR(100),
            `username` VARCHAR(50) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `roll` VARCHAR(50),
            `email` VARCHAR(100),
            `image` VARCHAR(255) DEFAULT 'default.jpg'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "livres" => "CREATE TABLE IF NOT EXISTS `livres` (
            `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
            `titre` VARCHAR(255) NOT NULL,
            `auteur` VARCHAR(255),
            `description` TEXT,
            `maison_edition` VARCHAR(255),
            `nombre_exemplair` INT(11),
            `image_url` VARCHAR(255)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "demande_livre" => "CREATE TABLE IF NOT EXISTS `demande_livre` (
            `id` INT(11),
            `username` VARCHAR(50),
            `aprouver` VARCHAR(20) DEFAULT '',
            `demande` DATE,
            `retour` DATE,
            PRIMARY KEY (`id`, `username`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "liste_lecture" => "CREATE TABLE IF NOT EXISTS `liste_lecture` (
            `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
            `username` VARCHAR(50),
            `livre_id` INT(11),
            `date_ajout` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY `unique_user_book` (`username`, `livre_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "comments" => "CREATE TABLE IF NOT EXISTS `comments` (
            `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
            `username` VARCHAR(50),
            `comment` TEXT
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "fine" => "CREATE TABLE IF NOT EXISTS `fine` (
            `username` VARCHAR(50),
            `id` INT(11),
            `returned` DATE,
            `days` INT(11),
            `fine` DECIMAL(10,2),
            `status` VARCHAR(20) DEFAULT 'not paid',
            PRIMARY KEY (`username`, `id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    ];

    foreach ($tables as $tableName => $sql) {
        if (!mysqli_query($db, $sql)) {
            error_log("Error creating table $tableName: " . mysqli_error($db));
        }
    }

    // Fix for missing columns in 'lecteurs' table (Prevent "Unknown column 'first'" error)
    $checkLecteurs = mysqli_query($db, "DESCRIBE `lecteurs` ");
    $columns = [];
    while($row = mysqli_fetch_assoc($checkLecteurs)) {
        $columns[] = $row['Field'];
    }

    if (!in_array('first', $columns)) {
        mysqli_query($db, "ALTER TABLE `lecteurs` ADD COLUMN `first` VARCHAR(100) AFTER `id` ");
    }
    if (!in_array('last', $columns)) {
        mysqli_query($db, "ALTER TABLE `lecteurs` ADD COLUMN `last` VARCHAR(100) AFTER `first` ");
    }
    if (!in_array('roll', $columns)) {
        mysqli_query($db, "ALTER TABLE `lecteurs` ADD COLUMN `roll` VARCHAR(50) AFTER `password` ");
    }
}
?>
