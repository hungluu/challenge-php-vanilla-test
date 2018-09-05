# MVC test with design patterns, unit testing, API structure, UI/UX ...

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
composer docker:start
```
For more information about all available commands, please head down to `Commands` section

## Commands
Available commands:
```
composer install            # Install all required composer packages
composer docker:start       # Ensure docker containers set up and start the application
composer docker:start:watch # Alias of docker:start in watch mode
composer docker:restart     # Restart docker containers
composer docker:rm          # Removed installed docker containers
```

## Structure
Please read `docs/STRUCTURE.md`

## Issues
Please leave any issues under Issues section of this repository. I will try my best to help you.

## License
This project is licensed under MIT. Feel free to use any parts of this project for you works.