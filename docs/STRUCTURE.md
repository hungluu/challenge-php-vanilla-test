Project folder structure

```
root
 | - config: Hold config files, env files
 |    | - docker: Hold Docker config
 |    | - nginx: Hold nginx config
 | - docs: document files
 | - src: source files
 |    | - common: application base components
 |    | - domains: application domains, hold services and repositories
 |    | - models: ORM models
 |    | - example-module
 |    | ...
 | - vendor: Composer libraries
 | - public: Hold public files
 |    | - index.php: application entry point
 | - .editorconfig: source code style config
 | - .gitignore
 | - composer.json: Composer config file
 | - composer.lock: Composer lock file
 | - LICENSE: license information
 | - README.md: project readme file
```