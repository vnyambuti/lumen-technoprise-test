Task Management API

This is a simple RESTful API built with Lumen that allows users to manage tasks. The API handles basic CRUD (Create, Read, Update, Delete) operations for tasks.

Features

Create new tasks

Retrieve a list of tasks (with filtering, sorting, and pagination)

Retrieve a single task by ID

Update existing tasks

Delete tasks

Search tasks by title

Requirements

PHP >= 7.3

Composer

MySQL or another database supported by Laravel/Lumen

Installation

Clone the repository:

Copygit clone https://github.com/yourusername/task-management-api.git

cd task-management-api

Install dependencies:

Copycomposer install

Create a .env file by copying .env.example:

Copycp .env.example .env

Update the .env file with your database credentials and other configuration settings.

Generate an application key:

Copyphp artisan key:generate

Run database migrations:

Copyphp artisan migrate

Start the development server:

Copyphp -S localhost:8000 -t public

API Endpoints

Get all tasks

GET /api/tasks

Query Parameters:

search: Search tasks by title

status: Filter by status (e.g., 'pending', 'completed')

due\_date: Filter by due date ('overdue', 'today', 'this\_week', 'next\_week')

sort\_by: Sort by field (currently supports 'due\_date')

sort\_direction: Sort direction ('asc' or 'desc')

page: Page number for pagination

per\_page: Number of items per page (default: 15)

Get a specific task

GET /api/tasks/{id}

Create a new task

POST /api/tasks

Body:

jsonCopy{

"title": "Task title",

"description": "Task description",

"status": "pending",

"due\_date": "2023-12-31"

}

Update a task

PUT /api/tasks/{id}

Body: Same as create, with fields you want to update

Delete a task

DELETE /api/tasks/{id}

Error Handling

The API uses standard HTTP response codes to indicate the success or failure of requests. In case of errors, a JSON response with an error message will be returned.

Testing

To run the test suite, use the following command:

Copy./vendor/bin/phpunit

Contributing

Please read CONTRIBUTING.md for details on our code of conduct, and the process for submitting pull requests.

License

This project is licensed under the MIT License - see the LICENSE.md file for details.