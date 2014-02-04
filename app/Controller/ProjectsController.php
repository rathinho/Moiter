<?php
	
	/**
	* 
	*/
	 class ProjectsController extends AppController
	{
		
		private $projectCollection= null;
		private $companyCollection = null;
		private $stageCollection = null;
		private $userCollection = null;

		private $connection = null;

		//public $admin = null;
		
		public function beforeFilter(){
			parent::beforeFilter();
			// $this->checkSession();

			//$admin = 

			$this->connection = new Mongo();
			$this->projectCollection = $this->connection->moiter->projects;
			$this->companyCollection = $this->connection->moiter->companies;
			$this->stageCollection = $this->connection->moiter->stages;
			$this->userCollection = $this->connection->moiter->users;
		}
		public function afterFilter(){
			$this->connection->close();
		}

		public function index()
		{

			$projectData = array();
			$cursor = $this->projectCollection->find();		
			while($cursor->hasNext())
			{
				$projectData[] =  $cursor->getNext();
			}
			//echo json_encode($projectData);
			foreach ($projectData as &$p) {
				# code...
				$status_1 = 0;
				$status_2 = 0;
				$status_3 = 0;
				$stages = $this->stageCollection->find(array('project_id'=>$p['_id']),array('task'=>1));
				while($stages->hasNext()){
					$stage = $stages->getNext();
					// print_r($stage['task']);
					foreach ($stage['task'] as $task) {
						if($task['status'] == 1){
							$status_1 += 1;
						}
						else if( $task['status'] == 2){
							$status_2 += 1;
						}
						else if($task['status'] == 3)
							$status_3 += 1;
					}

				}
				$p['status_1'] = $status_1;
				$p['status_2'] = $status_2;
				$p['status_3'] = $status_3;

			}
			// print_r($projectData);
			$this->set('projects',$projectData);

		}

		public function view($project_id = null)
		{

			$stageCursor = $this->stageCollection->find(array('project_id'=>$project_id))->sort(array('index'=>1));
			$projectData = $this->projectCollection->findOne(array('_id'=>$project_id));
			if(isset($projectData))
			{
				$stageData = array();
				while($data = $stageCursor->getNext())
				{
					$stageData[] = $data;
				}

				// print_r($stageData);
				$stages =  array();
				foreach ($stageData as &$stage) {
					# code...

					foreach ($stage['task'] as &$task) {
						# code...
						$aUser = $this->userCollection->findOne(array('_id'=>$task['user_id']));
						$task['user_name'] = $aUser['name'];
						$task['pic_url'] = $aUser['pic_url'];
						// print_r($aUser['name']);
					}
				}
				// print_r ($stageData);
				$this->set('project' , $projectData);
				$this->set('stages' ,$stageData);
			}
			else
			{
				$this->redirect("/projects/index");
				exit();				
			}
		
		}
		
		public function create()
		{
		
			$user = $this->Session->read('User');
			if($user['authority'] == 1 && !empty($_POST))
			{
				// print_r($user);

				$project_id = md5($user['userName']."".time());
				$this->projectCollection->insert(array('_id'=> $project_id, 
												 'name'=>$_POST['name'],
												 'leader'=>$_POST['leader'],
												 'startTime'=>$_POST['startTime'],
												 'endTime'=>$_POST['endTime'],
												 'status'=>1,
												 'summary'=>$_POST['summary']));
				$tmp = $this->projectCollection->findOne(array('_id'=>$project_id));

				$this->set('project_id',$project_id);
				$this->set('code',1);
			}
			else
			{
				$this->redirect("/projects/index");
				exit();
			}
		}

		public function delete($project_id = null)
		{
			$user = $this->Session->read('User');
			if($user['authority'] == 1 )
			{

				$project = $this->projectCollection->findOne(array('_id'=>$project_id),array('name'=>1));
				if(isset($project))
				{

					$stageCur = $this->stageCollection->find(array('project_id'=>$project_id));

					while($stageCur->hasNext())
					{
						$stage = $stageCur->getNext();
						
						foreach ($stage['task'] as $task) {
							# code...
							$tmp = $project['name']."#".$project_id."#".$task['task_id'];
							
							$this->userCollection->update(array('_id'=>$task['user_id']),array('$pull'=>array('project_task_id'=>$tmp)));
						}
					}

					$this->projectCollection->remove(array('_id' => $project_id));

					$this->stageCollection->remove(array('project_id'=>$project_id));
					$old = $this->projectCollection->findOne(array('_id',$project_id));
					if(isset($old))
					{
						$this->set('code',0);
					}
					else
					{
						$this->set('code',1);
					}
				}
				else
				{
					$this->set('code',0);
					$this->redirect("/projects/index");
					exit();
				}
			}
			else
			{
				$this->set('code',0);
				$this->redirect("/projects/index");
				exit();
			}

		}

	}
?>