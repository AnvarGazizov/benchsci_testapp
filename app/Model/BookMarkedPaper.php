<?php
App::uses('AppModel', 'Model');
/**
 * BookMarkedPaper Model
 *
 * @property ResearchPaper $ResearchPaper
 */
class BookMarkedPaper extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ResearchPaper' => array(
			'className' => 'ResearchPaper',
			'foreignKey' => 'paper_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
