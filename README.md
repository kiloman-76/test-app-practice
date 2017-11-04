<p align="center">
   
    <h1 align="center">Тестовое приложение на Yii2 TestProject</h1>
    <br>
</p>

ИНФОРМАЦИЯ
-------------------

TestProject - Небольшое приложение на фреймворке Yii2 , которое имиирует денежные процессы между пользователями приложения

СТРУКТУРА И ВОЗМОЖНОСТИ
------------

Приложение состоит из интерфейса пользователя и интерфейса администратора.
Пользователь может перечислять деньги другому пользователю и смотреть все проведенные им операции
Администратор  может создавать и редактировать пользователей (в разработке), 
добавлять пользователю деньги, делать сделки от имени пользователя, давать и забирать 
права администратора, смотреть все операции пользователя.
 
УСТАНОВКА
-------------------

1) Клонировать проект 
2) Установить Composer
3) Настроить подключение к БД
3) ./yii migrate --migrationPath=@yii/rbac/migrations - Установить Rbac
4) ./yii migrate - Выполнить миграции проекта 
