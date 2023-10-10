<?php

namespace Asko\Shape\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method where(string $string, int|string $field_identifier)
 * @property int $content_id
 * @property string $identifier
 * @property string $value
 */
class ContentField extends Model
{
    protected $table = "content_fields";

    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }
}
