# 🚀 WildCloud

WildCloud is a modernized personal CRUD platform. 
Built on PHP 8.5 and Docker, it features a clean MVC architecture, the Twig templating engine, and a professional internationalization system based on gettext.

## 🛠️ Architecture

- Core: Manages the Database connection, View Wrapper (Twig), and Response handling.
- Services: Contains business logic (Authentication, File Management).
- Controllers: Handles incoming requests and orchestrates the UI response.
- I18n: Native multi-language support via .po and .mo files.

## 🏗️ Setup and Installation

Clone the repository and navigate to the project root.

Start the Docker environment:

    ./bin/docker-compose up -d --build

Install Composer dependencies:

    ./bin/cli composer install

## ⌨️ CLI Commands (Helper Scripts)

Common operations are automated through scripts located in the bin/ directory.
System Management

Enter Container (Bash): 
    
    ./bin/shell

Run command as standard user: 
    
    ./bin/cli [command] (e.g., ./bin/cli php -v)

Run command as root: 
    
    ./bin/root [command]

### Translation Management (I18n)

Every time you modify a .po file, you must compile the binary for changes to take effect:
Bash

    ./bin/makelangs

### Database Management

To import the initial schema or updates:

    ./bin/root mysql -u root -p[password] [database_name] < schema.sql

## 🌍 Internationalization (Gettext)

The project uses standard .po files located in:

    translations/[locale]/LC_MESSAGES/messages.po

How to add a new language:

- Create the directory (e.g., translations/fr_FR/LC_MESSAGES/).
- Copy the messages.po file from the en_US folder.
- Translate the strings (using Poedit is highly recommended).
- Run 
      
       ./bin/makelangs.

## 📂 Directory Structure

bin/: Utility scripts for the Docker environment.

public/: Web server root (index.php, assets).

src/: Source code (Controllers, Services, Core logic).

translations/: Source and compiled language files.

views/: Twig templates (Matryoshka inheritance system).

## 📝 Development Notes

Debug Mode: Can be toggled in the View class constructor within index.php.

Twig Filters: Custom filters (like format_bytes) are registered globally in the WildCloud\Core\View class.