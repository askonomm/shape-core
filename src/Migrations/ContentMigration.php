<?php

namespace Asko\Shape\Core\Migrations;

use Illuminate\Database\Capsule\Manager as Database;

class ContentMigration
{
    public function __construct()
    {
        $schema = Database::schema();

        if (!$schema->hasTable("content")) {
            $schema->create("content", function ($table) {
                $table->increments("id");
                $table->timestamps();
            });
        }
    }
}
