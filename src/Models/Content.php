<?php

namespace Asko\Shape\Core\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $identifier
 * @property int $id
 * @method where(string $string, string $content_type)
 */
class Content extends Model
{
    protected $table = "content";

    public function fields()
    {
        return $this->hasMany(ContentField::class);
    }
}
