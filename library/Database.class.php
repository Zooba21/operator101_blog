<?php


class Database
{
	private $pdo;


	public function __construct()
	{
		$configuration = new Configuration();

		$this->pdo = new PDO
		(
			$configuration->get('database', 'dsn'),
			$configuration->get('database', 'user'),
			$configuration->get('database', 'password')
		);

		$this->pdo->exec('SET NAMES UTF8');
	}

	public function executeSql($sql, array $values = array())
	{
		var_dump($sql);
		var_dump($values);
		$query = $this->pdo->prepare($sql);

		$query->execute($values);

		if ($query->errorCode() != '00000')
		{
			 		throw new ErrorException($query->errorInfo()[2], $query->errorInfo()[0], 1, __FILE__, __LINE__);
		}

		return $this->pdo->lastInsertId();
	}

    public function query($sql, array $criteria = array())
    {
        $query = $this->pdo->prepare($sql);

        $query->execute($criteria);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function queryOne($sql, array $criteria = array())
    {
        $query = $this->pdo->prepare($sql);

        $query->execute($criteria);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
