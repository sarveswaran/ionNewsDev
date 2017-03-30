<?php

namespace Modules\Content\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface ContentRepository extends BaseRepository
{
	public function filter($field,$value);
}
