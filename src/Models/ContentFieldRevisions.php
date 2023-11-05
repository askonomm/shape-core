<?php

namespace Asko\Shape\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentFieldRevisions extends Model
{
    protected $table = "content_field_revisions";

    public function field(): BelongsTo
    {
        return $this->belongsTo(ContentField::class);
    }
}
