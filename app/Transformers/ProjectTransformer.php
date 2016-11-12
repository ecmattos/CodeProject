<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{
	public function transform(Project $project)
	{
		return [
			'id' 			=> $project->id,
			'name' 			=> $project->name,
			'owner_id' 		=> $project->owner_id,
			'client_id' 	=> $project->client->id,
			'client_name' 	=> $project->client->name,
			'description' 	=> $project->description,
			'progress' 		=> $project->progress,
			'status' 		=> $project->status,
			'due_date' 		=> $project->due_date
		];
	}
}