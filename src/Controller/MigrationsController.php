<?php
declare(strict_types=1);

namespace Bitcms\Controller;

use Cake\Cache\Cache;
use JetBrains\PhpStorm\NoReturn;
use Migrations\Migrations;

/**
 * Migrations Controller
 */
class MigrationsController extends AppController
{
    /**
     * Run migrations
     *
     * @return void
     */
    #[NoReturn]
    public function migrate(): void
    {
        $migrations = new Migrations();
        if ($migrations->migrate()) {
            Cache::clear();

            die('Migrations runned successfully');
        } else {
            die('Migrations failed!');
        }
    }
}
