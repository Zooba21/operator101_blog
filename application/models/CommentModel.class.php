<?php

class commentModel extends AbstractModel
{

  const GET_COMMENTS = "SELECT C.`id`, C.`commentContent`, C.`commentDate`, U.`firstName`,U.`lastName` FROM `comment` AS C
  INNER JOIN `user` as U ON C.`userId`=U.`id`
  WHERE C.`postId`=? AND C.`reported`='0'";

  const GET_ALL_COMMENTS = "SELECT C.`id`, C.`postId`, C.`userId`, P.`postTitle`, C.`commentContent`, C.`commentDate`, U.`firstName`,U.`lastName` FROM `comment` AS C
  INNER JOIN `user` as U ON C.`userId`=U.`id`
  INNER JOIN `post` as P ON C.`postId`=P.`id`
  WHERE C.`reported`='0'";

  const GET_LAST_COMMENTS = "SELECT C.`id`, C.`postId`, C.`userId`, P.`postTitle`, C.`commentContent`, C.`commentDate`, U.`firstName`,U.`lastName` FROM `comment` AS C
  INNER JOIN `user` as U ON C.`userId`=U.`id`
  INNER JOIN `post` as P ON C.`postId`=P.`id`
  WHERE C.`reported`='0'
  LIMIT 8";

  const GET_LAST_REPORTED_COMMENTS = "SELECT C.`id`, C.`postId`, C.`userId`, P.`postTitle`, C.`commentContent`, C.`commentDate`, U.`firstName`,U.`lastName` FROM `comment` AS C
  INNER JOIN `user` as U ON C.`userId`=U.`id`
  INNER JOIN `post` as P ON C.`postId`=P.`id`
  WHERE C.`reported`='1'
  LIMIT 8";

  const GET_REPORTED_COMMENTS = "SELECT C.`id`, C.`postId`, C.`userId`, P.`postTitle`, C.`commentContent`, C.`commentDate`, U.`firstName`,U.`lastName` FROM `comment` AS C
  INNER JOIN `user` as U ON C.`userId`=U.`id`
  INNER JOIN `post` as P ON C.`postId`=P.`id`
  WHERE C.`reported`='1'";


  const INSERT_COMMENT = "INSERT INTO `comment` (`commentContent`,`postId`,`userId`) VALUES (?,?,?)";

  const REPORT_COMMENT = "UPDATE `comment` SET `reported`='1' WHERE `id`=?";

  const UNREPORT_COMMENT = "UPDATE `comment` SET `reported`='0' WHERE `id`=?";

  const BAN_COMMENT = "UPDATE `comment` SET `reported`='2' WHERE `id`=?";

  const UPDATE_COMMENT = "UPDATE `comment` SET `commentContent`=? WHERE `id`=?";


  public function getComments($criterias)
  {
    $result=$this->database->query(self::GET_COMMENTS,$criterias);
    return $result;
  }

  public function getAllComments()
  {
    $result=$this->database->query(self::GET_ALL_COMMENTS);
    return $result;
  }

  public function getLastComments()
  {
    $result=$this->database->query(self::GET_LAST_COMMENTS);
    return $result;
  }

  public function getLastReportedComments()
  {
    $result=$this->database->query(self::GET_LAST_REPORTED_COMMENTS);
    return($result);
  }

  public function getReportedComments()
  {
    $result=$this->database->query(self::GET_REPORTED_COMMENTS);
    return($result);
  }

  public function newComment($criterias)
  {
    $result=$this->database->executeSql(self::INSERT_COMMENT,$criterias);
    return($result);
  }

  public function reportComment($criterias)
  {
    return($result=$this->database->executeSql(self::REPORT_COMMENT,$criterias));
  }

  public function unreportComment($criterias)
  {
    return($result=$this->database->executeSql(self::UNREPORT_COMMENT,$criterias));
  }

  public function banComment($criterias)
  {
    return($result=$this->database->executeSql(self::BAN_COMMENT,$criterias));
  }

  public function editComments($criterias)
  {
    return($result=$this->database->executeSql(self::UPDAUPDATE_COMMENT));
  }
}

?>
