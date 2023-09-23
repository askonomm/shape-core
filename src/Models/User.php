<?php

namespace Asko\Shape\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as Database;

class User extends Model
{
    protected $table = "users";

    protected static function booted(): void
    {
        $schema = Database::schema();

        if (!$schema->hasTable('users')) {
            $schema->create('users', function ($table) {
                $table->increments('id');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->timestamps();
            });
        }
    }
}
