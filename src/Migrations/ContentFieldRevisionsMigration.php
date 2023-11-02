<?php

namespace Asko\Shape\Core\Migrations;

use Illuminate\Database\Capsule\Manager as Database;
use Asko\Shape\Core\Models\ContentField;

class ContentFieldRevisionsMigration
{
	public function __construct()
	{
		$schema = Database::schema();

		if (!$schema->hasTable("content_field_revisions")) {
			$schema->create("content_field_revisions", function ($table) {
				$table->increments("id");
				$table->foreignIdFor(ContentField::class);
				$table->text("value");
				$table->timestamps();
			});
		}
	}
}
  
