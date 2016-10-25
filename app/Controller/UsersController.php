<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
define('__ROOT__', dirname(dirname(dirname(__FILE__)))); 
App::import('Vendor', 'ImageManipulator');
require __ROOT__.'/vendors/autoload.php';
use Mailgun\Mailgun;

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				return $this->flash(__('The user has been saved.'), array('action' => 'index'));
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
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				return $this->flash(__('The user has been saved.'), array('action' => 'index'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			return $this->flash(__('The user has been deleted.'), array('action' => 'index'));
		} else {
			return $this->flash(__('The user could not be deleted. Please, try again.'), array('action' => 'index'));
		}
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

	public function login(){
		if ($this->request->is('post')) {
			$this->autoRender = false;
			$user = $this->User->find('first', array('conditions' => array('username' => $this->request->data['username'])));
			if(!empty($user)){
				$this->User->id = $user['User']['id'];
				$this->User->set('password', $this->request->data['password']);
				if ($this->User->validates()) {
					if($this->Auth->login($user)){
						$this->Session->write('Auth', $this->User->read(null, $this->Auth->User('id')));
			    		echo "Login Successfull";
			    	}	
			    	else
			    		echo "Login Failed";
			    }else{
			    	echo "Login Failed";
			    }
			}
			else{
				echo "Login Failed";
			} 
		}

	}

	public function logout(){
		$this->autoRender = false;
		$this->redirect($this->Auth->logout());
	}





	// function to create a new account using an ajax call
	public function signup() {
		$this->autoRender = false;
		if ($this->request->is('post')) {
			
			$this->User->create();
			$token  = Security::hash($this->request->data['email'].rand(0,100), 'sha1', true);
			$password = $this->request->data['password'];
			$email = $this->request->data['email'];




			$userData = array(
			    'User' => array(
			        'username' => $email,
			        'password'=> $password, 
			        'token'=> $token
			    )
			);

			$options = array('conditions' => array('User.username' => $email));
			$user = $this->User->find('first', $options);

			if($user){
				echo "USER_EXISTS";
				return;
			}

			if ($this->User->save($userData)) {


				$link = array('controller'=>'users','action'=>'activate', $this->User->id.'-'.$token);

				echo "SUCCESS";


			} else {
				echo "FAIL";
			}

		}
	}	

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				return $this->flash(__('The user has been saved.'), array('action' => 'index'));
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
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				return $this->flash(__('The user has been saved.'), array('action' => 'index'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}



		 



	public function profileView(){
		$userName = $this->Auth->user('username');
		$userImageURL = $this->Auth->user('image_url');
		$userId= $this->Auth->user('id');
		$address= $this->Auth->user('address');
		$this->set(compact('userName','userImageURL','userId','address'));
	}


	public function updateAddress(){
		$this->autoRender = false;
		if($this->request->is('post')){
			$data = array('id' => $this->Auth->user('id'), 'address' => $this->request->data['address']);
			if($this->User->save($data)){
				$this->Session->write('Auth', $this->User->read(null, $this->Auth->User('id')));
				echo "SUCCESS";
			}
			else{
				echo "FAIL";
			}

		}
	}	


	public function beforeFilter() {
	    parent::beforeFilter();
	    // Allow users to register and logout.
	    $this->Auth->allow('logout','login');
	}




	public function saveTempImage(){
		$this->autoRender = false;
		if($this->request->is('post')){

			$user_id = $this->Auth->user('id');
			$ifp = fopen("img/"."tempUserPicture".$user_id."."."jpg", "wb");

			$data = explode(',', $this->request->data['imageFile']);

			fwrite($ifp, base64_decode($data[1]));
			fclose($ifp);

			ini_set('memory_limit', -1);
			$img = imagecreatefromjpeg("img/"."tempUserPicture".$user_id."."."jpg");   // load the image-to-be-saved


			if(!empty($this->request->data['Orientation'])){
				// File and rotation
				$degrees = 0;
				switch($this->request->data['Orientation'])
				{

					case 3: // 180 rotate left
					   $degrees =  180;
						break;
					case 6: // 90 rotate right
						$degrees =  -90;
						break;

					case 8:    // 90 rotate left
						$degrees = 90;
						break;
				  }
				// Rotate
				$rotate = imagerotate($img, $degrees, 0);

				// Output
			   imagejpeg($rotate,"img/"."tempUserPicture".$user_id."."."jpg",50);

			}
			else{
				imagejpeg($img,"img/"."tempUserPicture".$user_id."."."jpg",50);
			}
			echo "SUCCESS";
		}
	}



	public function cropPhoto(){
		$this->autoRender = false;
		if($this->request->is('post')){
			//Convert uploaded image file to jpeg
			$user_id = $this->Auth->user('id');
			ini_set('memory_limit', -1);
			//Prepare the co-ordinates for the image manipulator
			$x1 = $this->request->data['coOrdinatesX'];
			$x2 = $this->request->data['coOrdinatesX'] + $this->request->data['coOrdinatesWidth'];
			$y1 = $this->request->data['coOrdinatesY'];
			$y2 = $this->request->data['coOrdinatesY'] + $this->request->data['coOrdinatesHeight'];
			//Instantiate manipulator
			print_r($this->request->data);
			$manipulator = new ImageManipulator("img/"."tempUserPicture".$user_id."."."jpg");
			//Crop image
			$manipulator->crop($x1, $y1, $x2, $y2);
			//Resize image to 84x84
			$manipulator->resample(84, 84,true);
			$manipulator->save("img/"."user".$user_id."."."jpg");
			$this->User->id = $user_id;
			$this->User->saveField("image_url","user".$user_id."."."jpg");
		
			unlink("img/"."tempUserPicture".$user_id."."."jpg");
			//$this->_refreshAuth();
			//Send SUCCESS message if no errors occurred
			echo "SUCCESS";
			echo "\n";

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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			return $this->flash(__('The user has been deleted.'), array('action' => 'index'));
		} else {
			return $this->flash(__('The user could not be deleted. Please, try again.'), array('action' => 'index'));
		}
	}


	public function isAuthorized($user) {
	    // The owner of a post can edit and delete it
	    if (in_array($this->action, array('profileView', 'logout','cropPhoto','login','saveTempImage','signup','updateAddress','testEmail'))) {
	            return true;
	    }

	    return parent::isAuthorized($user);
	}

	public function sendEmail($emailTo, $subject, $template, $viewVars, $user) {
	    
	   	$this->autoRender = false;
	        $email = new CakeEmail();
	        $email->config('gmail')
	            ->from(array('noreply@smartbrainaging.com' => 'info@smartbrainaging.com'))
	            ->to($emailTo)
	            ->subject($subject)
	            ->emailFormat('html')
	            ->template($template, 'activate')
	            ->viewVars($viewVars)
	            ->send();
	}



	public function testEmail(){
		$this->autoRender = false;
		$this->sendEmail(
		    'a.f.gazizov@gmail.com',
		    'Complete SMART Brain U Registration',
		    'activate',
		    array(),
		    $this->Auth->user()
		);
	}

	
}