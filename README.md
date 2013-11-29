## SlimExt
SlimExt - monkeypatched extension to [slim](http://slimframework.com), that added functionality of nested routes (for easy url prefixing and adding middlewares), component support (not symfony).

## Route url prefixes
```php
$app->prefix("/uac", function () use ($app) {
    // Route registered as /uac/login
    $app->get("/login", function () use ($app) {
        $app->render("login", array());
    });
});
```
## Middleware
```php
$app->prefix("/admin", Midleware::userAdmin(), function () use ($app) {
    // Routes registered with Middleware::userAdmin() middleware
    $app->get("/", function () use ($app) {/* ... */});
    $app->get("/users", function () use ($app) {/* ... */});
});
```
or even
```php
$app->prefix("/uac", Middleware::userLogged(), function () use ($app) {
    $app->prefix("/edit", function () use ($app) {
        $app->map("/avatar", function () use ($app) {});
        $app->map("/info", function () use ($app) {});
        $app->prefix("/photos", Middleware::userCanManagePhotos(), function () use ($app) {
            $app->map("/upload", function () use ($app) {});
            $app->map("/delete/:id", function ($id) use ($app) {});
            $app->map("/edit/:id", function ($id) use ($app) {});
        });
    });
});
```
## Components
```php
// Uac/urls.php
$app->prefix("/uac", function () use ($app) {
    $app->map("/login", function () use ($app) {
        // ...
    });
});
// bootstrap
$app->config("comps", array("Uac"));
$app->loadComponents();
```

Route /uac/login/ registered and ready. 

Another example - integration with [autoparis](http://github.com/shadowprince/autoparis). You can automaticly grab all models (detached to components) just from `$app->config("comps")`.

## Services
Service - instance for adding new functionality into $app:
```php
class MyApp extends \SlimExt\SlimExt {
    public function user() {
        return $this->user_service_instance;
    }
}

class UserService extends \SlimExt\SlimService {
    public function __construct($app) {
        $this->defaultConfig($app, array(
            "default config" => "can be here"
        ));
    }

    public function isLogged() {
        // ...
    }
}
```
