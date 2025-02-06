# Документация по запуску

## Требования

Для успешного запуска проекта:
- **PHP 7.4**
- **MySQL 8.0**
- **Laravel 8**
- **Docker + Docker Compose**
- **Git**

## Установка и запуск проекта

### 1. Клонирование репозитория
```sh
git clone https://github.com/djasurbek01/organization.git
cd organization
```

### 2. Создание файла конфигурации

Скопируйте `.env.example` в `.env`:
```sh
cp .env.example .env
```

### 3. Запуск контейнеров Docker

```sh
docker-compose up -d --build
```
Это запустит контейнеры Laravel и MySQL.

### 4. Установка зависимостей
```sh
docker exec -it organization_test_app composer install
```

### 5. Генерация ключа приложения
```sh
docker exec -it organization_test_app php artisan key:generate
```

### 6. Запуск миграций и заполнение базы данных тестовыми данными
```sh
docker exec -it organization_test_app php artisan migrate --seed
```

### 7. Очистка и обновление кеша конфигурации
```sh
docker exec -it organization_test_app php artisan config:clear
```

### 8. Доступ к проекту

После успешного запуска, проект будет доступен по адресу:
```
http://localhost:8000
```

## Работа с API (Swagger UI)
После запуска API документация доступна по адресу:
```
http://localhost:8000/api/documentation
```

## Остановка и удаление контейнеров

Чтобы остановить контейнеры:
```sh
docker-compose down
```

Чтобы полностью удалить контейнеры и тома БД:
```sh
docker-compose down -v
```

## Полезные команды

Подключиться к контейнеру organization_test_app:
```sh
docker exec -it organization_test_app bash
```

Подключиться к MySQL внутри контейнера:
```sh
docker exec -it organization mysql -u root -p
```
 Если возникли ошибки, проверьте логи контейнеров:
```sh
docker logs organization_test_app
```
```sh
docker logs organization
```

