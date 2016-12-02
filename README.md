symfony3-restapi
=========

Sample app to create REST APIs using [friendsofsymfony/rest-bundle](https://packagist.org/packages/friendsofsymfony/rest-bundle) and [nelmio/cors-bundle](https://packagist.org/packages/nelmio/cors-bundle)

##Steps to install

- Clone the repository: git remote add origin https://github.com/steady-daddy/symfony3-restapi.git
- CD to the project root: `> cd symfony3-restapi`
- Use composer to install project dependencies: `> composer install`
- Once dependencies are installed you'll be asked to provide database credentials.
- Generate a user entity using console: `> php bin/console generate:doctrine:entity`
  Create a database table `user` with the three columns: `id`,`name` and `role`
- Run the built in server: `> php bin/console server:run` and browse to `http://127.0.0.1:8000` to access the project
- Use [Postman REST Client] (https://www.getpostman.com/) to test the REST APIs.