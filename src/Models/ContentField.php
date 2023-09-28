<?php

namespace Asko\Shape\Core\Models;

use Illuminate\Database\Eloquent\Model;

class ContentField extends Model
{
    protected $table = "content_fields";

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
