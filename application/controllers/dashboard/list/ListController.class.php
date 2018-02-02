<?php

class ListController
{
  public function httpGetMethod(Http $http, array $queryFields)
  {
    $render = (new UserSession)->getAll();

    if ($render['user']['rights'] != 'administrator')
    {
      $flashbag = (new FlashBag)->add("Accès non autorisé");
      $http->redirectTo('');
    }
    else
    {
      if (empty($queryFields))
      {
        $http->redirectTo('dashboard');
      }
      else
      {
        $render['flashbag'] = new FlashBag;
        if (isset($queryFields['list']))
        {
          if($queryFields['list'] == 'posts')
          {
            $render['posts'] = (new PostsModel(new Database))->getAllPost();
          }
          else if ($queryFields['list'] == 'comments')
          {
            $render['comments'] = (new CommentModel(new Database))->getAllComments();
          }
          else if ($queryFields['list'] == 'reportedComments')
          {
            $render['reportedComments'] = (new CommentModel(new Database))->getReportedComments();
          }
          else if ($queryFields['list'] == 'categories')
          {
            $render['target'] = 'dashboard/list?list=categories';
            $render['categories']= (new CategoryModel(new Database))->getCategoriesDetails();
          }
          else if ($queryFields['list'] == 'user')
          {
            $render['target'] = 'dashboard/list?list=user';
            $render['userList'] = (new UserModel(new Database))->getAllUser();
          }
        }
        else if (isset($queryFields['categoryId']))
        {
            $render['posts'] = (new PostsModel(new Database))->getCategoryPost([$queryFields['categoryId']]);
        }
        else
        {
          $http->redirectTo('dashboard');
        }
      }
    }
    return($render);
  }

  public function httpPostMethod(Http $http, array $queryFields)
  {

  }
}

?>
