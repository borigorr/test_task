## Запуск приложения
1. cp .env.example .env
2. docker-compose up
3. В контейнере php выполнить команду composer install
4. В контейнере php выполнить команду php artisan migrate
5. Для созданяи администратора выполнить команду php artisan user:create-admin {пароль пользоватееля}. Должен созаться пользователь с email admin@admin.admin
6. Для создания остальных пользователй в контейнере php нужно выполнить команду php artisan db:seed

Приложение откроется по ссылке http://localhost/

Swagger: http://localhost/api/documentation
