<?php

    class Post {
        private $conn;
        private $table ='leaves';

       
        public $userId;
        public $userName;
        public $fromDate;
        public $toDate;
        public $submittedDate;
        public $branchName;
        public $remarks;

        public function __construct($db){

            $this->conn = $db;   
            
        }

       

        public function readbranch(){
            $query = 'Select DISTINCT l.userId, l.userName, l.branchName, e.deptName,  DATE_ADD(l.submittedDate, INTERVAL -330 MINUTE) as submittedDate, DATE_ADD(l.fromDate, INTERVAL -330 MINUTE)as fromDate ,DATE_ADD(l.toDate, INTERVAL -330 MINUTE) as toDate ,l.remarks  from Employees e, Leaves l where l.userId = (select e.userId where e.branchName = ?) and l.branchname = ? and l.submittedDate like ? Order by l.submittedDate';


            $statement = $this->conn->prepare($query);
            $statement-> bindParam(1, $this->searchInput);
            $statement-> bindParam(2, $this->searchInput);
            $statement-> bindParam(3, $this->searchClock);
            $statement->execute();
            
            return $statement;

        }


        public function readmax(){
            $query = 'SELECT max(DATE_ADD(submittedDate, INTERVAL -330 MINUTE)) as submittedDate from Leaves where branchName = ? ';


            $statement = $this->conn->prepare($query);
            $statement-> bindParam(1, $this->searchInput);
           
            $statement->execute();
            
            return $statement;

        }


        public function write(){
            $query = 'INSERT INTO Leaves set
            userId =:userId, 
            userName =:userName, 
            fromDate =:fromDate, 
            toDate =:toDate, 
            submittedDate =:submittedDate,
            branchName =:branchName, 
            remarks =:remarks';


            $statement = $this->conn->prepare($query);
            $this->userId = htmlspecialchars(strip_tags($this->userId));
            $this->userName = htmlspecialchars(strip_tags($this->userName));
            $this->fromDate = htmlspecialchars(strip_tags($this->fromDate));
            $this->toDate = htmlspecialchars(strip_tags($this->toDate));
            $this->submittedDate = htmlspecialchars(strip_tags($this->submittedDate));
            $this->branchName = htmlspecialchars(strip_tags($this->branchName));
            $this->remarks = htmlspecialchars(strip_tags($this->remarks));
            $statement->bindParam(':userId', $this->userId);
            $statement->bindParam(':userName', $this->userName);
            $statement->bindParam(':fromDate', $this->fromDate);
            $statement->bindParam(':toDate', $this->toDate);
            $statement->bindParam(':submittedDate', $this->submittedDate);
            $statement->bindParam(':branchName', $this->branchName);
            $statement->bindParam(':remarks', $this->remarks);

            if($statement->execute()){
                return true;
            }

            printf("Error :", $statement->error);
            return false;
            

        }



    }
