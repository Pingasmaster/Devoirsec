<?php
class Upload {
    private string $uploadDirectory = __DIR__ . '/../uploads/';
    private array $allowedExtensions = ['pdf'];
    private array $allowedMimeTypes = ['application/pdf'];

    public function upload(): bool {
        if (empty($_FILES['cv']) || empty($_POST['lastname']) || empty($_POST['firstname'])) { $_SESSION['message'] = 'Merci de remplir tous les champs'; return false; }
        if (!is_uploaded_file($_FILES['cv']['tmp_name'])) { $_SESSION['message'] = 'Erreur lors de l\'upload'; return false; }
        if (filesize($_FILES['cv']['tmp_name']) > 1000000) { $_SESSION['message'] = 'Le fichier est trop volumineux (1Mo max)'; return false; }
        $extension = strtolower(pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $this->allowedExtensions)) { $_SESSION['message'] = 'Le fichier doit être un PDF'; return false; }
        $mime = mime_content_type($_FILES['cv']['tmp_name']);
        if (!in_array($mime, $this->allowedMimeTypes)) { $_SESSION['message'] = 'Le fichier doit être un PDF'; return false; }
        if (!is_dir($this->uploadDirectory)) { mkdir($this->uploadDirectory, 0775, true); }
        $lastname = preg_replace('/[^a-z]/i', '', $_POST['lastname']);
        $firstname = preg_replace('/[^a-z]/i', '', $_POST['firstname']);
        $uniqId = bin2hex(random_bytes(8));
        $filename = 'cv_' . $lastname . '_' . $firstname . '_' . $uniqId . '.' . $extension;
        $destination = $this->uploadDirectory . $filename;
        if (!move_uploaded_file($_FILES['cv']['tmp_name'], $destination)) { $_SESSION['message'] = 'Erreur lors de l\'upload'; return false; }
        return true;
    }
}
