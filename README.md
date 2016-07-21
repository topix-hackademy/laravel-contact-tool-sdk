# laravel-contact-tool-sdk

Laravel Set of Models to perform access to Contact and Company data models.

## Install

Add Packge dependency to project composer.json

```
   "require": {
       "laravel/framework": "5.2.*",

       ...

       "topix-hackademy/laravel-contact-tool-sdk": "dev-master"
   },
```

Launch a ` composer update `

Add Service Provider to /config/app.php

```
   'providers' => [
           Illuminate\Auth\AuthServiceProvider::class,

           ...

           Topix\Hackademy\ContactToolSdk\ServiceProvider::class,
```

Do a ` composer dump-autoload`

## Usage

#### Setup

To have access you need to set in Api.php class:

* Api Base Url: (EG: http://example.com/api/v1/)
* Service Token

#### Classes

Available classes are : Company, Contact, CompanyType, ContactType


| Method | Parameters | Usage |
| ------ | ---------- | ----- |
| all    | \*  | Get all the entities |
| get    | id         | Get an entity by ID |
| create | data       | Crate an entity |
| update | id, data   | Update the entity with the provoded ID |
| delete | id         | Delte the entity with the provded ID |


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/:vendor/:package_name.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/:vendor/:package_name/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/:vendor/:package_name.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/:vendor/:package_name.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/:vendor/:package_name.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/:vendor/:package_name
[link-travis]: https://travis-ci.org/:vendor/:package_name
[link-scrutinizer]: https://scrutinizer-ci.com/g/:vendor/:package_name/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/:vendor/:package_name
[link-downloads]: https://packagist.org/packages/:vendor/:package_name
[link-author]: https://github.com/:author_username
[link-contributors]: ../../contributors
