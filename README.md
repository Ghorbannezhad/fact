Fact Generator
=================

Fact generator is a simple laravel package which generate fact image. You only need to define your desired image, logo and text to generate sample fact image.
It support English and Persian.


##Install

1- Install the package with composer
```ssh
composer require --dev ghorbannezhad/fact
```

2- Publish config file
```ssh
php artisan vendor:publish --provider="Ghorbannezhad\Fact\FactServiceProvider"
```

##Usage
1- Add service provider to config/app.php
```php
'providers' => [
    ...
    Ghorbannezhad\Fact\FactServiceProvider::class,
]
```

2- Call fact facade in controller
```php
    $image = public_path('/address/to/image.jpg');
    $text= 'Lorem ipsum';
    $fact = FactFacade::create($image,$text);
```
##Contributers
* Faezeh Ghorbannezhad [@ghorbannezhad](http://github.com/Ghorbannezhad)
* Mostafa Zeinivand [@mostafaznv](http://github.com/mostafaznv)
* Ramin Khatibi [@raminix](http://github.com/raminix)
* Mostafa Zeinivand [@SamssonApps](http://github.com/SamssonApps)

### License

Monolog is licensed under the MIT License - see the `LICENSE` file for details



