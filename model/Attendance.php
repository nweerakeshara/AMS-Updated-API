<?php

    class Post {
        private $conn;
        private $table ='attendance';

       
        public $userId;
        public $userName;
        public $clock;
        public $remarks;
        public $branchName;
        public $deptName;

        public function __construct($db){

            $this->conn = $db;   
            
        }

       



        public function readbranch(){
            $query = 'Select DISTINCT a.userId, a.userName, a.branchName, e.deptName,  DATE_ADD(a.clock, INTERVAL -330 MINUTE) as clock, a.remarks from Employees e, Attendance a where a.userId = (select e.userId where e.branchName = ?) and a.branchname = ? and a.clock like ? Order by a.userId';
           

            $statement = $this->conn->prepare($query);
            $statement-> bindParam(1, $this->searchInput);
            $statement-> bindParam(2, $this->searchInput);
            $statement-> bindParam(3, $this->searchClock);
            $statement->execute();
            
            return $statement;

        }

        public function readmax(){
            $query = 'SELECT max(DATE_ADD(clock, INTERVAL -330 MINUTE)) as clock from Attendance where branchName = ? ';
           

            $statement = $this->conn->prepare($query);
            $statement-> bindParam(1, $this->searchInput);
            
            $statement->execute();
            
            return $statement;

        }


        public function write(){
            $query = 'INSERT INTO Attendance set
            userId =:userId, 
            userName =:userName, 
            clock =:clock, 
            remarks =:remarks, 
            branchName =:branchName';


            $statement = $this->conn->prepare($query);
            $this->userId = htmlspecialchars(strip_tags($this->userId));
            $this->userName = htmlspecialchars(strip_tags($this->userName));
            $this->clock = htmlspecialchars(strip_tags($this->clock));
            $this->remarks = htmlspecialchars(strip_tags($this->remarks));
            $this->branchName = htmlspecialchars(strip_tags($this->branchName));
            $statement->bindParam(':userId', $this->userId);
            $statement->bindParam(':userName', $this->userName);
            $statement->bindParam(':clock', $this->clock);
            $statement->bindParam(':remarks', $this->remarks);
            $statement->bindParam(':branchName', $this->branchName);

            if($statement->execute()){
                return true;
            }

            printf("Error :", $statement->error);
            return false;
            

        }



    }
