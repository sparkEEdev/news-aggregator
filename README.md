
### Setup
- Clone the repo
- 


### API & Manual testing
The project utilizes Request-Docs package, after setup you can visit the `/request-docs` endpoint to perform manual tests, export OpenAPI and more. More information on [https://github.com/rakutentech/laravel-request-docs](https://github.com/rakutentech/laravel-request-docs)

#### Testing accounts - post seed
- ADMIN 
    - email: foo@bar.com
    - password: 12345678
- USER
    - email: bar@foo.com
    - password: 12345678

#### Structure
The core business logic is located in `App\Core` directory, resembling feature-based structure.

#### Notes

