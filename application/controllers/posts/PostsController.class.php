<?php

class PostsController
{
  public function httpGetMethod(Http $http, array $queryFields)
  {
    $render = (new UserSession)->getAll();
    $render['flashbag'] = new FlashBag;
    $posts = new PostsModel(new Database);
    $render['categories'] = (new CategoryModel(new Database))->getAllCategories();
    if (!empty($queryFields))
    {
      if (isset($queryFields['id']))
      {
        $render['posts'] = $posts->getOnePost([$queryFields['id']]);
      }
      else if (isset($queryFields['categoryId']))
      {
        $render['posts'] = $posts->getCategoryPost([$queryFields['categoryId']]);
      }
      else if (isset($queryFields['redactorId']))
      {
        $render['posts'] = $posts->getRedactorPost([$queryFields['redactorId']]);
      }
      else if (isset($queryFields['postTitle']))
      {
        $render['posts'] = $posts->getResearchPost([$queryFields['postTitle']]);
        if (empty($render['posts']))
        {
          $flashbag = (new Flashbag)->add("Aucun article ne correspond à votre recherche, vous pouvez réessayer");
          $http->redirectTo("posts");
        }
      }
    }
    else
    {
      $render['posts'] = $posts->getAllPost();
    }

    if (count($render['posts']) == 1)
    {
      $render['comments'] = (new CommentModel(new Database))->getComments([$render['posts'][0]['id']]);
    }
    // var_dump($render);
    return($render);
  }

  public function httpPostMethod(Http $http, array $formFields)
  {
    $render = (new UserSession)->getAll();
    $commentInput = [$formFields['commentContent'],$formFields['postId'],$render['user']['id']];
    $comment = (new CommentModel(new Database))->newComment($commentInput);
    if (count($comment) == 0)
    {
      $flashbag = (new Flashbag)->add("Erreur lors de l'ajout du commentaire");
    }
    $http->redirectTo("posts?id=".$formFields['postId']);
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
