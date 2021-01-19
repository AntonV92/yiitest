1. Для развертывания можно использовать образ https://github.com/yiisoft/yii2-docker
В папке с докер образом создать .env файл, содержание для него скопировать из проекта с образом из файла .env-dist
В docker-compose.yml необходимо добавить конфигурацию Mysql
Можно использовать конфигурацию из https://github.com/AntonV92/yiitest/blob/main/docker_example.yml
    
2. В образе (файл docker-compose.yml) указать пути до базы данных и приложения
php:
  volumes:
     ./_host-volumes/app:/app:delegated  // где app: - это папка с приложением ;
db:
   volumes:
     ./db // расположение базы в контейнере
     
     
3. Развернуть docker командой  docker-copmose up
4. Установить приложение в нужную папку
5. В конфиге проекта config/db.php указать host:имя контейнера с mysql // 'dsn' => 'mysql:host=container_name;dbname=db'

6. Выполнить миграцию с помощью команды yii migrate

