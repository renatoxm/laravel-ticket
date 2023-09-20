<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | You can change the models if you need customization.
    |
    */
    'model' => [
        'category' => Renatoxm\LaravelTicket\Models\Category::class,
        'label'    => Renatoxm\LaravelTicket\Models\Label::class,
        'comment'  => Renatoxm\LaravelTicket\Models\Comment::class,
        'ticket'   => Renatoxm\LaravelTicket\Models\Ticket::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Tables Names
    |--------------------------------------------------------------------------
    |
    | You can change the table names depends on your application structure
    | the values in the below tables, is the current table name, and if
    | are happy with it, leave it as it is, if not. You may read the related
    | instruction before you change the values.
    |
    */
    'table_names' => [
        /**
         * Tickets table.
         */
        'tickets' => 'tickets',
        /**
         * Categories table for the tickets.
         */
        'categories' => 'categories',
        /**
         * Labels table for the tickets.
         */
        'labels' => 'labels',
        /**
         * Owners table for the ticketables.
         */
        'ticketables' => [
            'table' => 'ticketables',
            /**
             * This is the foreing key for associated to the ticket
             * If you renamed the ticket table, you should consider
             * changing this column as well to follow the laravel
             * convention, "table_id".
             *
             * @see https://laravel.com/docs/9.x/eloquent-relationships#one-to-many
             */
            'columns' => [
                'ticketable_id'     => 'ticketable_id',
                'ticketable_type'   => 'ticketable_type',
                'ticket_foreing_id' => 'ticket_id',
            ],
        ],
        /**
         * Ticket comments.
         */
        'comments' => [
            'table' => 'comments',
            /**
             * This is the foreing key for associated to the ticket
             * If you renamed the ticket table, you should consider
             * changing this column as well to follow the laravel
             * convention, "table_id".
             *
             * @see https://laravel.com/docs/9.x/eloquent-relationships#one-to-many
             */
            'columns' => [
                'user_foreing_id'   => 'user_id',
                'ticket_foreing_id' => 'ticket_id',
            ],
        ],
        /**
         * Many to Many relationship between the tickets table
         * and the labels table, if you changed the one of the
         * tables above, you may consider change the columns
         * below.
         *
         * @see https://laravel.com/docs/9.x/eloquent-relationships#many-to-many
         */
        'label_ticket' => [
            'table'   => 'label_ticket',
            'columns' => [
                'label_foreign_id'  => 'label_id',
                'ticket_foreign_id' => 'ticket_id',
            ],
        ],
        /**
         * Many to Many relationship between the tickets table
         * and the categories table, the above description, applies
         * to this also.
         *
         * @see https://laravel.com/docs/9.x/eloquent-relationships#many-to-many
         */
        'category_ticket' => [
            'table'   => 'category_ticket',
            'columns' => [
                'category_foreign_id' => 'category_id',
                'ticket_foreign_id'   => 'ticket_id',
            ],
        ],
    ],

];
