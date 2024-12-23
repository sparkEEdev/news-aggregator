## About
Small news aggregator(crawler) project with built in apis for consumption, with an easy way to extend news data sources.

### Setup
- Clone the repo
- Run `cp .env.example .env`
- Fill out required API keys at the bottom of .env
- Run `docker compose build`
- Run `docker compose up -d`
- For the sake of testing it is suggested to run `php artisan schedule:run` to fill out the database, otherwise scheduler is set to run once a day for demonstration purposes.

### API & Manual testing
The project utilizes Request-Docs package, after setup you can visit the `/request-docs` endpoint to perform manual tests, export OpenAPI/Swagger and more. More information on [https://github.com/rakutentech/laravel-request-docs](https://github.com/rakutentech/laravel-request-docs)

#### Testing accounts - post seed
- ADMIN 
    - email: foo@bar.com
    - password: 12345678
- USER
    - email: bar@foo.com
    - password: 12345678

#### Structure
The core business logic is located in `App\Core` as well as `App\Services` directory, resembling feature-based structure.

#### Notes
Due to time constraints some functionality, code polish and tests were omitted.