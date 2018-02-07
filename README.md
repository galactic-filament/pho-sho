# pho-sho

[![Build Status](https://travis-ci.org/galactic-filament/pho-sho.svg?branch=master)](https://travis-ci.org/galactic-filament/pho-sho)

## Libraries

Kind | Name
--- | ---
Web Framework | [Silex](https://silex.symfony.com/)
SQL ORM | [Doctrine](http://www.doctrine-project.org/)
Logging | [Monolog](https://github.com/Seldaek/monolog)
Test Framework | [PhpUnit](https://phpunit.de/)
Test Coverage | NYI

## Features Implemented

- [x] Hello world routes
- [x] CRUD routes for persisting posts
- [x] Database access
- [x] Request logging to /srv/app/log/app.log
- [x] Unit tests
- [ ] Unit test coverage reporting
- [x] Automated testing using TravisCI
- [ ] Automated coverage reporting using Coveralls
- [ ] CRUD routes for user management
- [ ] Password encryption using bcrypt
- [ ] Routes protected via HTTP authentication
- [ ] Routes protected via ACLs
- [x] Validates environment (env vars, database host and port are accessible)
