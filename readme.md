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
DATABASE_URL=mysql://feedback_db:feedback_pass@db_ip/feedback_db?serverVersion=5.6
```
- Запуск миграций:
```console
make db-migrations
```
- Заполнение базы данных фикстурами:
```console
make db-fixtures
```
- Сборка фронтенда:
```console
yarn encore production
```
В случае успешного запуска проект будет доступен по [адресу](http://localhost:3000/)

## Тестирование

Тестирование осуществляется с помощью PHPUnit. Запуск тестов:
```console
make test
```