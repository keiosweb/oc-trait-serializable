# Keios/oc-trait-serializable

[![Latest Version](https://img.shields.io/github/release/keiosweb/oc-trait-serializable.svg?style=flat-square)](https://github.com/keiosweb/oc-trait-serializable/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/keios/oc-trait-serializable.svg?style=flat-square)](https://packagist.org/packages/keios/oc-trait-serializable)

Trait for OctoberCMS' models allowing storage of serialized objects.

## Install

Via Composer

``` bash
$ composer require keios/oc-trait-serializable
```

## Usage

``` php
class Account extends Model {           // example model extending October's October\Rain\Database\Model
    use \Keios\Serializable\Serializable;

    protected $serializable = ['fieldToStoreSerializedObjects', 'anotherField'];
}
```

## Security

If you discover any security related issues, please email lukasz@c-call.eu instead of using the issue tracker.

## Credits

- [Keios Solutions](https://github.com/keiosweb)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
