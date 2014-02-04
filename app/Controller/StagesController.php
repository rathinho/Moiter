<?php
	/**
	* 
	*/
	class StagesController extends AppController
	{
		private $connection = null;

		//$projectCollection = null;
		private $stageCollection = null;
		private $userCollection = null;
		public function beforeFilter()
		{
			// $this->checkSession();
			parent::beforeFilter();
			$this->connection = new Mongo();
			$this->projectCollection = $this->connection->moiter->projects;
			$this->stageCollection = $this->connection->moiter->stages;
			$this->userCollection = $this->connection->moiter->users;

		}
		public function afterFilter()
		{
			$this->connection->close();
		}

		// public function index($project_id)
		// {
		// 	$stageCursor = $this->projectCollection->find(array('project_id'=>$project_id))->sort(array('index'=>1));
		// 	$stageData = array();
		// 	while($data = $stageCursor->getNext())
		// 	{
		// 		$stageData = $data;
		// 	}
		// 	// pr($stageData);
		// 	$this->set('stages',$stageData);

		// }

		public function create()
		{
			$user =$this->Session->read('User');
			if(!empty($_POST['startTime']) && !empty($_POST['endTime']) && ($user['userName'] === $_POST['leader'] || $user['authority'] == 1))
			{
				
				$stage_id = md5($user['userName']."".time());
				$this->stageCollection->insert(array('_id'=>$stage_id,
													 'user_id'=>$user['user_id'],
													 'project_id'=>$_POST['project_id'],
													 'leader'=>$_POST['leader'],
													 'startTime'=>$_POST['startTime'],
													 'endTime'=>$_POST['endTime'],
													 'status'=>1,
													 'index'=>time(),
													 'summary'=>$_POST['summary'],
													 'task'=>array()));
				$tmp = $this->stageCollection->findOne(array('_id'=>$stage_id));
				$this->set('project_id',$_POST['project_id']);
			}
			else
			{
				$this->redirect("/projects/index");
				exit();	
			}
		}

		public function delete($project_id=null,$stage_id=null)
		{
			if(isset($project_id) && isset($stage_id))
			{
				$project = $this->projectCollection->findOne(array('_id'=>$project_id),array('name'=>1,'leader'=>1));
				if(isset($project))
				{
					$currentUser = $this->Session->read('User');
					if($currentUser['userName'] === $project['leader'] || $currentUser['authority'] == 1)
					{
						$oldStage = $this->stageCollection->findOne(array('_id'=>$stage_id),array('task'=>1));
						foreach ($oldStage['task'] as $task) {
							# code...
							$tmp = $project['name']."#".$project_id."#".$task['task_id'];
							$this->userCollection->update(array('_id'=>$task['user_id']),array('$pull'=>array('project_task_id'=>$tmp)));
						}
						$this->stageCollection->remove(array('_id'=>$stage_id));
					
						$temp = $this->stageCollection->findOne( array('_id'=>$stage_id ));
						
						if(isset($temp))
						{
							$this->set('code',0);
						}
						else
						{
							$this->set('code',1);
						}
						$this->set('project_id',$project_id);
					}
					else
					{

						$this->redirect("/projects/index");
						exit();	
					}
				}
				else
				{
					$this->redirect("/projects/index");
					exit();	
				}
			}
			else
			{

				$this->redirect("/projects/index");
				exit();	
			}			
		}
	}
?>