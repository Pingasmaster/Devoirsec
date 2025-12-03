<?php
// sessions pour messages
session_start();
$message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../src/Upload.php';
    $upload = new Upload();
    $message = $upload->upload() ? 'Votre CV a bien été uploadé.' : $_SESSION['message'];
}
unset($_SESSION['message']);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload de CV</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">
</head>
<body>
<h1>Upload de CV</h1>
<hr/>
<h3>Candidat</h3>
<p>Merci d'uploader votre CV par ce formulaire</p>
<form action="" method="post" enctype="multipart/form-data">
    <label for="lastname">Votre nom</label>
    <input type="text" name="lastname" id="lastname" required>
    <label for="firstname">Votre prénom</label>
    <input type="text" name="firstname" id="firstname" required>
    <label for="cv">Votre CV</label>
    <input type="file" name="cv" id="cv" accept="application/pdf" required>
    <input type="submit" value="Envoyer">
</form>
<?php if ($message): ?>
<div>
    <?= htmlspecialchars($message, ENT_QUOTES); ?>
</div>
<?php endif; ?>
</body>
</html>
