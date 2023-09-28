<?php

namespace Asko\Shape\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = "content";

    public function fields()
    {
        return $this->hasMany(ContentField::class);
    }
}
