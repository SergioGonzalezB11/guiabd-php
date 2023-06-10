<?php
    namespace Models;
    class Country{
        protected static $conn;
        protected static $columnsTbl=['id_country','name_country'];
        private $id_country;
        private $name_country;
        public function __construct($args = []){
            $this->id_country = $args['id_country'] ?? '';
            $this->name_country = $args['name_country'] ?? '';
        }
        public function saveData($data){
            $delimiter = ":";
            $dataBd = $this->sanitizarAttributos();
            $valCols = $delimiter . join(',:',array_keys($data));
            $cols = join(',',array_keys($data));
            //INSERT INTO countries ('name_country') VALUES (:name_country)
            $sql = "INSERT INTO countries ($cols) VALUES ($valCols)";
            $stmt= self::$conn->prepare($sql);
            try {
                $stmt->execute($data);
                $response=[[
                    'id_country' => self::$conn->lastInsertId(),
                    'name_country' => $data['name_country']
                ]];
            }catch(\PDOException $e) {
                return $sql . "<br>" . $e->getMessage();
            }
            return $response;
        }  

        public static function setConn($connBd){
            self::$conn = $connBd;
        }
        public function atributos(){
            $atributos = [];
            foreach (self::$columnsTbl as $columna){
                if($columna === 'id_country') continue;
                $atributos [$columna]=$this->$columna;
             }
             return $atributos;
        }
        public function sanitizarAttributos(){
            $atributos = $this->atributos();
            $sanitizado = [];
            foreach($atributos as $key => $value){
                $sanitizado[$key] = self::$conn->quote($value);
            }
            return $sanitizado;
        }
    }
?>