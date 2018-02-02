<?php

class UserModel extends AbstractModel
{

  const SQL_SIGNUP = "INSERT INTO `user` (`firstName`, `lastName`, `mail`, `password`) VALUES (?,?,?,?)";

  const SQL_CONNECT = "SELECT `id`,`rights`,`firstName`,`lastName`,`avatarUrl`,`phone`,`mail` FROM `user` WHERE `mail`=? AND `password`=?";

  const SQL_UPDATE =
  "SELECT `phone`, `inscriptionDate`, `mail`, `rights`, `id`, `lastName`, `firstName`, `avatarUrl`
  FROM `user`
  WHERE `id`=?";

  const SQL_GET_LAST_USERS = "SELECT U.`id`, U.`firstName`, U.`lastName`, U.`avatarUrl`,U.`phone`,U.`mail`, U.`rights`, COUNT(P.`redactorId`) AS `postNumber`, COUNT(C.`userId`) AS `commentNumber`
                              FROM `user` as U
                              LEFT JOIN `post` AS P ON P.`redactorId`=U.`id`
                              LEFT JOIN `comment` AS C ON C.`userId`=U.`id`
                              GROUP BY U.`id`
                              ORDER BY U.`id` DESC LIMIT 8";

  const SQL_GET_ALL_USERS = "SELECT U.`id`, U.`firstName`, U.`lastName`, U.`avatarUrl`,U.`phone`,U.`mail`,U.`rights`, COUNT(P.`redactorId`) AS `postNumber`, COUNT(C.`userId`) AS `commentNumber`
                              FROM `user` as U
                              LEFT JOIN `post` AS P ON P.`redactorId`=U.`id`
                              LEFT JOIN `comment` AS C ON C.`userId`=U.`id`
                              GROUP BY U.`id`
                              ORDER BY U.`id` DESC";

  const SQL_AVATAR_UPDATE =
  "UPDATE `user`
  SET `avatarUrl`=?
  WHERE `id`=?";

  const SQL_AVATAR_CHECK =
  "SELECT `avatarUrl` FROM `user`
  WHERE `id`=?";

  const SQL_VERIF_PASSWORD =
  "SELECT `password` FROM `password` WHERE `userId`=? AND `password`=?";

  const SQL_UPDATE_PASSWORD =
  "UPDATE `password` SET `password`=? WHERE `userId`=?";

  const SQL_UPDATE_RIGHTS = "UPDATE `user` SET `rights`=? WHERE `id`=?";

/**
 * Méthode permettant de lancer une session. Opère la vérification des identifiants de connexion (mail et password) et opère un session_start si la requête SQL retourne un résultat. Lance également le remplissage du $_SESSION.
 * @param  array  $queryFields [champs mail et password servant de référence pour la vérification des identifiants]
 * @param  Http   $http        [classe Http]
 * @return [void]              [pas de return]
 */
  function connectUser(array $queryFields, Http $http)
  {
    $result = $this->database->queryOne(self::SQL_CONNECT,$queryFields);
    if ($result)
    {
      if ($result['rights'] != 'banned')
      {
        $session= (new UserSession)->create($result);
        $http->redirectTo('profil');
      }
      else
      {
        $flashbag = (new FlashBag)->add("Vous n'avez pas la persmission de vous connecter actuellement. Veuillez réessayer ultérieurement");
        $http->redirectTo('');
      }
    }
    else
    {
      $flashbag = (new FlashBag)->add("Identifiant ou mot de passe incorrect");
      $http->redirectTo('');
    }

  }

  public function getLastUser()
  {
    $result = $this->database->query(self::SQL_GET_LAST_USERS);
    return($result);
  }

  public function getAllUser()
  {
    $result = $this->database->query(self::SQL_GET_ALL_USERS);
    return($result);
  }

  /**
   * Inscription d'un nouvel utilisateur
   * @param  [array] $criterias [tableau devant contenir le nom, prénom, mail et password de l'utilisateur à crééer]
   * @return [int]            [id du nouvel utilisateur]
   */
  public function signUp(array $criterias)
  {
    $result = $this->database->executeSql(self::SQL_SIGNUP,$criterias);
    return $result;
  }

  /**
   * Méthode permettant la mise à jour des informations utilisateurs. Une fois la requête exécutée.
   * @param [type] $queryFields [champs à mettre à jour dans la base de donnée]
   */
  public function UpdateUser($queryFields)
  {
    $sqlString="UPDATE `user` SET ";
    $values = [];
    $limit = count($queryFields);
    $x=0;
    foreach($queryFields as $key=>$value)
    {
      $sqlString.="`$key`=?";
      array_push($values,$value);
      $x++;
      if ($limit > $x)
      {
        $sqlString.=",";
      }
      else {
        $sqlString.=" ";
      }
    }
    $sqlString.="WHERE `id`=?";

    array_push($values,$_SESSION['user']['id']);

    $this->database->executeSql($sqlString,$values);
  }

/**
 * Récupération des données de l'utilisateur après une mise à jour de son profil.
 * @param  array  $queryFields [description]
 * @return [type]              [description]
 */
  public function updateSession(array $queryFields)
{
  $result = $this->database->queryOne(self::SQL_UPDATE, $queryFields);
  return($result);
}

/**
 * Méthode permettant la mise à jour de l'avatar de l'utilisateur. Le procédé va construire le chemin du nouvel avatar, son nom et exécuter la méthode updateAvatar du UserModel Class.
 * @param  array  $inputFile [contenu du $_FILES]
 * @return [type]            [description]
 */
  public function updateAvatar(array $inputFile)
  {
      $extension = explode("/",$inputFile['type']);
      $extension=$extension[1];

      $name=$inputFile['id'].".".$extension;

      $baseUrl='/images/user/';
      $url=$baseUrl.$name;

      var_dump($extension);
      var_dump($name);
      var_dump($baseUrl);
      var_dump($url);

      $scan = scandir("application/www/images/user");
      foreach($scan as $value)
      {
        if (preg_match("/^([0-9+])\./",$value,$return))
        {
          unlink("application/www/images/user/$value");
          break;
        }
      }
      $target = (new Http)->moveUploadedFile('avatar',$baseUrl,$name);

      $newFile=[$baseUrl.$name,$inputFile['id']];
      $this->database->executeSql(self::SQL_AVATAR_UPDATE,$newFile);
  }

public function updatePassword(array $queryFields)
{

  $result = $this->database->queryOne(self::SQL_VERIF_PASSWORD,[$queryFields['id'],$queryFields['oldPassword']]);
  if ($result['password']==$queryFields['oldPassword'])
  {
    $result = $this->database->executeSql(self::SQL_UPDATE_PASSWORD,[$queryFields['password'],$queryFields['id']]);
  }
  return $result;
}

public function updateRights(array $queryFields)
{
  $result = $this->database->executeSql(self::SQL_UPDATE_RIGHTS,$queryFields);
  return($result);
}
}


 ?>
