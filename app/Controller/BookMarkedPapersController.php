<?php
App::uses('AppController', 'Controller');
/**
 * BookMarkedPapers Controller
 *
 * @property BookMarkedPaper $BookMarkedPaper
 * @property PaginatorComponent $Paginator
 */
class BookMarkedPapersController extends AppController {

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
		$this->BookMarkedPaper->recursive = 0;
		$this->set('bookMarkedPapers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->BookMarkedPaper->exists($id)) {
			throw new NotFoundException(__('Invalid book marked paper'));
		}
		$options = array('conditions' => array('BookMarkedPaper.' . $this->BookMarkedPaper->primaryKey => $id));
		$this->set('bookMarkedPaper', $this->BookMarkedPaper->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->BookMarkedPaper->create();
			if ($this->BookMarkedPaper->save($this->request->data)) {
				$this->Flash->success(__('The book marked paper has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The book marked paper could not be saved. Please, try again.'));
			}
		}
		$papers = $this->BookMarkedPaper->Paper->find('list');
		$users = $this->BookMarkedPaper->User->find('list');
		$this->set(compact('papers', 'users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->BookMarkedPaper->exists($id)) {
			throw new NotFoundException(__('Invalid book marked paper'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->BookMarkedPaper->save($this->request->data)) {
				$this->Flash->success(__('The book marked paper has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The book marked paper could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('BookMarkedPaper.' . $this->BookMarkedPaper->primaryKey => $id));
			$this->request->data = $this->BookMarkedPaper->find('first', $options);
		}
		$papers = $this->BookMarkedPaper->Paper->find('list');
		$users = $this->BookMarkedPaper->User->find('list');
		$this->set(compact('papers', 'users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->BookMarkedPaper->id = $id;
		if (!$this->BookMarkedPaper->exists()) {
			throw new NotFoundException(__('Invalid book marked paper'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->BookMarkedPaper->delete()) {
			$this->Flash->success(__('The book marked paper has been deleted.'));
		} else {
			$this->Flash->error(__('The book marked paper could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->BookMarkedPaper->recursive = 0;
		$this->set('bookMarkedPapers', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->BookMarkedPaper->exists($id)) {
			throw new NotFoundException(__('Invalid book marked paper'));
		}
		$options = array('conditions' => array('BookMarkedPaper.' . $this->BookMarkedPaper->primaryKey => $id));
		$this->set('bookMarkedPaper', $this->BookMarkedPaper->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->BookMarkedPaper->create();
			if ($this->BookMarkedPaper->save($this->request->data)) {
				$this->Flash->success(__('The book marked paper has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The book marked paper could not be saved. Please, try again.'));
			}
		}
		$papers = $this->BookMarkedPaper->Paper->find('list');
		$users = $this->BookMarkedPaper->User->find('list');
		$this->set(compact('papers', 'users'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->BookMarkedPaper->exists($id)) {
			throw new NotFoundException(__('Invalid book marked paper'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->BookMarkedPaper->save($this->request->data)) {
				$this->Flash->success(__('The book marked paper has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The book marked paper could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('BookMarkedPaper.' . $this->BookMarkedPaper->primaryKey => $id));
			$this->request->data = $this->BookMarkedPaper->find('first', $options);
		}
		$papers = $this->BookMarkedPaper->Paper->find('list');
		$users = $this->BookMarkedPaper->User->find('list');
		$this->set(compact('papers', 'users'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->BookMarkedPaper->id = $id;
		if (!$this->BookMarkedPaper->exists()) {
			throw new NotFoundException(__('Invalid book marked paper'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->BookMarkedPaper->delete()) {
			$this->Flash->success(__('The book marked paper has been deleted.'));
		} else {
			$this->Flash->error(__('The book marked paper could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function getBookMarkedPapers(){
		if($this->request->is('post')){
			$this->autoRender = false;
			$papers = $this->BookMarkedPaper->find('all',array('conditions' => array('BookMarkedPaper.user_id'=>22)));
			
			$sanitizedData = [];

			for($i = 0; $i < count($papers); $i++){
				array_push($sanitizedData,$papers[$i]['ResearchPaper']);
			}

			echo json_encode ($sanitizedData);
		}
	}

	public function deleteBookMark(){
		if($this->request->is('post')){
			$this->autoRender = false;
			$id = $this->request->data('id');
			$paper = $this->BookMarkedPaper->find('first',array('conditions' => array('BookMarkedPaper.user_id'=>22,'BookMarkedPaper.paper_id'=>$id)));
			$id = $paper['BookMarkedPaper']['id'];
			if($this->BookMarkedPaper->delete($id))
				echo 1;
		}
	}

	public function addBookmark(){
		if($this->request->is('post')){
			$this->autoRender = false;
			$paper_id = $this->request->data('paper_id');
			$data = array('paper_id'=>$paper_id ,'user_id'=>22);
			if($this->BookMarkedPaper->save($data))
				echo 1;
		}
	}
}
