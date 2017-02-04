<?php

namespace Modules\Questions\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface QuestionsRepository extends BaseRepository
{
	public function catfilter($catid);

	public function myfilter($userid);
}
