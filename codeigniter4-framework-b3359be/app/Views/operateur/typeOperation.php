<?php 
$typeOperations = $typeOperations ?? []; 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Type d'Opération</title>
</head>
<body>
    <h1>CRUD Type d'Opération</h1>
    
    <button type="button" onclick="toggleAddForm()">Ajouter un nouveau type d'opération</button>
    <br><br>

    <form id="addTypeOperationForm" onsubmit="addTypeOperation(event)" style="display: none; margin-bottom: 20px;">
        <input type="text" name="nomType" placeholder="Nom du type d'opération" required>
        <button type="submit">Enregistrer</button>
        <button type="button" onclick="toggleAddForm()">Annuler</button>
    </form>

    <div id="typeOperationsList">
        <?php foreach ($typeOperations as $typeOperation): ?>
            <div id="ligne/<?= $typeOperation['id'] ?>" style="margin-bottom: 10px;">
                <input type="text" name="nomType" value="<?= htmlspecialchars($typeOperation['nomType']) ?>">
                <button type="button" onclick="editTypeOperation(<?= $typeOperation['id'] ?>)">Modifier</button>
                <button type="button" onclick="deleteTypeOperation(<?= $typeOperation['id'] ?>)">Supprimer</button>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        function toggleAddForm() {
            const container = document.getElementById('addTypeOperationForm');
            if (container.style.display === 'none' || container.style.display === '') {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        function addTypeOperation(event) {
            event.preventDefault();

            const form = document.getElementById('addTypeOperationForm');
            const formData = new FormData(form);

            fetch('<?= base_url('typeOperation/ajouter') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        form.reset();
                        toggleAddForm(); 
                        location.reload(); 
                    } else {
                        alert('Erreur lors de l\'ajout');
                    }
                })
                .catch(error => console.error('Erreur :', error));
        }

        function editTypeOperation(id) {
            const row = document.getElementById(`ligne/${id}`);

            const formData = new FormData();
            formData.append('nomType', row.querySelector('input[name="nomType"]').value);

            fetch('<?= base_url('typeOperation/modifier/') ?>' + id, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                    } else {
                        alert('Erreur lors de la modification');
                    }
                })
                .catch(error => console.error('Erreur :', error));
        }

        function deleteTypeOperation(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce type d\'opération ?')) {
                fetch('<?= base_url('typeOperation/supprimer/') ?>' + id, {
                        method: 'GET'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            document.getElementById(`ligne/${id}`).remove();
                        } else {
                            alert('Erreur lors de la suppression');
                        }
                    })
                    .catch(error => console.error('Erreur :', error));
            }
        }
   </script>
</body>
</html>