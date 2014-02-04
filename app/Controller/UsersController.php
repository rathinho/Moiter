<?php
	
	/**
	* 
	*/
	class UsersController extends AppController
	{
		private $userCursor = null;
		private $connection = null;
		private $projectCollection = null;
		private $stageCollection = null;
		public function beforeFilter()
		{
			parent::beforeFilter();
			$this->connection = new Mongo();
			$this->userCursor = $this->connection->moiter->users;
			$this->projectCollection = $this->connection->moiter->projects;
			$this->stageCollection = $this->connection->moiter->stages;
		}
		public function afterFilter()
		{
			$this->connection->close();
		}

		public function index()
		{
			// $this->checkSession();
			$cursor = $this->userCursor->find();
			$users = array();
			while($data = $cursor->getNext())
			{
				$users[] = $data;
			}
			$this->set('users',$users);
		}
		public function view($user_id = null)
		{
			// $this->checkSession();
			$userData = $this->userCursor->findOne(array('_id'=>$user_id));
			if(isset($userData))
			{
				$this->set('user',$userData);
				
				$projects_id = array();
				$tasks_id = array();
				$projects_name = array();
				foreach($userData['project_task_id'] as $project_task_id)
				{
					$idSplit = explode("#",$project_task_id);
					$projects_id[$idSplit[1]] = $idSplit[1];
					$projects_name[$idSplit[1]] = $idSplit[0];
					$tasks_id[$idSplit[1]][] = $idSplit[2];

				}
				// print_r($tasks_id);
				// $tmpTask = $this->stageCollection->find(array('_id' => $stage_id), array('task'=>array('$elemMatch'=>array('task_id'=>$task_id))));
				$tasks = array();
				foreach ($projects_id as $p_id) {

					$cursor = $this->stageCollection->find(array('project_id'=>$p_id),array('task'=>1,'leader'=>1));
					while($cursor->hasNext())
					{
						$stage = $cursor->getNext();

						foreach ($stage['task'] as $atask) {
							# code...

							foreach ($tasks_id[$p_id] as $t_id) {
								# code...
		
								if($atask['task_id'] == $t_id){
									$atask['name'] = $projects_name[$p_id];
									// print_r($atask);
									$atask['stage_id'] = $stage['_id'];
									$atask['project_leader'] = $stage['leader'];
									$tasks[] = $atask;
								}
							}
						}
					}

				}
				$this->set('tasks',$tasks);
			}
			else
			{
				$this->redirect('/users/index');
				exit();			
			}
		}
		
		public function edit()
		{
			$user = $this->Session->read('User');
			$userData = $this->userCursor->findOne(array('_id'=>$user['user_id']));
			$back  = array('name'=>$userData['name'],'tel'=>$userData['tel'],'email'=>$userData['email'],'company'=>$userData['company'],'position'=>$userData['position']);
			$this->set('back',$back);
			$this->set('update',false);
			if(!empty($_POST))
			{
				
				$user = $this->Session->read('User');
				$this->userCursor->update(array('_id'=>$user['user_id']),array('$set'=>$_POST));
				$tmp = $this->userCursor->findOne(array('_id'=>$user['user_id'],'tel'=>$_POST['tel'],'email'=>$_POST['email'],'company'=>$_POST['company'],'position'=>$_POST['position']));
				if(isset($tmp))
				{
					$this->set('update',true);
					$this->set('back',$tmp);				
				}
			}
		}
		public function logout()
		{			
			$this->Session->delete('User');
			$this->redirect('/users/login');			
		}
		public function management()
		{
			$user = $this->Session->read('User');
			if($user['authority'] != 1)
			{
				$this->redirect('/users/index');
				exit();				
			}
		}
		public function modifyAuthority($user_id = null , $authority = null)
		{
			$user = $this->Session->read('User');
			if(isset($user_id)&&isset($authority) &&$user['authority'] == 1)
			{
				$this->userCursor->update(array('_id'=>$user_id),array('$set'=>array('authority'=>intval($authority))));
				$tmp = $this->userCursor->findOne(array('_id'=>$user_id,'authority'=>intval($authority)));
				if(isset($tmp))
				{
					$this->set('code',1);
				}
				else
				{
					$this->set('code',0);
				}
			}
			else
			{
				$this->redirect('/users/index');
				exit();
			}
		}
	}
?>