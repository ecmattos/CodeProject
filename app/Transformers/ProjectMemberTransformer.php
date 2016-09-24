<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectMember;
use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract
{
	public function transform(ProjectMember $project_member)
	{
		return [
			'project_id' 	=> $project_member->project_id,
			'member_id' 	=> $project_member->member_id
		];
	}
}