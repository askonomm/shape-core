<?php

namespace Asko\Shape\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentField extends Model
{
    protected $table = "content_fields";

    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }
}
