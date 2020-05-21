<?php

    class Database {
        private $host = "localhost";
        private $db_name = "ams";
        private $username = "root";
        private $password = "";
        private $conn;

        public function connect(){

            $this->conn = null;

            try{
                $this->conn = new PDO('mysql:host=localhost;port=3308;dbname=ams', 'root', '');
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch (PDOException $e){
                echo 'Connection Error: ' . $e->getMessage();
            }

            return $this->conn;

        }

    }

    

    



