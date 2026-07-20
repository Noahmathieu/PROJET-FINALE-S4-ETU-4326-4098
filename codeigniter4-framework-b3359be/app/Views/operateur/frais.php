<?php
$frais = $frais ?? [];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Frais</title>
</head>

<body>
    <div id="add-form-container" class="add-form-container" style="display: none; margin-bottom: 15px;">
        <h3>Ajouter un nouveau frais</h3>
        <form id="addFraisForm" onsubmit="addFrais(event)">
            <input type="number" step="0.01" name="montant_Min" placeholder="Montant Min" required>
            <input type="number" step="0.01" name="montant_Max" placeholder="Montant Max" required>
            <input type="number" step="0.01" name="valeur" placeholder="Valeur" required>
            <button type="submit">Enregistrer</button>
            <button type="button" onclick="toggleAddForm()">Annuler</button>
        </form>
    </div>

    <button type="button" onclick="toggleAddForm()">Ajouter</button>

    <table border="1">
        <thead>
            <tr>
                <th>Montant Min</th>
                <th>Montant Max</th>
                <th>Valeur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="fraisTableBody">
            <?php foreach ($frais as $item): ?>
                <tr id="ligne/<?= $item['id'] ?>">
                    <td>
                        <input type="number" step="0.01" name="montant_Min" value="<?= htmlspecialchars($item['montant_Min']) ?>">
                    </td>
                    <td>
                        <input type="number" step="0.01" name="montant_Max" value="<?= htmlspecialchars($item['montant_Max']) ?>">
                    </td>
                    <td>
                        <input type="number" step="0.01" name="valeur" value="<?= htmlspecialchars($item['valeur']) ?>">
                    </td>
                    <td>
                        <button type="button" onclick="editFrais(<?= $item['id'] ?>)">Modifier</button>
                        <button type="button" onclick="deleteFrais(<?= $item['id'] ?>)">Supprimer</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <script>
        function toggleAddForm() {
            const container = document.getElementById('add-form-container');
            if (container.style.display === 'none' || container.style.display === '') {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        function addFrais(event) {
            event.preventDefault();

            const form = document.getElementById('addFraisForm');
            const formData = new FormData(form);

            fetch('<?= base_url('frais/ajouter') ?>', {
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

        function editFrais(id) {
            const row = document.getElementById(`ligne/${id}`);

            const formData = new FormData();
            formData.append('id', id);
            formData.append('montant_Min', row.querySelector('input[name="montant_Min"]').value);
            formData.append('montant_Max', row.querySelector('input[name="montant_Max"]').value);
            formData.append('valeur', row.querySelector('input[name="valeur"]').value);

            fetch('<?= base_url('frais/modifier/') ?>' + id, {
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

        function deleteFrais(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce frais ?')) {
                fetch('<?= base_url('frais/supprimer/') ?>' + id, {
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