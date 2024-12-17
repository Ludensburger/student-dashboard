# Student Dashboard

## Setup

This project uses Composer to manage dependencies. Follow the steps below to set up the project and install the necessary tools for code quality checks.

### Prerequisites

- PHP (>= 7.4)
- Composer

### Installation

1. Clone the repository:

    ```sh
    git clone https://github.com/yourusername/student-dashboard.git
    cd student-dashboard
    ```

2. Install the dependencies:

    ```sh
    composer install
    ```

### Code Quality Tools

This project uses PHP_CodeSniffer (phpcs) and PHP Code Beautifier and Fixer (phpcbf) to ensure code quality and adherence to coding standards.

#### PHP_CodeSniffer

PHP_CodeSniffer is a tool that helps detect violations of coding standards in your PHP code.

#### PHP Code Beautifier and Fixer

PHP Code Beautifier and Fixer automatically fixes coding standard violations in your PHP code.

### Usage

#### Linting

To check for coding standard violations, run:

```sh
composer lint