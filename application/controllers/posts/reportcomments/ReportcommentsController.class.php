<?php

class ReportcommentsController
{
  public function httpGetMethod(Http $http, array $queryFields)
  {
    $flashbag = (new FlashBag)->add("Accès non autorisé");
    $http->redirectTo('');
  }

  public function httpPostMethod(Http $http, array $queryFields)
  {
    $user = (new UserSession)->getAll();

    if ($queryFields['mode'] == "report")
    {
      $comments = (new CommentModel(new Database))->reportComment([$queryFields['idComment']]);
      $flashbag = (new FlashBag)->add("Le commentaire sélectionné a bien été signalé. Merci de nous avoir prévenu.");
      $http->redirectTO($queryFields['target']);
    }
    else if($queryFields['mode'] == "unreport")
    {
      $comments = (new CommentModel(new Database))->unreportComment([$queryFields['idComment']]);
      $flashbag = (new FlashBag)->add("Le commentaire sélectionné a bien été réintégré.");
      $http->redirectTO($queryFields['target']);
    }
    else if($queryFields['mode'] == "ban")
    {
      $comments = (new CommentModel(new Database))->banComment([$queryFields['idComment']]);
      $flashbag = (new FlashBag)->add("Le signalement a bien été confirmé.");
      $http->redirectTO($queryFields['target']);
    }
    else
    {
      $flashbag = (new FlashBag)->add("Accès non autorisé");
      $http->redirectTO($queryFields['target']);
    }
  }
  }
