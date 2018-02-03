<?php

class SignupController
{
  public function httpGetMethod(Http $http, array $queryFields)
  {
    $render = (new UserSession)->getAll();
    if(isset($_SESSION['user']))
    {
      $http->redirectTO('profil');
    }
    return($render);
  }

  public function httpPostMethod(Http $http, array $formFields)
  {
    if($formFields['password'] == $formFields['passwordControl'])
    {
      $user = new UserModel(new Database);
      $signupForm=[$formFields['firstName'],$formFields['lastName'],$formFields['mail'],password_hash($formFields['password'],PASSWORD_DEFAULT)];
      $result = $user->signUp($signupForm);
      if ($result)
      {
          $flashbag = (new FlashBag(new Database))->add("Votre compte a été créé, vous pouvez vous connecter");
          $http->redirectTo('');
      }
      else
      {
        $flashbag = (new FlashBag(new Database))->add("Erreur lors de la création du compte, veuillez rééessayer");
        $http->redirectTo('profile/sgnup');
      }
    }
    else
    {
        $flashbag = (new FlashBag(new Database))->add("Les mots de passe ne correspondent pas");
        $http->redirectTo('profil/signup');
    }
    /*
     * Méthode appelée en cas de requête HTTP POST
     *
     * L'argument $http est un objet permettant de faire des redirections etc.
     * L'argument $formFields contient l'équivalent de $_POST en PHP natif.
     */
  }
}


 ?>
