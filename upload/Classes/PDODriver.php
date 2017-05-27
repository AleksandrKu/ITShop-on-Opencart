<?php

class PDODriver
{
	//echo "You are in PDO";
	private $connection;

	public function __construct($server, $username, $password, $database)
	{
		//echo $server;
		$this->connection = new PDO("mysql:host={$server};dbname={$database}", $username, $password);

	}

	public function getConnection()
	{
		return $this->connection;
	}

	public function __destruct()
	{
		//сам закрывает конекшены
	}
	public function find_category_id($table, $category_id, $id)
	{
		if (!empty($id)) {
			$sql = "SELECT * FROM {$table} WHERE {$category_id} = :id";
			//$sql = "SELECT * FROM {$table} WHERE id = 5";
			$stm = $this->connection->prepare($sql);
			$parametrs = ['id' => $id];
			$execute_res = $stm->execute($parametrs);
			if ($execute_res == false) {
				throw new \Exception($stm->errorInfo()[2]);
			}
			return $stm->fetchObject();
		}
		return false;
	}

	public function find($table, $id = null)
	{
		if (!empty($id)) {
			$sql = "SELECT * FROM {$table} WHERE id = :id";
			//$sql = "SELECT * FROM {$table} WHERE id = 5";
			$stm = $this->connection->prepare($sql);
			$parametrs = ['id' => $id];
			$execute_res = $stm->execute($parametrs);
			if ($execute_res == false) {
				throw new \Exception($stm->errorInfo()[2]);
			}
			return $stm->fetchObject();
		} else {
			$sql = "SELECT * FROM {$table}";
			$stm = $this->connection->query($sql);
			if ($stm == false) {
				throw new \Exception($this->connection->errorInfo()[2]);
			}
			//return $stm->fetchAll(\PDO::FETCH_OBJ);
			return $stm->fetchObject();
		}
	}

	public function delete($table, $id_key='id', $id=0)
	{

		if (!empty($id)) {
			$sql = "DELETE FROM {$table} WHERE {$id_key} = :id";
			$stm = $this->connection->prepare($sql);
			$parameters = ['id' => $id];
			$execute_res = $stm->execute($parameters);
			if ($execute_res == false) {
				throw new \Exception($stm->errorInfo()[2]);
			}
			//return $stm->fetchObject();
			return true;
		} else {
			$sql = "DELETE FROM {$table}";
			$stm = $this->connection->prepare($sql);
			$execute_res = $stm->execute();
			if ($execute_res == false) {
				throw new \Exception($this->connection->errorInfo()[2]);
			}
			//return $stm ->fetchAll(\PDO::FETCH_OBJ);
			return true;
		}
		return false;
	}

	public function insert($table, array $properties)
	{
		$sql = "INSERT INTO `{$table}` ";
		$sql .= "(" . implode(',', array_keys($properties)) . ")";
		$sql .= " VALUES ";
		foreach ($properties as $column_name => $value) {
			$values_array[] = ":{$column_name}";
		}
		$sql .= "(" . implode(',', $values_array) . ")";
		//echo $sql;
		$stm = $this->connection->prepare($sql);
		$execute_res = $stm->execute($properties);
        //var_dump($stm);
		//die();
		if($execute_res == false) {
			throw new \Exception($stm->errorInfo()[2]);
		}
		return $this->connection->lastInsertId();
	}

	public function update($table, $name_id = 'id', $id, array $properties) {
		$sql = "UPDATE {$table} SET ";
		$update_sql= [];
		foreach ($properties as $column_name => $value) {
			$update_sql[] = "{$column_name}=:{$column_name}";
		}
		$sql .= implode(", ", $update_sql);
		$sql .= " WHERE {$name_id} =:id";

		$stm = $this->connection->prepare($sql);
		$properties['id'] = $id;
		$execute_res = $stm->execute($properties);
		if($execute_res == false) {
			throw new \Exception($stm->errorInfo()[2]);
		}
	}

	public function update_all_filed($table, array $properties) {
		$sql = "UPDATE {$table} SET ";
		$update_sql= [];
		foreach ($properties as $column_name => $value) {
			$update_sql[] = "{$column_name}=:{$column_name}";
		}
		$sql .= implode(", ", $update_sql);

	/*	$sql .= " WHERE {$name_id} =:id";*/

		$stm = $this->connection->query($sql);
		/*$properties['id'] = $id;
		$execute_res = $stm->execute($properties);
		if($execute_res == false) {
			throw new \Exception($stm->errorInfo()[2]);
		}*/
		return $stm;
	}


}