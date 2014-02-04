<?php
	/**
	* 
	*/
	class UpLoadsController extends AppController
	{
		private $connection = null;
		private $userCollection = null;
		public function beforeFilter()
		{
			parent::beforeFilter();
			//$this->checkSession();
			$this->connection = new Mongo();
			$this->userCollection = $this->connection->moiter->users;
		}
		public function upload()
		{
			$this->set('code', 0);
			if(isset($_FILES['avatar']))			
			{				
				$user = $this->Session->read('User');
				$typeArray =  array('jpg','jpeg','png','bmp','gif');
				$type = explode('.',$_FILES["avatar"]["name"]);
				$index = count($type)-1;
				$type = $type[$index];
				if(!in_array($type,$typeArray))
				{
					$this->set('code',1);
				}
				else if($_FILES["avatar"]["size"] >= 300000)
				{
					$this->set('code',2);
				}
				else if($_FILES["avatar"]["error"]>0)
				{
					$this->set('code',3);
					$this->set("error",$_FILES["avatar"]["error"]);
				}
				else
				{
					$this->set('code',4);
					$_FILES['avatar']['name'] = $user['user_id'].".".$type;
					foreach($typeArray as $t)
					{
						if(file_exists("upload/".$user['user_id'].".".$t))
						{
							unlink("upload/".$user['user_id'].".".$t);
						}
					}
					move_uploaded_file($_FILES['avatar']['tmp_name'], "upload/".$_FILES['avatar']['name']);	
					$dest = "upload/".$user['user_id'].".".$type;
					$this->userCollection->update(array('_id'=>$user['user_id']),array('$set'=>array('pic_url'=>$dest)));
					$this->Session->write('User',array('user_id'=>$user['user_id'],'userName'=>$user['userName'],'pic_url'=>$dest,'authority'=>$user['authority'],'email'=>$user['email']));
				}			
			}			
		}
	}
?>