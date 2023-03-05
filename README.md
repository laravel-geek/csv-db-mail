# Рассылка уведомлений по email

Это приложение предназначено для рассылки уведомлений по email пользователям, которые хранятся в базе данных. Приложение может быть использовано для отправки различных видов уведомлений, таких как новости, акции, оповещения и т.д.

Приложение обеспечивает следующие функции:

- Загрузка списка пользователей из файла CSV в базу данных
- Обход всех пользователей в базе данных и добавление их в очередь рассылки
- Отправка уведомлений по email каждому пользователю в очереди
- Управление отправленными уведомлениями и предотвращение повторной отправки

## Установка и запуск
- Склонируйте проект 
- Создайте базу данных и таблицы, используя скрипты, предоставленные в проекте
- Загрузите список пользователей в базу данных, используя файл CSV и скрипт index.php:

```
$ php index.php /users.csv
```
- Запустите процесс рассылки уведомлений, используя скрипт send_notifications.php: 

```
$ php send_notifications.php
```

## Использование

Для использования приложения вам необходимо загрузить список пользователей в базу данных, используя файл CSV, как показано выше. После этого вы можете запустить процесс рассылки уведомлений, который добавит всех пользователей в очередь рассылки и отправит им уведомления по email.

Если рассылка прервалась в неожиданный момент и вы хотите запустить ее снова, приложение автоматически предотвратит повторную отправку уведомлений тем же пользователям, которые уже получили уведомления.

# Тестовое задание

Необходимо реализовать api, без использования фреймворков, библиотек, только нативные методы.
PHP7+ / любая реляционная база данных, бд и таблицы нужно создать самому

Задание 1
Реализовать механизм загрузки списка пользователей в БД для рассылки из переданного извне файла в формате .csv (номер, имя)


Задание 2
Необходимо реализовать механизм обхода всех людей в бд, например которых залил в 1 задание и отправить их в очередь рассылки (саму рассылку реализовать не надо), просто создается фиктивный метод, считается, что отправка происходит мгновенно и 100% доставляется. Стоит еще предусмотреть, если рассылка прекратилась в неожиданный момент и нужно ее запустить еще раз и не отправлять тем, кому она уже отправилась. В рассылке должно быть название и текст, рассылок может быть несколько по один и тем же людям