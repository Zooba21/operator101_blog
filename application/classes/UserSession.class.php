<?php


class UserSession
{
	public function __construct()
	{
		if(session_status() == PHP_SESSION_NONE)
		{
            // Démarrage du module PHP de gestion des sessions.
			session_start();
		}
	}

/**
 * Créer le tableau de Session ($_SESSION) au moment de la connexion de l'utilisateur.
 * @param  [array] $sessionArray [contenu de la requête SQL permettant la connexion]
 * @return [void]               [Pas de return]
 */

    public function create(array $sessionArray)
    {
			foreach($sessionArray as $key=>$value)
			{
				$_SESSION['user'][$key]=$value;
			}
			if (!isset($_SESSION['user']['avatarUrl']))
			{
				if(empty($_SESSION['user']['avatarUrl']))
				{
					$_SESSION['user']['avatarUrl'] = "images/user/no-photo.png";
				}
			}

    }

    public function destroy()
    {
        // Destruction de l'ensemble de la session.
        $_SESSION = array();

				if (ini_get("session.use_cookies"))
				{
				    $params = session_get_cookie_params();
				    setcookie(session_name(), '', time() - 42000,
				        $params["path"], $params["domain"],
				        $params["secure"], $params["httponly"]
				    );
				}

        session_destroy();
    }

    public function getEmail()
    {
        if($this->isAuthenticated() == false)
        {
            return null;
        }

        return $_SESSION['user']['Email'];
    }

    public function getFirstName()
    {
        if($this->isAuthenticated() == false)
        {
            return null;
        }

        return $_SESSION['user']['FirstName'];
    }

    public function getFullName()
    {
        if($this->isAuthenticated() == false)
        {
            return null;
        }

        return $_SESSION['user']['FirstName'].' '.$_SESSION['user']['LastName'];
    }

    public function getLastName()
    {
        if($this->isAuthenticated() == false)
        {
            return null;
        }

        return $_SESSION['user']['LastName'];
    }

    public function getUserId()
    {
        if($this->isAuthenticated() == false)
        {
            return null;
        }

        return $_SESSION['user']['UserId'];
    }

	public function isAuthenticated()
	{
		if(array_key_exists('user', $_SESSION) == true)
		{
			if(empty($_SESSION['user']) == false)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Renvoi le contenu du tableau de Session dans une variable Render. Cette variable doit être retournée dans la méthode HttpGetMethod du Controller pour permettre le maintien de la connexion. La commande a exécuter dans le controller est la suivante :
	 * $render = (new UserSession)->getAll();
	 * Cette commande doit être présente au départ de chacune des class de type controller.
	 * @param  array  $render [contenu du $render]
	 * @return [array]         [$render est un tableau associatif auquel a été ajouté une clef 'user' si l'utilisateur est connecté. Dans le cas contraire, celui-ci est vide.]
	 */
	public function getAll(array $render = [])
	{
		if ($this->isAuthenticated())
		{
			return array_merge($render, ['user'=>$_SESSION['user']]);
		}
		else
		{
			return $render;
		}
	}
}
