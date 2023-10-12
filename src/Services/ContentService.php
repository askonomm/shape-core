<?php

namespace Asko\Shape\Core\Services;

use Asko\Shape\Core\ContentField;
use Asko\Shape\Core\ContentTypes;
use Asko\Shape\Core\Models\Content;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Eloquent\Builder;

class ContentService
{
    private string $identifier;
    private Builder $builder;

    /**
     * @param string $identifier
     * @param string|null $sort_by
     * @param string $order
     * @return ContentService
     */
    public function query(string $identifier, ?string $sort_by = null, string $order = "desc"): ContentService
    {
        if ($sort_by) {
            $this->builder = Content::where("content.identifier", $identifier)
                ->leftJoin("content_fields", function(JoinClause $join) use($sort_by) {
                    $join
                        ->on("content.id", "=", "content_fields.content_id")
                        ->where("content_fields.identifier", $sort_by);
                })
                ->select("content.*", "content_fields.*")
                ->orderBy("content_fields.value", strtoupper($order));
        }

        $this->identifier = $identifier;
        $this->builder = Content::where("content.identifier", $identifier);

        return $this;
    }

    public function attachFields(): ContentService
    {
        $this->builder = $this->builder->with("fields");

        return $this;
    }

    public function get(): array|Collection
    {
        return $this->builder->get();
    }
}