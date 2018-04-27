/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  josue
 * Created: 13-abr-2018
 */

DROP DATABASE IF EXISTS ley_justicia;

CREATE DATABASE IF NOT EXISTS ley_justicia;

USE ley_justicia;

CREATE TABLE users(
id int(255) AUTO_INCREMENT NOT NULL,
role VARCHAR(20),
name VARCHAR(80),
email VARCHAR(45),
password VARCHAR(255),
image VARCHAR(255),
biography TEXT,
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE categories(
id int(255) AUTO_INCREMENT NOT NULL,
name VARCHAR(255),
description TEXT,
CONSTRAINT pk_categories PRIMARY KEY(id)
)ENGINE=InnoDb;


CREATE TABLE entries(
id int(255) AUTO_INCREMENT NOT NULL,
user_id int(255) NOT NULL,
category_id int(255) NOT NULL,
title VARCHAR(255),
content TEXT,
status VARCHAR(20),
image VARCHAR(255),
CONSTRAINT pk_entries PRIMARY KEY(id),
CONSTRAINT fk_entries_users FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_entries_categories FOREIGN KEY(category_id) REFERENCES categories(id)
)ENGINE=InnoDb;


CREATE TABLE tags(
id int(255) AUTO_INCREMENT NOT NULL,
name VARCHAR(255),
description TEXT,
CONSTRAINT pk_tags PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE entry_tag(
id int(255) AUTO_INCREMENT NOT NULL,
entry_id int(255) NOT NULL,
tag_id int(255) NOT NULL,
CONSTRAINT pk_entry_tag PRIMARY KEY(id),
CONSTRAINT fk_entry_tag_entries FOREIGN KEY(entry_id) REFERENCES entries(id),
CONSTRAINT fk_entry_tag_tags FOREIGN KEY(tag_id) REFERENCES tags(id)
)ENGINE=InnoDb;



