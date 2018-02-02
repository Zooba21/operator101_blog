<?php

class SignoutController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
      $session = (new UserSession)->destroy();
    	$http->redirectTo('');
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
