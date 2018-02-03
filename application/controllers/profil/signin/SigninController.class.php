<?php

class SigninController
{
    public function httpGetMethod(Http $http, array $queryFields)
    {
      $render['flashbag'] = new FlashBag;
    	return($render);
    }

    public function httpPostMethod(Http $http, array $formFields)
    {
      $render['flashbag'] = new FlashBag;
      $user= new UserModel(new Database);
      $connectForm=[$formFields['mail'],$formFields['password']];
      $user->connectUser($connectForm,$http);
      return($render);
    	/*
    	 * Méthode appelée en cas de requête HTTP POST
    	 *
    	 * L'argument $http est un objet permettant de faire des redirections etc.
    	 * L'argument $formFields contient l'équivalent de $_POST en PHP natif.
    	 */
    }
}

?>
