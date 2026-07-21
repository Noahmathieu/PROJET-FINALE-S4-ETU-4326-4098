
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Epargne</h1>
    
    <form action="<?= base_url('/client/epargne/validate'); ?>" method="post">
        <label>Vos epargne</label>
        <input type="text" value="<?= $epargne['epargne'] ?>" name="epargne" id="">
        <button type="submit">Valider</button>
    </form>
</body>
</html>