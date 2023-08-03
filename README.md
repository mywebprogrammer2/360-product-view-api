# Laravel Boilerplate

This Laravel Boilerplate project provides a solid foundation for building web applications with Laravel. It includes several key features that can accelerate your development process. Some of the notable features are:

- **Laravel 10.7.1 and PHP 8.1.6**: The project is built on the latest versions of Laravel and PHP, ensuring access to the latest features, performance improvements, and security updates.
- **Repository Pattern Implementation**: The project incorporates the `andersao/l5-repository` package, which simplifies the implementation of the Repository pattern. This pattern promotes separation of concerns by providing a layer between the application's data layer and business logic, making it easier to manage and test database operations.
- **Debugging with Laravel Debugbar**: The `barryvdh/laravel-debugbar` package is included to facilitate debugging during development. It provides a toolbar that displays useful information such as query execution times, memory usage, and log messages, helping you identify and resolve issues more efficiently.
- **Easy Installation and Setup**: The installation process is straightforward, thanks to the provided step-by-step instructions. By following the installation guide, you can quickly set up the project on your local machine and get started with development.
- **Database Migrations**: Laravel's built-in database migration feature allows you to manage database schema changes in a convenient and version-controlled manner. The project includes predefined migrations, making it easy to create and modify database tables as your application evolves.
- **Development Server**: Laravel's built-in development server enables you to run your application locally without the need for additional server setup. Simply start the server using the `php artisan serve` command, and your application will be accessible at `http://localhost:8000/`.
- **Environment Configuration**: The project provides an example `.env` file that you can customize to configure your local development environment. You can set environment-specific variables such as database credentials, mail settings, and cache drivers in this file.

## Code Scaffolding

Laravel provides a robust code scaffolding system that allows you to generate boilerplate code for various components of your application. Here are some commonly used artisan commands for code generation:

- `php artisan make:model`: Generates a new Eloquent model class.
- `php artisan make:controller`: Creates a new controller class.
- `php artisan make:middleware`: Generates a new middleware class.
- `php artisan make:migration`: Creates a new database migration file.
- `php artisan make:seeder`: Generates a new database seeder class.
- `php artisan make:factory`: Creates a new model factory class.

You can run these commands from the command line in your project's root directory. The generated code will follow Laravel's best practices and conventions, saving you time and effort when creating common components of your application.

## Installation

Follow the instructions below to set up and run the Laravel Boilerplate project on your local machine:

### Prerequisites

Before starting, make sure you have the following prerequisites installed on your machine:

- PHP 8.1.6
- Composer

### Steps

1. Clone the repository:

```bash
git clone [repository-url]
```

2. Change to the project directory:

```bash
cd laravel-boilerplate
```

3. Install project dependencies using Composer:

```bash
composer install
```

4. Create a copy of the `.env.example` file and rename it to `.env`:

```bash
cp .env.example .env
```

5. Generate an application key:

```bash
php artisan key:generate
```

6. Run the database migrations:

```bash
php artisan migrate
```

7. Start the development server:

```bash
php artisan serve
```

8. Open your web browser and visit the following URL:

```
http://localhost:8000/
```

## Entity Scaffolding

The Laravel Boilerplate project does not have a specific `make:entity` command built-in. However, if you have come across a custom `make:entity` command, it is likely provided by a third-party package or a custom codebase specific to your project.

To generate everything you need for your model, run the command:

```bash
php artisan make:entity Post
```

This command will create the Controller, Validator, Model, Repository, Presenter, and Transformer classes for your `Post` entity. It will also create a new service provider that binds the Eloquent Repository with its corresponding Repository Interface.

To load the service provider, add the following line to your `AppServiceProvider@register` method:

```php
$this->app->register(RepositoryServiceProvider::class);
```

You can also pass options to the `make:entity` command similar to the `make:repository` command, since the `make:entity` command is just a wrapper.

To generate a repository for your `Post` model, use the following command:

```bash
php artisan make:repository Post
```

To generate a repository for your `Post` model within the `Blog` namespace, use the following command:

```bash
php artisan make:repository "Blog\Post"
```

To add fillable fields when generating the repository, use the `--fillable` option:

```bash
php artisan make:repository "Blog\Post" --fillable="title,content"
```

To add validation rules directly with the command, you can use the `--rules` option and create migrations as well:

```bash
php artisan make:entity Cat --fillable="title:string,content:text" --rules="title=>required|min:2, content=>sometimes|min:10"
```

Remember to update your `routes/web.php` file to include the basic CRUD routes:

```php
Route::resource('cats', CatsController::class);
```

## Usage

This Laravel Boilerplate incorporates the Repository pattern provided by the `andersao/l5-repository` package. To utilize this pattern, follow these steps:

1. Create a new repository class that extends the `BaseRepository` class from `andersao/l5-repository`.
2. Use the repository class to interact with your database tables and perform operations such as fetching, creating, updating, and deleting records.

```php
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    // Your custom repository methods here
}
```

