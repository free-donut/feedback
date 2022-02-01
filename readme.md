## Установка

- Склонировать репозиторий
- Установить зависимости - в папке проекта выполнить:
```console
make install
```

## Запуск

- Запуск проекта:
```console
make docker
```
- Получить IP базы данных:
```console
make db-ip
```
- Создать файл ".env.local". В файл добавить следующие строки, заменив **db_ip** на полученный IP базы данных:
```
APP_ENV=dev
DATABASE_URL=mysql://feedback_db:feedback_pass@db_ip/feedback_db?serverVersion=mariadb-10.6.5
```
- Запуск миграций и заполнение базы данных фикстурами::
```console
make db-create
```
- Сборка фронтенда:
```console
yarn encore production
```
В случае успешного запуска проект будет доступен по [адресу](http://localhost:3000/)

## Тестирование

Тестирование осуществляется с помощью PHPUnit.
- Создать файл ".env.test.local". В файл добавить следующие строки, заменив **db_ip** на IP базы данных:
```
DATABASE_URL=mysql://feedback_db:feedback_pass@db_ip/test_feedback_db?serverVersion=mariadb-10.6.5
```
- Создание и заполнение тестовой базы данных фикстурами:
```console
make test-db-create
```
- Запуск тестов:
```console
make test
```