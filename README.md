# Student Dashboard

This is a simple static website that uses SCSS for styling. Node.js is only required during development for SCSS compilation - the final website runs without any Node.js dependencies.   

## Project Setup

Follow these steps to set up the project:

### 1. Clone the Repository

Clone the repository to your local machine:

```sh
git clone https://github.com/your-username/student-dashboard.git
cd student-dashboard
```

### 2. Install Dependencies

Make sure you have Node.js and npm installed. Run the following command to install the necessary dependencies:


```sh
npm install
```

### 3. Set Up Apache Document Root

This is a standard static website - simply point your Apache document root to the student-dashboard directory. No special configuration is required.

## Build / Watch
Compiling SCSS
To compile SCSS files, run the following command:

```sh
npm run build
```

To watch for changes and automatically recompile SCSS files, run:

```sh
npm run watch
```