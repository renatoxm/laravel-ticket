<?php

namespace Renatoxm\LaravelTicket\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as Orchestra;
use Renatoxm\LaravelTicket\LaravelTicketServiceProvider;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('app.key', '6rE9Nz59bGRbeMATftriyQjrpF7DcOQm');

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Renatoxm\\LaravelTicket\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelTicketServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migrations = [
            include __DIR__.'/../database/migrations/create_tickets_table.php.stub',
            include __DIR__.'/../database/migrations/create_categories_table.php.stub',
            include __DIR__.'/../database/migrations/create_comments_table.php.stub',
            include __DIR__.'/../database/migrations/create_labels_table.php.stub',
            include __DIR__.'/../database/migrations/create_ticketables_table.php.stub',

            // Many to Many tables
            include __DIR__.'/../database/migrations/create_label_ticket_table.php.stub',
            include __DIR__.'/../database/migrations/create_category_ticket_table.php.stub',

            // Tests Migration
            include __DIR__.'/Database/Migrations/create_users_table.php',
        ];

        collect($migrations)->each(fn ($migration) => $migration->up());
    }
}
