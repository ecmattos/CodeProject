<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectNote;
use League\Fractal\TransformerAbstract;

class ProjectNoteTransformer extends TransformerAbstract
{
	public function transform(ProjectNote $project_note)
	{
		return [
			'note_id'		=> $project_note->id,
			'project_id' 	=> $project_note->project_id,
			'title'			=> $project_note->title,
			'note'			=> $project_note->note
		];
	}
}