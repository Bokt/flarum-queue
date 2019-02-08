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
    new \Bokt\Queue\Extend\EnableQueues,
  // .. your code
];
```

## User instructions

By default the database driver is used. You can override this by providing a queue configuration
in your `config.php` under the `queue` key, eg:

```php
  'database' => [
    // ..
  ],
  'queue' => [
    'driver' => 'redis',
    'connection' => 'default',
    'queue' => env('REDIS_QUEUE', 'default'),
    'retry_after' => 90,
    'block_for' => null,
  ],
```
This configuration will we be bound under `queue.connections.custom` and set as the default.

### Database queue

Make sure you add to your user instructions the need to run:

```bash
$ php flarum queue:tables
```

This will migrate the jobs and failed_jobs tables into the database.
