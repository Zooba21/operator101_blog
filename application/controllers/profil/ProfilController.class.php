<?php

class ProfilController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
      $render = (new UserSession)->getAll();
      $render['user']['postNumber'] = ((new PostsModel(new Database))->getPostNumber([$render['user']['id']]))['postNumber'];

      if(!isset($_SESSION['user']))
      {
        $flashbag = (new FlashBag)->add("Vous devez être connecté pour accéder à cette page");
        $http->redirectTo('');
      }
      $render['flashbag'] = new FlashBag;
    	return($render);
    }

    public function httpPostMethod(Http $http, array $formFields)
    {
    	/*
    	 * Méthode appelée en cas de requête HTTP POST
    	 *
    	 * L'argument $http est un objet permettant de faire des redirections etc.
    	 * L'argument $formFields contient l'équivalent de $_POST en PHP natif.
    	 */
    }
}

?>
