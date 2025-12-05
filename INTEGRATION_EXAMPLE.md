# Example: Using BitCMS Plugin in Your CakePHP 5 Application

This example demonstrates how to integrate the BitCMS plugin into a CakePHP 5 application.

## Installation

1. Install the plugin via Composer (if published) or add to your project:

```bash
composer require your-vendor/bitcms
```

Or for local development, add to `composer.json`:

```json
{
    "require": {
        "your-vendor/bitcms": "dev-main"
    },
    "repositories": [
        {
            "type": "path",
            "url": "../bitcms"
        }
    ]
}
```

## Application Setup

### 1. Load the Plugin in Application.php

Edit your application's `src/Application.php`:

```php
<?php
declare(strict_types=1);

namespace App;

use Cake\Core\Configure;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

class Application extends BaseApplication
{
    public function bootstrap(): void
    {
        parent::bootstrap();

        // Load the BitCMS plugin
        // The 'routes' => true option will load plugin routes
        // The 'bootstrap' => true option will run plugin bootstrap
        $this->addPlugin('Bitcms', [
            'routes' => true,
            'bootstrap' => true,
        ]);
    }

    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            // Error handling middleware
            ->add(new ErrorHandlerMiddleware(Configure::read('Error')))

            // Asset middleware
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))

            // Routing middleware
            ->add(new RoutingMiddleware($this))

            // Body parser middleware
            ->add(new BodyParserMiddleware())

            // CSRF protection (optional)
            ->add(new CsrfProtectionMiddleware([
                'httponly' => true,
            ]));

        // Note: Authentication middleware is automatically added by the BitCMS plugin
        // You don't need to add it manually!

        return $middlewareQueue;
    }
}
```

### 2. Create a Login Controller

Create `src/Controller/UsersController.php`:

```php
<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;

class UsersController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
        
        // Allow unauthenticated access to login and register
        $this->Authentication->addUnauthenticatedActions(['login', 'register']);
    }

    public function login()
    {
        $result = $this->Authentication->getResult();
        
        // If user is already logged in, redirect
        if ($result->isValid()) {
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Dashboard',
                'action' => 'index',
            ]);
            return $this->redirect($redirect);
        }
        
        // Display error if login failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Invalid username or password');
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['action' => 'login']);
    }
}
```

### 3. Create a Login Template

Create `templates/Users/login.php`:

```php
<div class="users form">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Please enter your email and password') ?></legend>
        <?= $this->Form->control('email', ['required' => true]) ?>
        <?= $this->Form->control('password', ['required' => true]) ?>
    </fieldset>
    <?= $this->Form->submit(__('Login')); ?>
    <?= $this->Form->end() ?>
</div>
```

### 4. Protect Your Controllers

For controllers that require authentication, extend from `Bitcms\Controller\AppController`:

```php
<?php
declare(strict_types=1);

namespace App\Controller;

use Bitcms\Controller\AppController;

class DashboardController extends AppController
{
    public function index()
    {
        // This action is automatically protected by authentication
        // The user data is available as $this->authUser
        $this->set('user', $this->authUser);
    }
}
```

Or use the Authentication component in your own AppController:

```php
<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
        
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Configure public actions that don't require login
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }
}
```

### 5. Database Setup

Make sure you have a users table with at least these fields:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    created DATETIME,
    modified DATETIME
);
```

### 6. User Entity with Password Hashing

Create `src/Model/Entity/User.php`:

```php
<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

class User extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    protected $_hidden = [
        'password',
    ];

    // Automatically hash passwords when they are changed
    protected function _setPassword(string $password): ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    }
}
```

## That's It!

The BitCMS plugin now handles:
- ✅ Authentication middleware setup
- ✅ Session management
- ✅ Form authentication
- ✅ Password verification
- ✅ User identity management

You just need to:
1. Load the plugin
2. Create login/logout actions
3. Protect your controllers

## Accessing Current User

In any controller:

```php
$user = $this->Authentication->getIdentity();
if ($user) {
    $userId = $user->getIdentifier(); // Get user ID
    $userData = $user->getOriginalData(); // Get full user data
}
```

In any template:

```php
<?php if ($authUser): ?>
    <p>Welcome, <?= h($authUser->email) ?>!</p>
<?php endif; ?>
```

## Advanced: Custom Authorization

You can override the `isAuthorized()` method in your controllers:

```php
public function isAuthorized($user): bool
{
    // Allow all logged-in users to view
    if ($this->request->getParam('action') === 'view') {
        return true;
    }
    
    // Only admins can edit
    if ($this->request->getParam('action') === 'edit') {
        return !empty($user) && $user['role'] === 'admin';
    }
    
    return parent::isAuthorized($user);
}
```

