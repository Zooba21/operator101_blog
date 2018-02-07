<?php

  class PostsModel extends AbstractModel
  {

    const GET_POST_TITLE = "SELECT `postTitle` FROM `post` WHERE `postTitle` LIKE ?";

    const GET_POST_NUMBER = "SELECT COUNT(`id`) AS postNumber FROM `post` WHERE `redactorId`=?";

    const GET_ALL_POSTS = "SELECT P.`id`, P.`postContent`, P.`redactorId`, P.`creationDate`, P.`postTitle`, P.`postThumbnail`, P.`postResume`, P.`categoryId`, C.`categoryName`, U.`firstName`, U.`lastName`
                           FROM `post` as P
                           INNER JOIN `user` as U ON U.`id`= P.`redactorId`
                           INNER JOIN `categories` as C ON C.`id`= P.`categoryId` ORDER BY `creationDate`";

    const GET_POST_SORTED = "SELECT C.`id`, P.`redactorId`, P.`creationDate`, P.`postTitle`, C.`categoryName`, U.`firstName`, U.`lastName`
                           FROM `post` as P
                           INNER JOIN `user` as U ON U.`id`= P.`redactorId`
                           INNER JOIN `categories` as C ON C.`id`= P.`categoryId` ORDER BY ? ASC";

    const GET_LAST_POST = "SELECT P.`id`, P.`redactorId`, P.`creationDate`, P.`postTitle`, P.`postThumbnail`, P.`postResume`, P.`categoryId`, C.`categoryName`, U.`firstName`, U.`lastName`
                           FROM `post` as P
                           INNER JOIN `user` as U ON U.`id`= P.`redactorId`
                           INNER JOIN `categories` as C ON C.`id`= P.`categoryId` ORDER BY `creationDate`
                           LIMIT 8";

    const GET_ONE_POST = "SELECT P.`id`, P.`redactorId`, P.`postContent`, P.`creationDate`, P.`postTitle`, P.`postThumbnail`, P.`postResume`, P.`categoryId`, C.`categoryName`, U.`firstName`, U.`lastName` FROM `post` AS P
                          INNER JOIN `user` as U ON U.`id`= P.`redactorId`
                          INNER JOIN `categories` as C ON C.`id`= P.`categoryId`
                          WHERE P.`id`=?";

    const GET_POST_CATEGORY = "SELECT * FROM `post` AS P
                               INNER JOIN `user` as U ON U.`id`= P.`redactorId`
                               INNER JOIN `categories` as C ON C.`id`= P.`categoryId`
                               WHERE P.`categoryId`=? ORDER BY P.`creationDate`";

    const GET_POST_REDACTOR = "SELECT * FROM `post` AS P
                               INNER JOIN `user` as U ON U.`id`= P.`redactorId`
                               INNER JOIN `categories` as C ON C.`id`= P.`categoryId`
                               WHERE P.`redactorId`=? ORDER BY P.`creationDate`";

    const GET_POST_REDACTOR_CATEGORY = "SELECT * FROM `post`
                                        WHERE `id`=? AND `redactorId`=? AND `category`=? ORDER BY `creationDate`";

    const GET_POST_RESEARCH = "SELECT P.`id`, P.`postContent`, P.`redactorId`, P.`creationDate`, P.`postTitle`, P.`postThumbnail`, P.`postResume`, P.`categoryId`, C.`categoryName`, U.`firstName`, U.`lastName`
                           FROM `post` as P
                           INNER JOIN `user` as U ON U.`id`= P.`redactorId`
                           INNER JOIN `categories` as C ON C.`id`= P.`categoryId`
                               WHERE P.`postTitle` LIKE ? ORDER BY P. `creationDate`";

      const INSERT_NEW_POST = "INSERT INTO `post` (`redactorId`, `postTitle`, `postResume`, `postContent`, `categoryId`)
                             VALUES (?,?,?,?,?)";

    const UPDATE_POST_THUMBNAIL = "UPDATE `post` SET `postThumbnail`=? WHERE `id`=?";

    const UPDATE_POST = "UPDATE `post` SET `postTitle`=?, `postResume`=?, `postContent`=?, `categoryId`=? WHERE `id`=?";


    public function getPostTitle($criterias)
    {
      $result=$this->database->query(self::GET_POST_TITLE,$criterias);
      $result = json_encode($result);
      return($result);
    }

    public function getPostNumber($criteras)
    {
      $result=$this->database->queryOne(self::GET_POST_NUMBER,$criteras);
      return($result);
    }

  /**
   * Permet de récupérer l'ensemble des posts de la base
   * @return [array] [tableau contenant les informations des posts]
   */
    public function getAllPost()
    {
      $result = $this->database->query(self::GET_ALL_POSTS);
      return($result);
    }

    public function getSortedPost(array $criterias)
    {
      $result = $this->database->query(self::GET_POST_SORTED,$criterias);
      return($result);
    }

    public function getLastPost()
    {
      $result = $this->database->query(self::GET_LAST_POST);
      return($result);
    }


    /**
     * Permet de récupérer un post en fonction de son id
     * @param  [array] $criterias [id du post]
     * @return [array]            [tableau contenant les informations du post]
     */
    public function getOnePost(array $criterias)
    {
      $result=$this->database->query(self::GET_ONE_POST,$criterias);
      return($result);
    }

    /**
     * Permet de récupérer les posts d'une catégorie définie
     * @param  [array] $criterias [critères de recherche (id de la catégorie)]
     * @return [array]            [tableau contenant les informations des posts récupérés]
     */
    public function getCategoryPost(array $criterias)
    {
      $result=$this->database->query(self::GET_POST_CATEGORY,$criterias);
      return($result);
    }

    /**
     * Permet de récupérer les articles rédigés par un user
     * @param  [array] $criterias [critères de recherche (id du user)]
     * @return [array]            [tableau contenant les informations des posts récupérés]
     */
    public function getRedactorPost(array $criterias)
    {
      $result=$this->database->query(self::GET_POST_REDACTOR,$criterias);
      return($result);
    }

    /**
     * Permet de récupérer les articles rédigés par un user dans une catégorie
     * @param  [array] $criterias [critères de recherche (id du user et id de la category)]
     * @return [array]            [tableau contenant les informations des posts récupérés]
     */
    public function getRedactorCategoryPost(array $criterias)
    {
      $result=$this->database->query(self::GET_POST_REDACTOR_CATEGORY,$criterias);
      return($result);
    }

    /**
     * Permet de récupérer une liste de poste contenant la chaîne de caractère passée en paramètre
     * @param  [array] $criterias [tableau contenant la chaîne de caractère recherchée]
     * @return [type]            [description]
     */
    public function getResearchPost(array $criterias)
    {
      $criterias[0]="%".$criterias[0]."%";
      $result=$this->database->query(self::GET_POST_RESEARCH,$criterias);
      return($result);
    }

    /**
     * Créé un nouveau post dans la base de donnée.
     * @param  array  $values [tableau contenant les informations du nouveau post]
     * @return [type]         [id du post nouvellement créé]
     */
    public function insertNewPost(array $values)
    {
      $result=$this->database->executeSql(self::INSERT_NEW_POST,$values);
      return($result);
    }

    /**
     * Modifie un post identifié par son id.
     * @param  array  $values [tableau contenant les informations du post à modifier]
     * @return [type]         [tableau contenant les informations du post modifié]
     */
    public function updatePost(array $values)
    {
      $result=$this->database->executeSql(self::UPDATE_POST,$values);
      return($result);
    }

    public function updateThumbnail(array $inputFile)
    {
      $extension = explode("/",$inputFile['type']);
      $extension=$extension[1];

      $name=$inputFile['id'].".".$extension;

      $baseUrl='/images/posts/thumbnail/';
      $url=$baseUrl.$name;

      $scan = scandir("application/www/images/posts/thumbnail");
      foreach($scan as $value)
      {
        if (preg_match("/^([0-9+])\./",$value,$return))
        {
          unlink("application/www/images/posts/thumbnail/$value");
          break;
        }
      }
      $target = (new Http)->moveUploadedFile('postThumbnail',$baseUrl,$name);

      $newFile=[$baseUrl.$name,$inputFile['id']];
      $this->database->executeSql(self::UPDATE_POST_THUMBNAIL,$newFile);
    }
  }

 ?>
