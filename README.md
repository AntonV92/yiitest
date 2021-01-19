1. Для развертывания можно использовать образ https://github.com/yiisoft/yii2-docker
В папке с докер образом создать .env файл, содержание для него скопировать из проекта с образом из файла .env-dist
В docker-compose.yml необходимо добавить конфигурацию Mysql
Можно использовать такую:

version: '2.2'
services:

  php:
    build:
      dockerfile: Dockerfile-${DOCKERFILE_FLAVOUR}
      context: 'php'
      args:
        - PHP_BASE_IMAGE_VERSION
        - X_LEGACY_GD_LIB
        - PECL_XDEBUG_INSTALL_SUFFIX
        - PECL_MONGODB_INSTALL_SUFFIX
    image: ${PHP_IMAGE_NAME}:${PHP_BASE_IMAGE_VERSION}${PHP_IMAGE_VERSION_SUFFIX}
    environment:
      - GITHUB_API_TOKEN=${GITHUB_API_TOKEN}
      - PHP_ENABLE_XDEBUG
      - TEST_RUNTIME_PATH=/tmp/runtime
    volumes:
      - ./tests:/tests:delegated
      # Framework testing
      - ./_host-volumes/yii2:/yii2:delegated
      # Application testing
      - ./_host-volumes/app:/app:delegated
      # Composer cache
      - ~/.composer-docker/cache:/root/.composer/cache:delegated
    ports:
      - "80:80" 


  db:
    image: mysql:5.7
    restart: always
    environment:
      MYSQL_DATABASE: 'db'
      # So you don't have to use root, but you can if you like
      MYSQL_USER: 'user'
      # You can use whatever password you like
      MYSQL_PASSWORD: 'password'
      # Password for root access
      MYSQL_ROOT_PASSWORD: 'password'
    ports:
      # <Port exposed> : < MySQL Port running inside container>
      - '3306:3306'
    expose:
      # Opens port 3306 on the container
      - '3306'
      # Where our data will be persisted
    volumes:
     - ./test_db
    
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
6. В консоли контейнера с приложением создать файлы миграций для импорта базы данных. Для каждого .sql файла создаем по файлу с помощью команды yii migrate/create file_name;
7. В файлах миграции указать имена файлов для миграции базы в метод:
public function safeUp()
    {   
        $sql = file_get_contents('./migrations/test_db_structure.sql');

        $this->execute($sql);
    }
    
8. Выполнить миграцию с помощью команды yii migrate
