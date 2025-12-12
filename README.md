# User and Inventory Management System

This project is a web-based application designed to manage users and inventory. It provides a straightforward user interface for creating, viewing, updating, and deleting records in both a user database and an inventory database.

## Features

-   **User Management:** Secure login and user management with different roles (Admin, User).
-   **Inventory Management:** A comprehensive system for managing inventory items, including details like quantity, origin, and arrival date.
-   **Interactive UI:** Utilizes modals for a smooth user experience when adding, viewing, and updating records.
-   **Clear Project Structure:** Separation of concerns with dedicated files for different functionalities and a separate JavaScript file for client-side interactions.

## Getting Started

### Prerequisites

-   A web server environment like XAMPP, WAMP, or MAMP.
-   MySQL database.

### Setup

1.  Place the project files in your web server's root directory (e.g., `htdocs` for XAMPP).
2.  Create a new MySQL database.
3.  Import the database schema. You can use the following SQL commands to create the `users` and `inventory` tables:
    ```sql
    CREATE TABLE `users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `username` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `role` enum('user','admin') NOT NULL DEFAULT 'user',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    CREATE TABLE `inventory` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `quantity` int(11) NOT NULL,
      `description` text DEFAULT NULL,
      `origin` varchar(255) NOT NULL,
      `date_of_arrival` date NOT NULL,
      `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```
4.  Update `connection.php` with your database credentials (host, username, password, database name).
5.  Access the project through your web browser (e.g., `http://localhost/Final-proj/login.php`).

## Project Structure

This chart illustrates the flow of the application and how the files interact with each other.

```mermaid
graph TD
    subgraph "User Navigation"
        login[login.php] --> main_menu[main_menu.php]
        main_menu --> users_page[index.php - User Mgt]
        main_menu --> inv_page[inventory.php - Inventory Mgt]
        main_menu --> logout[logout.php]
    end

    subgraph "Backend Logic (Hidden)"
        users_page -. POST .-> user_api[User APIs: Insert/Update/Delete]
        inv_page -. POST .-> inv_api[Inventory APIs: Insert/Update/Delete]
        inv_js[JS/AJAX] -. GET .-> inv_get[inventory_get_details.php]
    end
    
    subgraph "Database Layer"
        user_api --> db[(Database)]
        inv_api --> db
        inv_get --> db
    end
    
    inv_page --- inv_js
```

## Database Schema

This diagram shows the structure of the `users` and `inventory` tables.

```mermaid
erDiagram
    users {
        int id PK
        varchar username
        varchar password
        enum role
    }

    inventory {
        int id PK
        varchar name
        int quantity
        text description
        varchar origin
        date date_of_arrival
        timestamp last_updated
    }
```
