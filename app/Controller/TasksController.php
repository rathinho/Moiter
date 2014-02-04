<?php
	/**
	* 
	*/
	class TasksController extends AppController
	{

		private $connection = null;
		private $stageCollection = null;
		private $projectCollection = null;
		private $userCollection = null;
		public function beforeFilter()
		{
			// $this->checkSession();
			parent::beforeFilter();
			$this->connection = new Mongo();

			$this->stageCollection = $this->connection->moiter->stages;
			$this->projectCollection = $this->connection->moiter->projects;
			$this->userCollection = $this->connection->moiter->users;
		}
		public function afterFilter()
		{
			$this->connection->close();
		}

		public function create()
		{
			$user = $this->Session->read('User');
			if(isset($_POST))
			{
				$task = array(
					'task_id'=>md5($user['userName']."".time()),
					'user_id'=>$user['user_id'],
					'content'=>$_POST['content'],
					'leader'=>$_POST['leader'],
					'status'=>1,
					'priority'=>$_POST['priority'],
					'deadline'=>$_POST['deadline']);
				$this->stageCollection->update(array('_id'=>$_POST['stage_id']),
											   array('$push'=>array('task'=>$task)));
				$stage = $this->stageCollection->findOne(array('_id'=>$_POST['stage_id']));
				$project = $this->projectCollection->findOne(array('_id'=>$stage['project_id']));

				$this->userCollection->update(array('_id'=>$user['user_id']),array('$push'=>array('project_task_id'=>$project['name']."#".$stage['project_id']."#".$task['task_id'])));

				$this->set('project_id',$project['_id']);
			}
			else
			{
				$this->redirect("/projects/index");
				exit();	
			}

		}
		public function delete($project_id = null,$stage_id = null,$task_id = null)
		{	
			if(isset($project_id) && isset($stage_id) && isset($task_id))
			{
			
				$project = $this->projectCollection->findOne(array('_id'=>$project_id),array('name'=>1,'leader'=>1));
				$taskCur = $this->stageCollection->find(array('_id' => $stage_id), array('task'=>array('$elemMatch'=>array('task_id'=>$task_id))));
				$task = $taskCur->getNext();
				// print_r($task);
				if(isset($task['task']) && isset($project))
				{
					
					$currentUser = $this->Session->read('User');
					if($currentUser['user_id'] == $task['task'][0]['user_id'] || $currentUser['authority'] == 1 || $currentUser['userName'] === $project['leader'])
					{
						$tmp = $project['name']."#".$project_id."#".$task_id;
						// print $tmp;
						$this->userCollection->update(array('_id'=>$task['task'][0]['user_id']),array('$pull'=>array('project_task_id'=>$tmp)));
						$this->stageCollection->update(array('_id'=>$stage_id),
													   array('$pull'=>array('task'=>array('task_id'=>$task_id))));
						$tmpTask = $this->stageCollection->find(array('_id' => $stage_id), array('task'=>array('$elemMatch'=>array('task_id'=>$task_id))));
						$oldTask = $tmpTask->getNext();
						if(isset($oldTask['task']))
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

		public function edit()
		{
			if(!empty($_POST))
			{
				// print_r($_POST);
				$newTask = array('task_id'=>$_POST['task_id'],
								 'user_id'=>$_POST['user_id'],
								 'content'=>$_POST['content'],
								 'leader'=>$_POST['leader'],
								 'status'=>intval($_POST['status']),
								 'priority'=>$_POST['priority'],
								 'deadline'=>$_POST['deadline']);
				$this->stageCollection->update(array('_id'=>$_POST['stage_id']),array('$pull'=>array('task'=>array('task_id'=>$_POST['task_id']))));
				$this->stageCollection->update(array('_id'=>$_POST['stage_id']),array('$push'=>array('task'=>$newTask)));
				$this->set('project_id',$_POST['project_id']);
			}
			else
			{
				$this->redirect('/projects/index');
				exit();
			}

		}
		public function modifyStatus()
		{	
			$currentUser = $this->Session->read('User');

			if(isset($_POST['status']) && isset($_POST['task_id']))
			{
				$tmpTask = $this->stageCollection->find(array('_id'=>$_POST['stage_id']),array('task'=>array('$elemMatch'=>array('task_id'=>$_POST['task_id']))));
				$newTask = $tmpTask->getNext();
				if(isset($newTask['task'])){
					// $newTask[''] = $status;
					$task = $newTask['task'][0];
					$task['status'] = intval($_POST['status']);
					$this->stageCollection->update(array('_id'=>$_POST['stage_id']),
											       array('$pull'=>array('task'=>array('task_id'=>$_POST['task_id']))));
					$this->stageCollection->update(array('_id'=>$_POST['stage_id']),
											   	   array('$push'=>array('task'=>$task)));
					$this->set('code',1);
					$this->redirect('/users/view/'.$_POST['user_id']);
					exit();
				}
				else
				{
					$this->set('code',0);
					$this->redirect('/users/index');
					exit();
				}
			}
			else
			{
				$this->redirect('/projects/index');
				exit();				
			}
			
		}

	}
?>