<?php

require 'db.php';

if (!isset($k->query("select 1 from president;")->num_rows)) {
  $k->query("CREATE TABLE president (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(45) NOT NULL,
        email VARCHAR(45) NOT NULL,
        password TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE INDEX email_UNIQUE (email ASC) VISIBLE);");
  $name = "kodo yousif";
  $pass = md5("kodokodo");
  $email = "kodo.00257248@gmail.com";
  $k->query("INSERT INTO president (name, password, email )
    VALUES ( '$name' , '$pass', '$email')");
}

if (!isset($k->query("select 1 from minister;")->num_rows)) {
  $k->query("CREATE TABLE minister (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(45) NOT NULL,
        email VARCHAR(45) NOT NULL,
        password TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE INDEX email_UNIQUE (email ASC) VISIBLE );");
}

if (!isset($k->query("select 1 from zone;")->num_rows)) {
  $k->query("CREATE TABLE zone (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(45) NOT NULL,
        PRIMARY KEY (id),
        UNIQUE INDEX name_UNIQUE (name ASC) VISIBLE );");
}

if (!isset($k->query("select 1 from ministry;")->num_rows)) {
  $k->query("CREATE TABLE `$db`.`ministry` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `bank` DECIMAL(20,0) NULL,
        `minister_id` INT NULL,
        `name` VARCHAR(45) NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        INDEX `mm_id_idx` (`minister_id` ASC) VISIBLE,
        UNIQUE INDEX name_UNIQUE (name ASC) VISIBLE,
        CONSTRAINT `mm_id`
          FOREIGN KEY (`minister_id`)
          REFERENCES `$db`.`minister` (`id`)
          ON DELETE cascade
          ON UPDATE CASCADE);");
}

if (!isset($k->query("select 1 from jobs;")->num_rows)) {
  $k->query("CREATE TABLE `$db`.jobs (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(45) NULL,
        ministry_id INT NOT NULL,
        start_salary DECIMAL(20,0) NOT NULL,        
        bones DECIMAL(20,0) NULL,        
        per_kid DECIMAL(20,0) NULL,        
        per_month DECIMAL(20,0) NULL,        
        married_bones DECIMAL(20,0) NULL,
        per_level DECIMAL(20,0) NULL,
        outside_zone DECIMAL(20,0) NULL,   
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        CONSTRAINT m_id
            FOREIGN KEY (ministry_id)
            REFERENCES `$db`.ministry (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE );");
}
if (!isset($k->query("select 1 from building;")->num_rows)) {
  $k->query("CREATE TABLE building (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `ministry_id` INT NULL,
    `zone_id` INT NULL,
    `bank` DECIMAL(20,2) NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    INDEX `bm_id_idx` (`ministry_id` ASC) VISIBLE,
    INDEX `bz_id_idx` (`zone_id` ASC) VISIBLE,
    CONSTRAINT `bm_id`
      FOREIGN KEY (`ministry_id`)
      REFERENCES `$db`.`ministry` (`id`)
      ON DELETE CASCADE
      ON UPDATE NO ACTION,
    CONSTRAINT `bz_id`
      FOREIGN KEY (`zone_id`)
      REFERENCES `$db`.`zone` (`id`)
      ON DELETE CASCADE
      ON UPDATE NO ACTION);");
}

if (!isset($k->query("select 1 from employees;")->num_rows)) {
  $k->query("CREATE TABLE `employees` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(45) NOT NULL,
        `email` VARCHAR(45) NOT NULL,
        `password` TEXT NOT NULL,
        `married` ENUM('yes', 'no') NOT NULL,
        `gender` ENUM('male', 'female') NOT NULL,
        `job_id` INT NULL,
        `kids` INT ,
        `bones` INT DEFAULT 0,
        `created_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `building_id` INT NULL,
        `zone_id` INT NULL,
        `bank` INT NULL DEFAULT 0,
        `level` ENUM('1', '2') NOT NULL,
        PRIMARY KEY (`id`),
        INDEX `ej_id_idx` (`job_id` ASC) VISIBLE,
        INDEX `eb_id_idx` (`building_id` ASC) VISIBLE,
        INDEX `ez_id_idx` (`zone_id` ASC) VISIBLE,
        CONSTRAINT `ej_id`
          FOREIGN KEY (`job_id`)
          REFERENCES `$db`.`jobs` (`id`)
          ON DELETE cascade
          ON UPDATE cascade,
        CONSTRAINT `eb_id`
          FOREIGN KEY (`building_id`)
          REFERENCES `$db`.`building` (`id`)
          ON DELETE cascade
          ON UPDATE cascade,
        CONSTRAINT `ez_id`
          FOREIGN KEY (`zone_id`)
          REFERENCES `$db`.`zone` (`id`)
          ON DELETE cascade
          ON UPDATE cascade);
      ");
}

require 'end.php';
