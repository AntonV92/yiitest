1. При использовании с Docker необходим образ с PHP 7.2+ Mysql 5.7+
2. В образе указать пути до базы данных и приложения
volumes:
    ./_host-volumes/app:/app:delegated  // где app: - это папка с приложением ;
    
3. В конфиге проекта config/db.php указать host:имя контейнера с mysql // 'dsn' => 'mysql:host=container_name;dbname=db'
