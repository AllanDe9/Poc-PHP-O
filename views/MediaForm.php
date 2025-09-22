<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($media) ? 'Modifier' : 'Ajouter'; ?> un <?php echo $mediaType; ?></title>
</head>
<body>
    <h1><?php echo isset($media) ? 'Modifier' . htmlspecialchars($media->title) : 'Ajouter un ' . $mediaType; ?></h1>
    <form action="" method="post">
        <div>
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" required value="<?php echo isset($media) ? htmlspecialchars($media->title) : ''; ?>">
        </div>
        <div>
            <label for="author">Auteur :</label>
            <input type="text" id="author" name="author" required value="<?php echo isset($media) ? htmlspecialchars($media->author) : ''; ?>">
        </div>
        <div>
            <label for="available">Disponible :</label>
            <input type="checkbox" id="available" name="available" <?php echo (isset($media) && $media->available) ? 'checked' : ''; ?>>
        </div>
        <?php if ($mediaType === 'livre'): ?>
            <div>
                <label for="page_number">Nombre de pages :</label>
                <input type="number" id="page_number" name="page_number" min="1" value="<?php echo isset($media) ? htmlspecialchars($media->page_number) : ''; ?>">
            </div>
        <?php elseif ($mediaType === 'film'): ?>
            <div>
                <label for="duration">Durée (minutes) :</label>
                <input type="number" id="duration" name="duration" min="1" value="<?php echo isset($media) ? htmlspecialchars($media->duration) : ''; ?>">
            </div>
            <div>
                <label for="genre">Genre :</label>
                <select id="genre" name="genre">
                    <?php
                        foreach (Genre::cases() as $genre) {
                            $selected = (isset($media) && $media->genre === $genre->name) ? 'selected' : '';
                            echo '<option value="' . $genre->name . '" ' . $selected . '>' . $genre->value . '</option>';
                        }
                    ?>
                </select>
            </div>
        <?php elseif ($mediaType === 'album'): ?>
            <div>
                <label for="track_number">Nombre de pistes :</label>
                <input type="number" id="track_number" name="track_number" min="1" value="<?php echo isset($media) ? htmlspecialchars($media->track_number) : ''; ?>">
            </div>
            <div>
                <label for="editor">Label :</label>
                <input type="text" id="editor" name="editor" value="<?php echo isset($media) ? htmlspecialchars($media->editor) : ''; ?>">
            </div>
        <?php endif; ?>
        <button type="submit"><?php echo isset($media) ? 'Modifier' : 'Ajouter'; ?></button>
    </form>
</body>
</html>