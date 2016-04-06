# Social Meta

[![Build Status](https://img.shields.io/travis/gourmet/social-meta/master.svg?style=flat-square)](https://travis-ci.org/gourmet/social-meta)
[![Total Downloads](https://img.shields.io/packagist/dt/gourmet/social-meta.svg?style=flat-square)](https://packagist.org/packages/gourmet/social-meta)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.txt)

Adds [Facebook Open Graph][fbog] and [Twitter Cards][twcards] support to [CakePHP 3].

## What's included?

- CardHelper
- OpenGraphHelper

## Install

Using [Composer]:

```
composer require gourmet/social-meta:~1.0
```

You then need to load the plugin. In `boostrap.php`, something like:

```php
\Cake\Core\Plugin::load('Gourmet/SocialMeta');
```

## Usage

Include the helpers in your `AppView`:

```php
public function initialize(array $config)
{
    $this->loadHelper('Gourmet/SocialMeta.Card');
    $this->loadHelper('Gourmet/SocialMeta.OpenGraph');
}
```

Keep in mind that certain configuration option are made available to you. For example:

```php
public function initialize(array $config)
{
    $this->loadHelper('Gourmet/SocialMeta.Card', [
        'card' => 'photo',
        'tags' => ['twitter' => [
            'description' => 'Some default description'
        ]]
    ]);
    $this->loadHelper('Gourmet/SocialMeta.OpenGraph', [
        'app_id' => 'xxx'
    ]);
}
```

You are now ready to use the helpers in your view / layout.

For the [Facebook OpenGraph][fbog], you will need to use the helper's `html()` method as it
will include the defined namespaces:

```php
echo $this->OpenGraph->html();
```

or by passing extra options and namespaces:

```php
echo $this->OpenGraph->html(['lang' => 'en'], ['foo' => 'http://foo']);
```

You can then render the OpenGraph meta tags:

```php
echo $this->OpenGraph->render();
```

which will render the most basic stuff using some black magic, or you could be much more verbose:

```php
echo $this->OpenGraph
    ->setTitle('My Page')
    ->setDescription('One of my awesome pages')
    ->setImage('http://link.to/image', ['width' => '200', 'height' => '300'])
    ->render();
```

Other methods: `setType`, `setUri`, `setLocale`, `setName`, `setImage`, `setVideo`

For the [Twitter Cards][twcards], something similar to that last code example:

```php
echo $this->Card
    ->setTitle('My Page')
    ->setDescription('One of my awesome pages')
    ->setImage('http://link.to/image', ['width' => '200', 'height' => '300'])
    ->render();
```

Other methods: `setCard`, `setUrl`, `setData1`, `setLabel1`, `setData2`, `setLabel2`, `setCreator`, `setSite`, `setPlayer`

## Patches & Features

* Fork
* Mod, fix
* Test - this is important, so it's not unintentionally broken
* Commit - do not mess with license, todo, version, etc. (if you do change any, bump them into commits of
their own that I can ignore when I pull)
* Pull request - bonus point for topic branches

## Bugs & Feedback

http://github.com/gourmet/social-meta/issues

## License

Copyright (c)2015, Jad Bitar and licensed under [The MIT License][mit].

[CakePHP 3]:http://cakephp.org
[Composer]:http://getcomposer.org
[mit]:http://www.opensource.org/licenses/mit-license.php
[fbog]:https://developers.facebook.com/docs/opengraph
[twcards]:https://dev.twitter.com/cards/overview
