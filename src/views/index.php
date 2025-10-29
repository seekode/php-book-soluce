<?php ob_start() ?>

<h1>Création</h1>
<?php if (!empty($error) && !empty($error['global'])) { ?>
	<h2><?= $error['global'] ?></h2>
<?php } ?>


<form method="POST">
	<label for="firstname">Prénom</label>
	<input id="firstname" type="text" name="firstname" placeholder="Prénom" value="<?= !empty($_POST['firstname']) ? $_POST['firstname'] : '' ?>" required>
	<?php if (!empty($error) && !empty($error['firstname'])) { ?>
		<small><?= $error['firstname'] ?></small>
	<?php } ?>
	<label for="lastname">Nom</label>
	<input id="lastname" type="text" name="lastname" placeholder="Nom" value="<?= !empty($_POST['lastname']) ? $_POST['lastname'] : '' ?>" required>
	<?php if (!empty($error) && !empty($error['lastname'])) { ?>
		<small><?= $error['lastname'] ?></small>
	<?php } ?>
	<label for="email">Email</label>
	<input id="email" type="email" name="email" placeholder="Email" value="<?= !empty($_POST['email']) ? $_POST['email'] : '' ?>" required>
	<?php if (!empty($error) && !empty($error['email'])) { ?>
		<small><?= $error['email'] ?></small>
	<?php } ?>
	<label for="password">Mot de passe</label>
	<input id="password" type="password" name="password" placeholder="Mot de passe" required>
	<?php if (!empty($error) && !empty($error['password'])) { ?>
		<small><?= $error['password'] ?></small>
	<?php } ?>
	<label for="password">Confirmation du mot de passe</label>
	<input id="confirmPassword" type="password" name="confirmPassword" placeholder="Mot de passe" required>
	<?php if (!empty($error) && !empty($error['confirmPassword'])) { ?>
		<small><?= $error['confirmPassword'] ?></small>
	<?php } ?>
	<button name="register" type="submit">Créer un compte</button>
</form>

<h1>Connexion</h1>
<form>
	<label for="email">Email</label>
	<input id="email" type="email" name="login_email" placeholder="Email" required>
	<label for="password">Mot de passe</label>
	<input id="password" type="password" name="login_password" placeholder="Mot de passe" required>
	<button name="login" type="submit">Créer un compte</button>
</form>

<?php render('default', true, [
	'title' => 'Connextion',
	'link' => '<link rel="stylesheet" href="assets/css/index.css">',
	'content' => ob_get_clean(),
]);
?>