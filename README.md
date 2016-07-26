# laravel-contact-tool-sdk

Laravel Set of Models to perform access to Contact and Company data models.

## Install

#### Add Packge dependency and repository to project composer.json

```
   "require": {
       ...
       "topix-hackademy/laravel-contact-tool-sdk": ">=0.0.1"
   },

   ...

   "repositories": [
       {
           "type": "git",
           "url": "https://github.com/topix-hackademy/laravel-contact-tool-sdk.git"
       }
   ]

```

Launch a ` composer update `

#### Add Service Provider to /config/app.php

```
   'providers' => [
           ...
           Topix\Hackademy\ContactToolSdk\ServiceProvider::class,
```

Update the autoloader with: ` composer dump-autoload`

Publish package files with: ` php artisan vendor:publish `

## Usage

#### Setup

To have access you need to set in /config/anagrafica.php:

* Api Base Url: (EG: http://example.com/api/v1/)
* Service Token: (EG: YOUR-SERVICE-TOKEN)

#### Classes

##### API Classes

API Available classes are : Company, Contact, CompanyType, ContactType

| Method | Parameters | Usage |
| ------ | ---------- | ----- |
| all    | \*  | Get all the entities |
| get    | id         | Get an entity with the provoded ID |
| create | data       | Crate an entity |
| update | id, data   | Update the entity with the provided ID |
| delete | id         | Delte the entity with the provided ID |

##### Contact Tool Class

Contact tool class work in conjutin with a Laravel Model to manage local and remote data,

To use a laravel model with 'Contac Tool':

* Model must implement 'iReferable' interface (Topix\Hackademy\ContactToolSdk\Contact\Contracts\iReferable)
* Model must use 'Referable' Trait (Topix\Hackademy\ContactToolSdk\Contact\Traits)

| Method          | Parameters       | Usage                                      |
| --------------- | ---------------- | ------------------------------------------ |
| getReference    | iReferable       | Get Reference data related to this model |
| createContact   | iReferable, data | Create Remote Contact Related data and local Relations |
| createCompany   | iReferable, data | Create Remote Company Related data and local Relations |
| updateReference | iReferable, data | Update Remote Reference Related data and local Relations |

##### Facade

If you want to use the ContactTool Facade you need to include an alias in /config/app.php

```
    'aliases' => [
		'ContactTool' => \Topix\Hackademy\ContactToolSdk\Contact\Facades\ContactTool::class,
```

#### Trait

You can use the 'Refereable' Trait (Topix\Hackademy\ContactToolSdk\Contact\Traits) in every class
tha extends Topix\Hackademy\ContactToolSdk\Contact\Contracts\iReferable


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
