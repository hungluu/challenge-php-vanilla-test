# MVC test with design patterns, unit testing, API structure, UI/UX ...

[![Cirle CI][cirle-ci-badge]][cirle-ci-url]

**Table of contents**

  - [Prerequisites](#prerequisites)
  - [Getting started](#getting-started)
  - [Commands](#commands)
  - [Structure](#structure)
  - [Issues](#issues)
  - [License](#license)

## Prerequisites
This repository requires `composer` and `docker` installed. Please read `docs/PREREQUISITES.md` for more information.

## Getting started
Before start this application, composer packages should be installed by this command:
```
composer install
```

The application can be started with this command:
```
composer start
```

Wait for its completion, and get which docker container is used for running database, for example `docker_db_1`

Then use this command to do migration:
```
# CAUTION: This command should be used only once
# When the first time you run composer start
# This command creates `schedule` table with some dummy data

cat config/migrations/20180908_102801_test_schedule.sql | docker exec -i docker_db_1 psql -U postgres -d test
```

Access this application via browser with ip command `docker-machine ip` show, for example: [http://192.168.99.100/](http://192.168.99.100/)

For more information about all available commands, please head down to `Commands` section

## Commands
Available commands:
```
composer install            # Install all required composer packages
composer docker:start       # Ensure docker containers set up and start the application
composer docker:watch       # Alias of docker:start in watch mode
composer docker:restart     # Restart docker containers
composer docker:rm          # Removed installed docker containers
composer test:unit          # Run unit tests
composer test               # Run all tests
composer start              # Start application
```

## Structure
Please read `docs/STRUCTURE.md`

## Issues
Please leave any issues under Issues section of this repository. I will try my best to help you.

## License
This project is licensed under MIT. Feel free to use any parts of this project for you works.

[cirle-ci-badge]: https://circleci.com/gh/hungluu/mvc-test.png?style=shield
[cirle-ci-url]: https://circleci.com/gh/hungluu/mvc-test
