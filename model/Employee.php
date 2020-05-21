<?php

    class Post {
        private $conn;
        private $table ='employees';

       
        public $userId;
        public $UserName;
        public $Gender;
        public $deptName;
        public $branchName;
        

        public function __construct($db){

            $this->conn = $db;   
            
        }

        public function read(){
            $query = 'SELECT userId, UserName, Gender, deptName, branchName from employees ';


            $statement = $this->conn->prepare($query);
            $statement->execute();
            return $statement;

        }

        public function readbranch(){
            $query = 'SELECT userId, UserName, Gender, deptName, branchName from employees where branchname = ? Order by userId';


            $statement = $this->conn->prepare($query);
            $statement-> bindParam(1, $this->searchInput);
            $statement->execute();
            
            return $statement;

        }

        public function readmax(){
            $query = 'SELECT max(userId) as userId from Employees where branchName = ? ';


            $statement = $this->conn->prepare($query);
            $statement-> bindParam(1, $this->searchInput);
            $statement->execute();
            
            return $statement;

        }


        public function write(){
            $query = 'INSERT INTO Employees set
            userId =:userId, 
            UserName =:UserName, 
            Gender =:Gender, 
            deptName =:deptName, 
            branchName =:branchName';


            $statement = $this->conn->prepare($query);
            $this->userId = htmlspecialchars(strip_tags($this->userId));
            $this->UserName = htmlspecialchars(strip_tags($this->UserName));
            $this->Gender = htmlspecialchars(strip_tags($this->Gender));
            $this->deptName = htmlspecialchars(strip_tags($this->deptName));
            $this->branchName = htmlspecialchars(strip_tags($this->branchName));
            $statement->bindParam(':userId', $this->userId);
            $statement->bindParam(':UserName', $this->UserName);
            $statement->bindParam(':Gender', $this->Gender);
            $statement->bindParam(':deptName', $this->deptName);
            $statement->bindParam(':branchName', $this->branchName);

            if($statement->execute()){
                return true;
            }

            printf("Error :", $statement->error);
            return false;
            

        }


    }
