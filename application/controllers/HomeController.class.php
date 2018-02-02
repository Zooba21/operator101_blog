<?php

class HomeController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
      $render = (new UserSession)->getAll();

      $render['flashbag'] = new FlashBag;

    	return($render);
    }

    public function httpPostMethod(Http $http, array $formFields)
    {
      $render['flashbag'] = new FlashBag;

      return($render);
    	/*
    	 * Méthode appelée en cas de requête HTTP POST
    	 *
    	 * L'argument $http est un objet permettant de faire des redirections etc.
    	 * L'argument $formFields contient l'équivalent de $_POST en PHP natif.
    	 */
    }
}
