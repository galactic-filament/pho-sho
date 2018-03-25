# pho-sho

[![Build Status](https://travis-ci.org/galactic-filament/pho-sho.svg?branch=master)](https://travis-ci.org/galactic-filament/pho-sho)
[![Coverage Status](https://coveralls.io/repos/github/galactic-filament/pho-sho/badge.svg?branch=master)](https://coveralls.io/github/galactic-filament/pho-sho?branch=master)

## Libraries

Kind | Name
--- | ---
Web framework | [Silex](https://silex.symfony.com/)
SQL ORM | [Doctrine](http://www.doctrine-project.org/)
Logging | [Monolog](https://github.com/Seldaek/monolog)
Test framework | [PhpUnit](https://phpunit.de/)
Test coverage | [PhpUnit](https://phpunit.de/)
Password encryption | NYI
User authentication | NYI
Linting | [phpcs](https://github.com/squizlabs/PHP_CodeSniffer)

## Features Implemented

- [x] Hello world routes
- [x] CRUD routes for persisting posts
- [x] Database access
- [x] Request logging to /srv/app/log/app.log
- [x] Unit tests
- [x] Unit test coverage reporting
- [x] Automated testing using TravisCI
- [x] Automated coverage reporting using Coveralls
- [ ] CRUD routes for user management
- [ ] Password encryption using bcrypt
- [ ] Routes protected by cookie session
- [ ] Entities linked to logged in user
- [ ] Routes protected via HTTP authentication
- [ ] Routes protected via API key
- [x] Linting
- [x] Logging to file
- [ ] Logging to Logstash
- [ ] Routes protected via ACLs
- [ ] Migrations
- [ ] GraphQL endpoint
- [x] Validates environment (env vars, database host and port are accessible)
