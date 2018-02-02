<?php

class SaveController
{
  public function httpGetMethod(Http $http, array $queryFields)
  {
    $render = (new UserSession)->getAll();
    $flashbag = (new FlashBag)->add("Accès non autorisé");
    $http->redirectTo('');
    return($render);
  }

  public function httpPostMethod(Http $http, array $formFields)
  {
    $render = (new UserSession)->getAll();

    if(isset($_FILES['postThumbnail']))
    {
      if ($_FILES['postThumbnail']['error']==0)
      {

        $category = (new CategoryModel(new Database))->getCategoryId([$formFields['categories']]);

        $postForm = [$render['user']['id'],htmlentities($formFields['postTitle']),htmlentities($formFields['postResume']),
        $formFields['postContent'],$category['id']];

        $post = new PostsModel(new Database);
        $postId = $post->insertNewPost($postForm);

        $inputfile = $_FILES['postThumbnail'];
        $inputfile['id']=$postId;
        var_dump($inputfile);

        $post->updateThumbnail($inputfile);
        $http->redirectTO('');
      }
      else
      {
        $flashbag = (new Flashbag)->add("Erreur lors de l'enregistrement, veuillez réessayer");
      }
    }
    else
    {
      $flashbag = (new Flashbag)->add("Erreur lors de l'enregistrement, veuillez réessayer");
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
