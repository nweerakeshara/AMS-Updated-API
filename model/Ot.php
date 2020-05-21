<?php

    class Post {
        private $conn;
        private $table ='ottable';

       
        public $userId;
        public $userName;
        public $clockIn;
        public $clockOut;
        public $dateo;
        public $OT_or_LC_hrs;
        public $otHours;
        public $branchName;

        public function __construct($db){

            $this->conn = $db;   
            
        }

       

        public function readbranch(){
            $query = 'SELECT DISTINCT o.userId, o.userName, o.branchName, e.deptName, CAST(o.dateo AS DATE) as dateo, DATE_ADD(o.clockIn, INTERVAL -330 MINUTE) as clockIn, DATE_ADD(o.clockOut, INTERVAL -330 MINUTE) as clockOut ,o.otHours as OT_or_LC_hrs from employees e, ottable o where o.userId = (select e.userId where e.branchName = ?) and o.branchname = ? and o.dateo like ? Order by o.dateo ';


            $statement = $this->conn->prepare($query);
            $statement-> bindParam(1, $this->searchInput);
            $statement-> bindParam(2, $this->searchInput);
            $statement-> bindParam(3, $this->searchClock);
            $statement->execute();
            
            return $statement;

        }


        public function readmax(){
            $query = 'SELECT max(DATE_ADD(clockIn, INTERVAL -330 MINUTE)) as clockIn from otTable where branchName = ? ';


            $statement = $this->conn->prepare($query);
            $statement-> bindParam(1, $this->searchInput);
           
            $statement->execute();
            
            return $statement;

        }


        public function write(){
            $query = 'INSERT INTO otTable set
            userId =:userId, 
            userName =:userName, 
            clockIn =:clockIn, 
            clockOut =:clockOut, 
            dateo =:dateo,
            otHours =:otHours, 
            branchName =:branchName';


            $statement = $this->conn->prepare($query);
            $this->userId = htmlspecialchars(strip_tags($this->userId));
            $this->userName = htmlspecialchars(strip_tags($this->userName));
            $this->clockIn = htmlspecialchars(strip_tags($this->clockIn));
            $this->clockOut = htmlspecialchars(strip_tags($this->clockOut));
            $this->dateo = htmlspecialchars(strip_tags($this->dateo));
            $this->otHours = htmlspecialchars(strip_tags($this->otHours));
            $this->branchName = htmlspecialchars(strip_tags($this->branchName));
            $statement->bindParam(':userId', $this->userId);
            $statement->bindParam(':userName', $this->userName);
            $statement->bindParam(':clockIn', $this->clockIn);
            $statement->bindParam(':clockOut', $this->clockOut);
            $statement->bindParam(':dateo', $this->dateo);
            $statement->bindParam(':otHours', $this->otHours);
            $statement->bindParam(':branchName', $this->branchName);

            if($statement->execute()){
                return true;
            }

            printf("Error :", $statement->error);
            return false;
            

        }

    }
