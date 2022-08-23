<?php
//Функция валидации имени

//Функция валидации e-mail

//Функция которая возвращает id товара

function () 
{

}
 public function insert($employee)
    {

        $sqlQuery = "INSERT INTO employee(user_id,name,address,city) VALUES(:user_id,:name,:address,:city) RETURNING employee_id";

        $statement = $this->prepare($sqlQuery);

        $a = time();

        $statement->bindParam(":user_id", $employee->getUserId(), PDO::PARAM_INT);
        $statement->bindParam(":name", $employee->getName(), PDO::PARAM_STR);
        $statement->bindParam(":address", $employee->getAddress(), PDO::PARAM_STR);
        $statement->bindParam(":city", $employee->getCity(), PDO::PARAM_STR);
        $statement->execute();
       
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result["employee_id"];

    }