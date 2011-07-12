<?php
/**
 * @author http://labs.iamkoa.net/2007/10/23/image-upload-component-cakephp/
 * @edited Michael Pontin
 * @edited David Couch - added validation for files
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 */
class ImagesController extends AppController {

	var $name = 'Images';
	var $helpers = array('Html', 'Form');
	var $components = array('Upload');
	/**
	* uploads a image file
	*/
	function upload($fileName=NULL, $checkSize=NULL) {
		$this->layout = 'ajax';
		parent::correctLogin();
		if (empty($this->data)) {
			$this->render();
		} else {
	//			$this->cleanUpFields();

			// set the upload destination folder
			$destination = realpath('../../app/webroot/img/uploads/') . '/';
			$size = 2000; //max size of an upload
			$fileType = array('image/jpg', 'image/jpeg', 'image/gif','image/png','image/pjpeg'); //the type of file allowed
			
			// grab the file		
			$file = $this->data['Image']['image'];
			
			/*
			$str_array = explode('.', $this->data['Image']['name']);
			$str_ext = array_pop($bla);
			$valid_ext = array('jpg','jpeg','gif','png','pjpeg');
			
			print_r($str_array);
			echo '<br>'.$str_ext;
			echo '<br>';
			print_r($valid_ext);
			die();
			if(in_array(strtolower($str_ext),$valid_ext)){ 
				$this->Session->setFlash('Image could not be uploaded due to unrecognised extention.');
				$this->redirect('/profile/'.$this->Session->read('ident'));
				exit;
			
			}
			*/
			
			// upload the image using the upload component
    		$idid = $this->Session->read('ident');//add the identityid to the db
			$result = $this->Upload->upload($file, $destination, null, array('type' => 'resizecrop', 'size' => array('150', '150'), 'output' => 'jpg'));
			
			if($result){
				$this->data['Image']['name'] = $this->Upload->result;
				$this->data['Image']['identity_id'] = $idid;
				$this->data['Image']['added'] = date('Y-m-d H:i');
			} else {
				// display error
				$errors = $this->Upload->errors;
   
				// piece together errors
				if(is_array($errors)){ $errors = implode("<br />",$errors); }
   
					$this->Session->setFlash($errors);
					$this->redirect('/profile/'.$this->Session->read('ident'));

					exit();
				}
				
			if ($this->Image->save($this->data)) {
				$this->Session->setFlash('Image has been added.');
				$this->redirect('/profile/'.$this->Session->read('ident'));
				exit;
			} else {
				$this->Session->setFlash('Please correct errors below.');
				unlink($destination.$this->Upload->result);
			}
		}
	}
	
	/**
	 * Deletes a specified image
	 */
	function delete($id = null)
	{
		parent::correctLogin();
		$destination = realpath('../../app/webroot/img/uploads/') . '/';
		$id = $this->params['pass'][0];
		$image = $this->Image->findById($id);
		unlink($destination.$image['Image']['name']);
		$this->Image->delete($id);
		$this->Session->setFlash('Your image has been deleted.');            
		$this->redirect('/identities/index/'.$this->Session->read('ident'));     
	}
}
