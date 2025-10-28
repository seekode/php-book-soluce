<?php
session_start();

if (!empty($_SESSION['id'])) header('Location: bookList.php');

if (!empty($_POST)) {
  require 'models/User.php';
  $error = [];


  if (isset($_POST['register'])) {
    if (!empty($_POST['firstname'])) {
      if (strlen($_POST['firstname']) <= 50) {
        $firstname = $_POST['firstname'];
      } else {
        $error['firstname'] = 'Le prénom doit faire 50 max';
      }
    } else {
      $error['firstname'] = 'Le prénom est obligatoire';
    }

    if (!empty($_POST['lastname'])) {
      if (strlen($_POST['lastname']) <= 50) {
        $lastname = $_POST['lastname'];
      } else {
        $error['lastname'] = 'Le nom de famille doit faire 50 max';
      }
    } else {
      $error['lastname'] = 'Le nom de famille est obligatoire';
    }

    if (!empty($_POST['email'])) {
      if (strlen($_POST['email']) <= 255) {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
          if (!getUserByEmail($_POST['email'])) {
            $email = $_POST['email'];
          } else {
            $error['email'] = 'Email déjà utilisé';
          }
        } else {
          $error['email'] = 'Email invalide';
        }
      } else {
        $error['email'] = 'Le email doit faire 255 max';
      }
    } else {
      $error['email'] = 'L email est obligatoire';
    }

    if (!empty($_POST['password'])) {
      if (strlen($_POST['password']) >= 3) {
        if (!empty($_POST['confirmPassword'])) {
          if ($_POST['password'] === $_POST['confirmPassword']) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
          } else {
            $error['confirmPassword'] = 'La confirmation de mot de passe ne correspond pas';
          }
        } else {
          $error['confirmPassword'] = 'La confirmation de mot de passe est obligatoire';
        }
      } else {
        $error['password'] = 'Le mot de passe doit faire 3 min';
      }
    } else {
      $error['password'] = 'Le mot de passe est obligatoire';
    }

    if (empty($error)) {
      if (createUser($firstname, $lastname, $email, $password)) {
        $user = getUserByEmail($email);
        if ($user) {
          $_SESSION['id'] = $user->id;
        } else {
          $error['global'] = 'Inscription réussie : vous pouvez vous connecté';
        }
      } else {
        $error['global'] = 'Une erreur est survenue, réessayer ultérieurement';
      }
    }
  } else if (isset($_POST['login'])) {
    # code...
  }
}
