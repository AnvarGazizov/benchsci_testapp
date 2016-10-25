<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * User Model
 *
 */
class User extends AppModel {

		public $validate = array(
		        'username' => array(
		            'required' => array(
		                'rule' => 'notBlank',
		                'message' => 'A username is required'
		            )
		        ),
		        'password' => array(
		            'required' => array(
		                'rule' => 'notBlank',
		                'message' => 'A password is required'
		            )
		        )
		    );


		
	    public function beforeSave($options = array()) {
			if (isset($this->data[$this->alias]['password'])) {
				$passwordHasher = new BlowfishPasswordHasher();
				$this->data[$this->alias]['password'] = $passwordHasher->hash(
					$this->data[$this->alias]['password']
				);
	            return true;
			}
	        // prevent orphaned records
	        if(!$this->exists()){
	            return false;
	        }
			return true;
		}

}


