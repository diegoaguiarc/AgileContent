# AGILE CONTENT - TECH TEST

## DESCRIPTION
The answer was developed as a Laravel 11 project and it has a dockerfile and docker-compose.yml files that brings up a containerized environment for local development/execution.

## REQUIRIMENTS
It is necessary to have installed: PHP (version >= 8), Composer, Docker (or Docker Desktop).

## INSTRUCTIONS

1. Clone the code from GitHub
> git clone https://github.com/diegoaguiarc/AgileContent.git

2. Run composer inside 'src' folder
> composer install

3. Run docker environment 
   1. Adjust the database info if necessary in the docker-composer.yml;
   2. Before hise up the containers, make a copy of "/src/.env-example" and rename as ".env". After that set the database properties
> docker-compose up --build -d

4. Check MySql database using phpMyAdmin:
> http://localhost:8081/

5. Choose to run the database DDL/DML from local terminal or container terminal
> OBS: if running locally it might be necessary to adjust the env property DB_HOST to value "localhost"
> php artisan migrate:refresh --seed

6. Check the API 
> See the helper postman file if necessary: postman_collection.json 
> The auth method uses "Bearer Token"  
> URLs:
>> POST http://localhost:8080/api/login     
>> POST http://localhost:8080/api/logout
>> GET  http://localhost:8080/api/users
>> POST  http://localhost:8080/api/users
>> GET  http://localhost:8080/api/users/{id}
>> PUT  http://localhost:8080/api/users/{id}
>> DELETE  http://localhost:8080/api/users/{id}

7. Run tests
> OBS: once running locally it might be necessary to adjust the env property DB_HOST to value "localhost"
> php artisan test
