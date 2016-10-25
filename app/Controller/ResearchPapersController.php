<?php
App::uses('AppController', 'Controller');
/**
 * ResearchPapers Controller
 *
 * @property ResearchPaper $ResearchPaper
 * @property PaginatorComponent $Paginator
 */
class ResearchPapersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ResearchPaper->recursive = 0;
		$this->set('researchPapers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ResearchPaper->exists($id)) {
			throw new NotFoundException(__('Invalid research paper'));
		}
		$options = array('conditions' => array('ResearchPaper.' . $this->ResearchPaper->primaryKey => $id));
		$this->set('researchPaper', $this->ResearchPaper->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ResearchPaper->create();
			if ($this->ResearchPaper->save($this->request->data)) {
				$this->Flash->success(__('The research paper has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The research paper could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->ResearchPaper->exists($id)) {
			throw new NotFoundException(__('Invalid research paper'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ResearchPaper->save($this->request->data)) {
				$this->Flash->success(__('The research paper has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The research paper could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ResearchPaper.' . $this->ResearchPaper->primaryKey => $id));
			$this->request->data = $this->ResearchPaper->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->ResearchPaper->id = $id;
		if (!$this->ResearchPaper->exists()) {
			throw new NotFoundException(__('Invalid research paper'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ResearchPaper->delete()) {
			$this->Flash->success(__('The research paper has been deleted.'));
		} else {
			$this->Flash->error(__('The research paper could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->ResearchPaper->recursive = 0;
		$this->set('researchPapers', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->ResearchPaper->exists($id)) {
			throw new NotFoundException(__('Invalid research paper'));
		}
		$options = array('conditions' => array('ResearchPaper.' . $this->ResearchPaper->primaryKey => $id));
		$this->set('researchPaper', $this->ResearchPaper->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->ResearchPaper->create();
			if ($this->ResearchPaper->save($this->request->data)) {
				$this->Flash->success(__('The research paper has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The research paper could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->ResearchPaper->exists($id)) {
			throw new NotFoundException(__('Invalid research paper'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ResearchPaper->save($this->request->data)) {
				$this->Flash->success(__('The research paper has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The research paper could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ResearchPaper.' . $this->ResearchPaper->primaryKey => $id));
			$this->request->data = $this->ResearchPaper->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->ResearchPaper->id = $id;
		if (!$this->ResearchPaper->exists()) {
			throw new NotFoundException(__('Invalid research paper'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ResearchPaper->delete()) {
			$this->Flash->success(__('The research paper has been deleted.'));
		} else {
			$this->Flash->error(__('The research paper could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}


	public function getPapers(){
		if($this->request->is('post')){
			$this->autoRender = false;
			$geneName = $this->request->data['geneName'];
			$start = $this->request->data['offset'];
			$papers = $this->ResearchPaper->find('all',array(
			                                     'limit' => 20,
			                                      'offset'=>$start,
			                                      'conditions'=>array('ResearchPaper.gene LIKE'=> $geneName.'%')			                                    ));
			$sanitizedData = [];

			for($i = 0; $i < count($papers); $i++){
				array_push($sanitizedData,$papers[$i]['ResearchPaper']);
			}

			echo json_encode ($sanitizedData);
		}
	}


	public function getPaperById(){
		if($this->request->is('post')){
			$this->autoRender = false;
			$id = $this->request->data['id'];
			$paper = $this->ResearchPaper->find('first',array('conditions'=>array('ResearchPaper.id'=> $id)));
			

			echo json_encode ($paper['ResearchPaper']);
		}
	}


	public function getPaperCount(){
		if($this->request->is('post')){
			$this->autoRender = false;
			$geneName = $this->request->data['geneName'];
			$fieldName = $this->request->data['fieldName']; 
			$papers = $this->ResearchPaper->find('all',array(
			                                      'conditions'=>array('ResearchPaper.gene LIKE'=> $geneName.'%')
			                                    ));
			$data = array();
			for($i = 0; $i < count($papers); $i++){
				if(array_key_exists($papers[$i]['ResearchPaper'][$fieldName],$data)){
					$key = $papers[$i]['ResearchPaper'][$fieldName];
					$data[$key]++;
				}else{
					$key = $papers[$i]['ResearchPaper'][$fieldName];
					$data[$key] = 1;
				}
			}

			echo json_encode($data);
		}	
	}
}
