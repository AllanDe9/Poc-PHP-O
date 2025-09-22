<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($song) ? 'Modifier' : 'Ajouter'; ?> une chanson</title>
</head>
<body>
    <h1><?php echo isset($song) ? 'Modifier' . htmlspecialchars($song->getTitle()) : 'Ajouter une chanson à l\'album ' . htmlspecialchars($album->getTitle()); ?></h1>
    <form action="" method="post">
        <div>
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" required value="<?php echo isset($song) ? htmlspecialchars($song->getTitle()) : ''; ?>">
        </div>
        <div>
            <label for="notation">Notation sur 10 :</label>
            <input type="number" id="notation" name="notation" min="0" max="10" required value="<?php echo isset($song) ? htmlspecialchars($song->getNotation()) : ''; ?>">
        </div>
        <div>
            <button type="submit"><?php echo isset($song) ? 'Modifier' : 'Ajouter'; ?> la chanson</button>
        </div>
    </form>
</body>
</html>
