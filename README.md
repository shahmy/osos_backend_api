## About project

- it done using laravel version 10
- its used laravel passport authentication and spatie permission packages
- API based URL will be http://127.0.0.1:8000
- u can create database and its record using [php artisan migrate:fresh --seed] artisan command.
- in default, system will have author, user, and admin user types and author, user and super-admin roles.
- after running the migration command, we have to [php artisan passport:install] to create Personal access client. 
- default login credentials (Super admin role) will be as follows, 
-- user email: admin@admin.com and password: admin 

## API document URL

- https://documenter.getpostman.com/view/25566948/2s93ecvqBN