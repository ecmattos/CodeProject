<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectTask;
use League\Fractal\TransformerAbstract;

class ProjectTaskTransformer extends TransformerAbstract
{
	public function transform(ProjectTask $project_task)
	{
		return [
			'task_id'		=> $project_task->id,
			'name'			=> $project_task->name,
    		'project_id' 	=> $project_task->project_id,
    		'start_date' 	=> $project_task->start_date,
    		'due_date' 		=> $project_task->due_date,
    		'status' 		=> $project_task->status
		];
	}
}