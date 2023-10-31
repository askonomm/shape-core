<?php

namespace Asko\Shape\Core\Migrations;

use Illuminate\Database\Capsule\Manager as Database;

class UsersMigration
{
    public function __construct()
    {
        $schema = Database::schema();

        if (!$schema->hasTable("users")) {
            $schema->create("users", function ($table) {
                $table->increments("id");
                $table->string("name");
                $table->string("email")->unique();
                $table->string("password");
                $table->string("auth_token")->nullable();
                $table->string("remember_token")->nullable();
                $table->timestamps();
            });
        }
    }
}
