# World of Mirrors CMS <a name="readme-top"></a>

A CRUD-based Content Management System (CMS) for the World of Mirrors website.

## Description

This CMS generates a website allowing users to create, read, update and delete content from a central source.
The content includes:
* The category or type of product (mirror).
* The product and its description.
* User comments about the mirror.

#### Database Structure

![ERD](https://github.com/bold-italic/world-of-mirrors-CMS/assets/101299696/0569da8f-c84b-4242-a6f9-2b17282588b8)

Tables description:

* The products table contains parameters of a product (mirror). Each product can have user comments. This table has a one-to-many association with the comments table.
* The categories table contains product categories (types of mirrors). Products are grouped into categories. This table has a one-to-many association with the product table.
* The comments table contents customer comments.

#### Unauthenticated User Stories (Customer)

A non-authenticated user is able to:

* Navigate the product pages of the system by way of a menu.
* Access all pages within a particular category.
* Post comments on specific pages.
* Search for specific pages by keyword using a search form.

#### Authenticated User Stories (Administrator)

An administrator has the rights of a customer plus the following abilities:

* Create, edit and delete the data associated with a product page.
* View a list of product pages sorted by title, by created, or date updated (in reverse chronological order).
* Create and update a list of categories that apply to product pages and assign categories to existing pages.
* View and moderate comments on product pages submitted by customers.
* Add an image to a product page and remove an associated image from a product page.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Demo

Here is a working live demo: https://world-of-mirrors.epizy.com/  
*Login: user / Password: 123*

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Built With

* ![HTML5](https://img.shields.io/badge/-HTML5-E34F26.svg?style=flat&logo=html5&logoColor=white)
* ![CSS3](https://img.shields.io/badge/-CSS3-1572B6.svg?style=flat&logo=css3&logoColor=white)
* ![Bootstrap](https://img.shields.io/badge/-Bootstrap-563D7C.svg?style=flat&logo=bootstrap&logoColor=white)
* ![JavaScript](https://img.shields.io/badge/-JavaScript-323330.svg?style=flat&logo=javascript&logoColor=F7DF1E)
* ![PHP](https://img.shields.io/badge/-PHP-777BB4.svg?style=flat&logo=php&logoColor=white)
* ![MySQL](https://img.shields.io/badge/-MySQL-00000F?style=flat&logo=mysql&logoColor=white)

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Features

* Bootstrap is used to build markup and styling around a CSS framework.
* `TinyMCE` library is utilized as a `WYSIWYG` editor for creating and updating product descriptions.
* Validation is implemented on fields for new / updated products, categories, and comments to ensure that they contain at least one character in length.
* Before executing a `SQL` query, any `id` values passed by the user are validated as integers. To avoid `SQL Injection`, all strings submitted by the user (POSTed fields) are sanitized using input_filter.
* PHP `GD` library automatically resizes uploaded images.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Getting Started

### Prerequisites

* Download and Install [XAMPP](https://www.apachefriends.org/index.html).
* Check whether the GD library has been installed in your PHP installation or not. If GD is not present on the PHPinfo page, you will need to install it.

### Installation

* Download the ZIP or Clone the repository.
* Move the project to the Root Directory. Local Disk C is the location where XAMPP was installed:
  ```sh
  Local Disc C: -> xampp -> htdocs -> 'world-of-mirrors-CMS'
  ```
* Open the XAMPP Control Panel and start `Apache` and `MySQL`.
* Create a MySQL database and configure a MySQL user. From the PHPMyAdmin SQL tab, execute the following commands:
  ```sql
  CREATE DATABASE world_of_mirrors;
  CREATE USER 'cmsuser'@'localhost' IDENTIFIED BY 'my_password';
  GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, ALTER 
    ON world_of_mirrors.* TO 'cmsuser'@'localhost';
  ```
  You can replace `cmsuser` and `my_password` with your preferred username and password. If you make any changes, be sure to also update the `DB_USER` and `DB_PASS` in the `connect.php` file.
* Import the SQL file `world-of-mirrors.sql` into the `world_of_mirrors` database.
* Change the `ADMIN_LOGIN` and `ADMIN_PASSWORD` in the `authenticate.php` file. By default, the login is `user` and the password is `123`.
  ```php
  define('ADMIN_LOGIN','user'); // Your "Authenticated user" username instead of 'user'
  define('ADMIN_PASSWORD','123'); // Your "Authenticated user" password instead of '123'
  ```
* Open the blog in your browser.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## Acknowledgments

* [Gumlet](https://github.com/gumlet)
* [TinyMCE](https://www.tiny.cloud/)

<p align="right">(<a href="#readme-top">back to top</a>)</p>
