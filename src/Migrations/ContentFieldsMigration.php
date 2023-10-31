<?php

namespace Asko\Shape\Core\Migrations;

use Illuminate\Database\Capsule\Manager as Database;
use Asko\Shape\Core\Models\Content;

class ContentFieldsMigration
{
    public function __construct()
    {
        $schema = Database::schema();

        if (!$schema->hasTable("content_fields")) {
            $schema->create("content_fields", function ($table) {
                $table->increments("id");
                $table->foreignIdFor(Content::class);
                $table->string("identifier");
                $table->text("value");
                $table->timestamps();
            });
        }
    }
}
