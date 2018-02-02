<?php

  class CategoryModel extends AbstractModel
  {

    const GET_ALL_CATEGORIES = "SELECT `categoryName` FROM `categories`";

    const GET_CATEGORY_DETAILS = "SELECT C.`id`, C.`categoryName`, COUNT(P.`categoryID`) AS `postNumber` FROM `categories` AS C
                                  LEFT JOIN `post` as P ON P.`categoryId`=C.`id` GROUP BY C.`id`
                                  ORDER BY `postNumber` DESC";

    const GET_LAST_CATEGORY_DETAILS = "SELECT C.`id`, C.`categoryName`, COUNT(P.`categoryID`) AS `postNumber` FROM `categories` AS C
                                       LEFT JOIN `post` as P ON P.`categoryId`=C.`id` GROUP BY C.`id`
                                       ORDER BY `postNumber` DESC
                                       LIMIT 8";

    const GET_CATEGORY_ID = "SELECT `id` FROM `categories` WHERE `categoryName`=?";

    const SEARCH_CATEGORY = "SELECT `categoryName` FROM `categories` WHERE `categoryName` LIKE ?";

    const INSERT_CATEGORY = "INSERT INTO `categories` (`categoryName`) VALUES (?)";

    const UPDATE_CATEGORY = "UPDATE `categories` SET `categoryName`=? WHERE `id`=?";

    const DELETE_CATEGORY = "DELETE FROM `categories` WHERE `id`=?";



    /**
     * Récupère la liste des catégories de la base de données.
     * @return [array] [tableau contenant les catégories]
     */
    public function getAllCategories()
    {
      $result=$this->database->query(self::GET_ALL_CATEGORIES);
      return($result);
    }

    /**
     * Récupère l'Id d'une catégorie en fonction du champ categoryName
     * @param  [array] $value [tableau contenant le categoryName]
     * @return [array]        [tableau contenant l'id de la categorie demandée]
     */
    public function getCategoryId($value)
    {
      $result=$this->database->queryOne(self::GET_CATEGORY_ID,$value);
      return($result);
    }

    public function getCategoriesDetails()
    {
      $result=$this->database->query(self::GET_CATEGORY_DETAILS);
      return($result);
    }

    public function getLastCategoriesDetails()
    {
      $result=$this->database->query(self::GET_LAST_CATEGORY_DETAILS);
      return($result);
    }

    public function searchCategory(array $criterias)
    {
      $criterias[0]="%".$criterias[0]."%";
      $result=$this->database->query(self::SEARCH_CATEGORY,$criterias);
    }

    /**
     * Créé une nouvelle catégorie dans la base de donnée
     * @param  array  $values [tableau contenant le nom de la catégorie à crééer]
     * @return [int]         [id de la catégorie créée]
     */
    public function insertCategory(array $values)
    {
      $result=$this->database->executeSql(self::INSERT_CATEGORY,$values);
      return($result);
    }

    /**
     * Modifie une catégorie en fonction de son id
     * @param  array  $values [description]
     * @return [array]         [tableau contenant la catégorie modifiée]
     */
    public function updateCategory(array $values)
    {
      $result=$this->database->executeSql(self::UPDATE_CATEGORY,$values);
      return($result);
    }

    public function deleteCategory(array $values)
    {
      $result=$this->database->executeSql(self::DELETE_CATEGORY,$values);
      return($result);
    }

  }

?>
