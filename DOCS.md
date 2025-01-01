# Project Overview: Student Dashboard

## Introduction

The Student Dashboard is a web application designed to manage and display information about colleges and departments. It uses PHP for server-side processing, JavaScript for client-side interactivity, and SCSS for styling. Node.js is used during development for SCSS compilation.

## Framework and Structure

### PHP

- **Purpose**: PHP handles server-side scripting to process requests, interact with the database, and render HTML content.
- **Structure**: The project follows a modular structure, with different functionalities separated into different files. For example, `colleges.php` handles the display and CRUD operations for colleges.

### JavaScript

- **Purpose**: JavaScript manages client-side interactivity, such as handling form submissions, making AJAX requests, and dynamically updating the DOM.
- **Structure**: JavaScript files are organized in the `js` directory. Each major feature has its own JavaScript file, such as `colleges.js` for managing colleges.

### SCSS

- **Purpose**: SCSS is used for styling the application, offering maintainable and scalable CSS through features like variables, nesting, and mixins.
- **Structure**: SCSS files are compiled into CSS using Node.js during development. The compiled CSS is then included in the HTML.

### Node.js

- **Purpose**: Node.js is used during development to compile SCSS files into CSS. It is not required for the final deployment of the application.
- **Structure**: The project includes a `package.json` file that lists the development dependencies and scripts for building and watching SCSS files.

## Project Setup

### Clone the Repository

```sh
git clone https://github.com/Ludensburger/student-dashboard
```

### Install Dependencies

Ensure Node.js and npm are installed, then run:

```sh
npm install
```

### Set Up Apache Document Root

Point your Apache document root to the `student-dashboard` directory.

### Database Setup

1. Create a MySQL database named `usjr-jsp1b03`.
2. Import the SQL schema from `db1.sql`.

### Run the Application

Open your browser and navigate to `http://localhost/student-dashboard/`.

## Key Features

### CRUD Operations for Colleges

- **Add College**: A modal form allows users to add new colleges.
- **Edit College**: Users can edit existing colleges through a modal form.
- **Delete College**: Users can delete colleges with a confirmation prompt.

### CRUD Operations for Departments

Similar to colleges, users can add, edit, and delete departments.

### User Authentication

Certain actions, like adding or editing colleges, are restricted to authenticated users.

## Why This Framework and Structure?

### Modularity

Separating different functionalities into different files makes the codebase more maintainable and easier to understand.

### Scalability

Using SCSS for styling and Node.js for development tasks allows the project to scale more easily as new features are added.

### Interactivity

JavaScript enhances the user experience by providing dynamic interactivity without requiring full page reloads.

### Security

PHP handles server-side processing and database interactions, ensuring that sensitive operations are performed securely.

## Conclusion

This project demonstrates a well-structured approach to building a web application with a clear separation of concerns. By using PHP, JavaScript, SCSS, and Node.js, the project leverages the strengths of each technology to create a robust and interactive application.

By presenting your project in this manner, you provide a comprehensive overview of the technologies used, the structure of the project, and the rationale behind your choices. This will help your professor understand the thought process and effort that went into building the application.
