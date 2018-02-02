<?php

class UpdatepostController
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
    $post = new PostsModel(new Database);

        $category = (new CategoryModel(new Database))->getCategoryId([$formFields['categories']]);

        $postForm = [htmlentities($formFields['postTitle']),htmlentities($formFields['postResume']),
        $formFields['postContent'],$category['id'],$formFields['id']];

        $post->updatePost($postForm);
        var_dump($_FILES['postThumbnail']);
    if($_FILES['postThumbnail']['error'] == 0)
    {
      $inputfile = $_FILES['postThumbnail'];
      $inputfile['id']=$formFields['id'];

      $post->updateThumbnail($inputfile);

    }
        $http->redirectTO("posts");
    /*
     * Méthode appelée en cas de requête HTTP POST
     *
     * L'argument $http est un objet permettant de faire des redirections etc.
     * L'argument $formFields contient l'équivalent de $_POST en PHP natif.
     */
  }
}


 ?>
