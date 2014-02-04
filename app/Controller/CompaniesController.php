<?php
	/**
	 * 
	 */
	 class CompaniesController extends AppController
	 {
		public $company = null;
		public $connection = null;
		
		public function beforeFilter(){
			parent::beforeFilter();
			$this->connection = new Mongo();
			$database =  $this->connection->selectDB('moiter');
		 	$this->company = $database->selectCollection('companies');
		}
		public function afterFilter(){
			$this->connection->close();
		}

	 	function index()
	 	{	
		 	$cursor = $this->company->find();
		 	while($data = $cursor->getNext()){
		 		echo json_encode($data);
		 	}
	 		//$this->set('company',$cursor->getNext());
	 		
	 	}
	 	public function show($id = null)
	 	{
	 		# code...
	 	}
	 	public function delete($id = null)
	 	{

	 	}
	 	public function create($aNewCampany)
	 	{

	 	}
	 	public function edit($modifyCampany)
	 	{

	 	}
	 } 
 ?>