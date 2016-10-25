<?php
App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
/**
 * BlogPosts Controller
 *
 * @property BlogPost $BlogPost
 * @property PaginatorComponent $Paginator
 */
class BlogPostsController extends AppController {

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
		$this->BlogPost->recursive = 0;
		$this->set('blogPosts', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->BlogPost->exists($id)) {
			throw new NotFoundException(__('Invalid blog post'));
		}
		$options = array('conditions' => array('BlogPost.' . $this->BlogPost->primaryKey => $id));
		$this->set('blogPost', $this->BlogPost->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->BlogPost->create();
			if ($this->BlogPost->save($this->request->data)) {
				$this->Flash->success(__('The blog post has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The blog post could not be saved. Please, try again.'));
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
		if (!$this->BlogPost->exists($id)) {
			throw new NotFoundException(__('Invalid blog post'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->BlogPost->save($this->request->data)) {
				$this->Flash->success(__('The blog post has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The blog post could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('BlogPost.' . $this->BlogPost->primaryKey => $id));
			$this->request->data = $this->BlogPost->find('first', $options);
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
		$this->BlogPost->id = $id;
		if (!$this->BlogPost->exists()) {
			throw new NotFoundException(__('Invalid blog post'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->BlogPost->delete()) {
			$this->Flash->success(__('The blog post has been deleted.'));
		} else {
			$this->Flash->error(__('The blog post could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->BlogPost->recursive = 0;
		$this->set('blogPosts', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->BlogPost->exists($id)) {
			throw new NotFoundException(__('Invalid blog post'));
		}
		$options = array('conditions' => array('BlogPost.' . $this->BlogPost->primaryKey => $id));
		$this->set('blogPost', $this->BlogPost->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->BlogPost->create();
			if ($this->BlogPost->save($this->request->data)) {
				$this->Flash->success(__('The blog post has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The blog post could not be saved. Please, try again.'));
			}
		}
	}



	public function getImageNames(){
		$this->autoRender = false;
		
		if ($this->request->is('post')) {
			
				$dir = new Folder(WWW_ROOT . 'img/user/');
				$files = $dir->find('.*', true);

				echo json_encode($files);
		}
	}






	public function uploadImage(){
		$this->autoRender = false;
		$target_dir = "img/user/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		    if($check !== false) {
		        echo "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		// Check if file already exists
		if (file_exists($target_file)) {
		    echo "Sorry, file already exists.";
		    $uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
		    echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		    } else {
		        echo "Sorry, there was an error uploading your file.";
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
		if (!$this->BlogPost->exists($id)) {
			throw new NotFoundException(__('Invalid blog post'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->BlogPost->save($this->request->data)) {
				$this->Flash->success(__('The blog post has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The blog post could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('BlogPost.' . $this->BlogPost->primaryKey => $id));
			$this->request->data = $this->BlogPost->find('first', $options);
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
		$this->BlogPost->id = $id;
		if (!$this->BlogPost->exists()) {
			throw new NotFoundException(__('Invalid blog post'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->BlogPost->delete()) {
			$this->Flash->success(__('The blog post has been deleted.'));
		} else {
			$this->Flash->error(__('The blog post could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
