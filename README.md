# Flarum Queue

This is a helper package for extension developers that adds Laravel Queue ability to Flarum.

## Installation

Inside your the `composer.json` of your extension add under the require section `bokt/flarum-queue`:

```json
  "require": {
    // ..
    "bokt/flarum-queue": "*"
  }
```

Make sure you register the QueueProvider in your `extend.php`:

```php
return [
    new \Bokt\Queue\Extend\Provider(\Bokt\Queue\Providers\QueueProvider::class),
  // .. your code
];
```