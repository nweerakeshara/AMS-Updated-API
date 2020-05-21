<?php

    class Post {
        private $conn;
        private $table ='leaves';

       
        public $Name;
        public $file;
        public $branch;
        public $SubmittedDate;
      

        public function __construct($db){

            $this->conn = $db;   
            
        }

       

        public function readbranch(){
            $query = 'Select Name,  branch, DATE_ADD(uploadedOn, INTERVAL -330 MINUTE) as SubmittedDate  from FieldOfficers where  branch like ?';


            $statement = $this->conn->prepare($query);
            $statement-> bindParam(1, $this->searchInput);
            
            $statement->execute();
            
            return $statement;

        }


    }
