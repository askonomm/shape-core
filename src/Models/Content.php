<?php

namespace Asko\Shape\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Content extends Model
{
    protected $table = "content";

    public function fields(): HasMany
    {
        return $this->hasMany(ContentField::class);
    }
}
