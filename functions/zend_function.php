<?
//phan post len blog
function createDraftPost($title='Salutations, world!', $content='Hmm ... not quite right, must rework the title later.')
{
  global $gdClient;
  global $blogID;
  $uri = 'http://www.blogger.com/feeds/' . $blogID . '/posts/default';
  $entry = $gdClient->newEntry();

  $entry->title = $gdClient->newTitle(trim($title));
  $entry->content = $gdClient->newContent($content);
  $entry->content->setType('text');

  $control = $gdClient->newControl();
  $draft = $gdClient->newDraft('no');
  $control->setDraft($draft);
  $entry->control = $control;

  $createdPost = $gdClient->insertEntry($entry, $uri);
  $idText = explode('-', $createdPost->id->text);
  return $idText[2];
}

//ham post comment
function createComment($gdClient, $blogID, $postID, $commentText)
{
  $uri = 'http://www.blogger.com/feeds/' . $blogID . '/' . $postID . '/comments/default';

  $newComment = $gdClient->newEntry();
  $newComment->content = $gdClient->newContent($commentText);
  $newComment->content->setType('text');
  $createdComment = $gdClient->insertEntry($newComment, $uri);

  $editLink = explode('/', $createdComment->getEditLink()->href);
  $newCommentID = $editLink[8];

  return $newCommentID; 
}