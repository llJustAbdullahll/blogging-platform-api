# Blogging Platform API

## Overview

A RESTful API built with Laravel for managing blog posts, categories, tags, and token-based user authentication. It also supports filtering, validation, and organized API responses.

This project is based on the [Blogging Platform API challenge](https://roadmap.sh/projects/blogging-platform-api) from [roadmap.sh](https://roadmap.sh/).

## Features

- CRUD operations for posts, categories, and tags.
- Search functionality for posts based on title, content, and category.
- Automatically creates tags if they don't exist when adding them to a post.
- Returns organized JSON responses with proper HTTP status codes.

## API Routes

A simple explanation of the available API routes:

### Posts

- `GET /api/posts` - Retrieve all posts with their category, tags, and author name. Supports search using `searchTerm`.
- `POST /api/posts` - Create a new post. Requires `title`, `content`, `category_id`, `user_id`, and optional `tags`.
- `GET /api/posts/{id}` - Retrieve a single post with its category, tags, and author name.
- `PUT /api/posts/{id}` - Update an existing post.
- `DELETE /api/posts/{id}` - Delete a post and remove its related tags.

### Categories

- `GET /api/categories` - Retrieve all categories.
- `POST /api/categories` - Create a new category.
- `GET /api/categories/{id}` - Retrieve a single category.
- `PUT /api/categories/{id}` - Update an existing category.
- `DELETE /api/categories/{id}` - Delete a category.

### Tags

- `GET /api/tags` - Retrieve all tags.
- `POST /api/tags` - Create a new tag.
- `GET /api/tags/{id}` - Retrieve a single tag.
- `PUT /api/tags/{id}` - Update an existing tag.
- `DELETE /api/tags/{id}` - Delete a tag.

## Requirements

- PHP >= 8.2
- Composer
- MySQL or any other supported database

## Installation

Follow these steps to install and run the API:

1. Clone the repository:

   ```bash
   git clone <repository-url>
   cd blogging-platform-api
   ```

2. Install dependencies:

   ```bash
   composer install
   ```

3. Copy `.env.example` to `.env`:

   ```bash
   cp .env.example .env
   ```

4. Generate the application key:

   ```bash
   php artisan key:generate
   ```

5. Set up your database.

   Configure your `.env` file with your database credentials:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

6. Run the database migrations:

   ```bash
   php artisan migrate
   ```

7. Start the development server:

   ```bash
   php artisan serve
   ```

8. Access the API:

   The API will be available at:

   `http://127.0.0.1:8000/api`

   Use this URL in Postman to test the API endpoints.
