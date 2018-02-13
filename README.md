NanoBlog
========

A sample Symfony project to create a Nano Blog.

### Install dependencies
```
composer install
```


### Create MySql Database & User & Grant Privileges

```
CREATE DATABASE nano_blog;
CREATE USER 'nano_blog_user'@'localhost' IDENTIFIED BY 'nano_blog_user_password';
GRANT ALL PRIVILEGES ON nano_blog . * TO 'nano_blog_user'@'localhost';
```

### Run migrations
```
php bin/console doctrine:schema:update --force
```

### Create admin user
```
php bin/console fos:user:create testuser test@example.com password --super-admin
```

### Start server
```
php bin/console server:start
```

Go to: [http://localhost:8000/en/login](http://localhost:8000/en/login)

Login with:
 - username: testuser
 - password: password

### Run unit tests
```
cd [project root]
php vendor/phpunit/phpunit/phpunit --bootstrap tests/unittests/Bootstrap.php --configuration tests/unittests/phpunit.xml tests/unittests/src --teamcity
```


