<?php

  class UpdateuserController
  {
    public function httpGetMethod(Http $http, array $queryFields)
    {
      $render = (new UserSession)->getAll();
      $http->redirectTo('user/userhome');



       /*
    	 * Méthode appelée en cas de requête HTTP GET
    	 *
    	 * L'argument $http est un objet permettant de faire des redirections etc.
    	 * L'argument $queryFields contient l'équivalent de $_GET en PHP natif.
    	 */

    	  return $render;
    }

/**
 * Mise à jour du profil utilisateur selon les informations saisies dans le formulaire.
 * @param  Http   $http       [description]
 * @param  array  $formFields [description]
 * @return [type]             [description]
 */
    public function httpPostMethod(Http $http, array $formFields)
    {

      /*Récupération de la session en cours*/
      $render = (new UserSession)->getAll();

      /*Déclaration des class*/
      $user = new UserModel(new Database);
      if ($formFields['mode'] == "updateUser")
      {
        unset($formFields['mode']);
        $user->UpdateUser($formFields);

        /*Gestion du $_FILES*/
        if ($_FILES['avatar']['error']==0)
        {
          $inputFile=$_FILES['avatar'];
          $inputFile['id']=$render['user']['id'];
          var_dump($inputFile);
          $user->updateAvatar($inputFile);
        }

        /*Mise à jour du $_SESSION*/

        $result = $user->updateSession([$_SESSION['user']['id']]);
        $_SESSION['user']=$result;
        $render['user']=$result;

        if(empty($_SESSION['user']['avatarUrl']))
        {
          $_SESSION['user']['avatarUrl']="images/user/no-photo.png";
        }
      }
      else if ($formFields['mode'] == "updatePassword")
      {
        $password = $user->UpdatePassword($formFields);
      }
      /*Mise à jour du profil utilisateur*/



       /*
    	 * Méthode appelée en cas de requête HTTP POST
    	 *
    	 * L'argument $http est un objet permettant de faire des redirections etc.
    	 * L'argument $formFields contient l'équivalent de $_POST en PHP natif.
    	 */
    	$http->redirectTo('profil');
    	return $render;
    }
  }

?>
