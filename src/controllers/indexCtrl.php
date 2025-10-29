<?php
if (!empty($_SESSION['id'])) header('Location: bookList.php');

if (!empty($_POST)) {
  $user = new Models\User();
  $error = [];


  if (isset($_POST['register'])) {

    try {
      $user->setFirstname($_POST['firstname']);
    } catch (\Exception $e) {
      $error['firstname'] = $e->getMessage();
    }

    try {
      $user->setLastname($_POST['lastname']);
    } catch (\Exception $e) {
      $error['lastname'] = $e->getMessage();
    }

    try {
      $user->setEmail($_POST['email']);
    } catch (\Exception $e) {
      $error['email'] = $e->getMessage();
    }

    try {
      $user->setPassword($_POST['password'], $_POST['confirmPassword']);
    } catch (\Exception $e) {
      $error['password'] = $e->getMessage();
    }



    if (empty($error)) {
      try {
        if ($user->createUser()) {
          $userData = $user->getUserByEmail();
          if ($userData) {
            $_SESSION['id'] = $userData->id;
            redirectTo('book');
          } else {
            $error['global'] = 'Inscription réussie : vous pouvez vous connecté';
          }
        } else {
          $error['global'] = 'Une erreur est survenue, réessayer ultérieurement';
        }
      } catch (\Exception $e) {
        $error['email'] = $e->getMessage();
      }
    }
  } else if (isset($_POST['login'])) {
    # code...
  }
}

render('index', false, [
  'error' => $error
]);
