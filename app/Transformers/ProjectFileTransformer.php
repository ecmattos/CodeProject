<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectFile;
use League\Fractal\TransformerAbstract;

class ProjectFileTransformer extends TransformerAbstract
{
	public function transform(ProjectFile $project_file)
	{
		return [
			'file_id'		=> $project_file->id,
			'name'			=> $project_file->name,
    		'project_id' 	=> $project_file->project_id,
    		'description' 	=> $project_file->description,
    		'extension' 	=> $project_file->extension
		];
	}
}