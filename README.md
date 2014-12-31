# Social Meta

[![Build Status](https://travis-ci.org/gourmet/social-meta.svg?branch=master)](https://travis-ci.org/gourmet/social-meta)
[![Total Downloads](https://poser.pugx.org/gourmet/social-meta/downloads.svg)](https://packagist.org/packages/gourmet/social-meta)
[![License](https://poser.pugx.org/gourmet/social-meta/license.svg)](https://packagist.org/packages/gourmet/social-meta)

Adds [Facebook Open Graph][fbog] and [Twitter Cards][twcards] support to [CakePHP 3][cakephp].

## What's included?

- CardHelper
- OpenGraphHelper

## Install

Using [Composer][composer]:

```
composer require gourmet/social-meta
```

Because this plugin has the type `cakephp-plugin` set in its own `composer.json`,
[Composer][composer] will install it inside your /plugins directory, rather than
in your `vendor-dir`. It is recommended that you add /plugins/gourmet to your
`.gitignore` file and here's [why][composer:ignore].

You then need to load the plugin. In `boostrap.php`, something like:

```php
\Cake\Core\Plugin::load('Gourmet/SocialMeta');
```

## Usage

First, include the helpers in your `AppController`, specific `Controller` or `AppView`. Example in
`AppController`:

```php
public $helpers = [
    'Gourmet\SocialMeta.Card',
    'Gourmet\SocialMeta.OpenGraph'
];
```

Keep in mind that certain configuration option are made available to you. For example:

```php
public $helpers = [
    'Gourmet\SocialMeta.Card' => [
        'card' => 'photo',
        'tags' => ['twitter' => [
            'description' => 'Some default description'
        ]]
    ],
    'Gourmet\SocialMeta.OpenGraph' => [
        'app_id' => 'xxx'
    ]
];
```

You are now ready to use the helpers in your view.

For the [Facebook OpenGraph][fbog], you will need to use the helper's `html()` method as it will include the defined
namespaces:

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

Copyright (c) 2015, Jad Bitar and licensed under [The MIT License][mit].

[cakephp]:http://cakephp.org
[composer]:http://getcomposer.org
[composer:ignore]:http://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md
[mit]:http://www.opensource.org/licenses/mit-license.php
[fbog]:https://developers.facebook.com/docs/opengraph
[twcards]:https://dev.twitter.com/cards/overview
