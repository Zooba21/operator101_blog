<?php

class DashboardController
{
  public function httpGetMethod(Http $http, array $queryFields)
  {
    $render = (new UserSession)->getAll();
    $render['target'] = 'dashboard';

    if(!empty($render['user']))
    {
      if ($render['user']['rights'] != 'administrator')
      {
        $flashbag = (new FlashBag)->add("Accès non autorisé");
        $http->redirectTo('');
      }
      else
      {
        $render['flashbag'] = new FlashBag;
        $render['comments'] = (new CommentModel(new Database))->getLastComments();
        $render['reportedComments'] = (new CommentModel(new Database))->getLastReportedComments();
        $render['posts'] = (new PostsModel(new Database))->getLastPost();
        $render['categories'] = (new CategoryModel(new Database))->getLastCategoriesDetails();
      }
    }
    else
    {
      $flashbag = (new FlashBag)->add("Vous devez être connecté en tant qu'administrateur pour accéder à cette page.");
      $http->redirectTo('');
    }

    return($render);
  }

  public function httpPostMethod(Http $http, array $queryFields)
  {
    if ($queryFields['mode']=='add')
    {
      $category = (new CategoryModel(new Database))->insertCategory([$queryFields['categoryName']]);
      $flashbag = (new FlashBag)->add('Votre catégorie a bien été créée');
      $http->redirectTo($queryFields['target']);
    }
    else if($queryFields['mode']=='update')
    {
      $category = (new CategoryModel(new Database))->updateCategory([$queryFields['categoryId']]);
      $flashbag = (new FlashBag)->add('Votre catégorie a bien été modifiée');
      $http->redirectTo($queryFields['target']);
    }
    else if($queryFields['mode']=='delete')
    {
      $category = (new CategoryModel(new Database))->deleteCategory([$queryFields['id']]);
      $flashbag = (new FlashBag)->add('Votre catégorie a bien été supprimée');
      $http->redirectTo($queryFields['target']);
    }


  }
}

?>
