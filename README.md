# workflow-symfony
workflow symfony

Steps : 
1 - conf database (sqlite)
2 - docker-compose build / docker-compose up for mail catcher
3 - console d:d:c (create database)
4 - console make:user
5 - console make:migration
6 - console make:auth
7 - console make:registration-form
8 - console serve -d OR use php -S 127.0.0.1:8000 -t public
9 - console 
