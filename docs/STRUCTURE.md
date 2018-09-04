Project folder structure

```
root
 | - config: Hold config files, env files
 |    | - docker: Hold Docker config
 | - docs: document files
 | - src: source files
 |    | - common: application base components
 |    | - domains: application domains, hold services and repositories
 |    | - models: ORM models
 |    | - example-module
 |    | ...
 | - vendor: Composer libraries
 | - .editorconfig: source code style config
 | - .gitignore
 | - composer.json: Composer config file
 | - composer.lock: Composer lock file
 | - index.php: application entry point
 | - LICENSE: license information
 | - README.md: project readme file
```