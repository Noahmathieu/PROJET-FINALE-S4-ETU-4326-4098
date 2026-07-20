<?php
$frais = $frais ?? [];
$typeOperations = $typeOperations ?? [];

ob_start();
?>
<div class="stack-grid">
    <section class="panel-card">
        <div class="panel-head">
            <div>
                <h3>Ajouter un frais</h3>
                <p>Chaque intervalle est associe a un type d'operation et a sa valeur de commission.</p>
            </div>
        </div>

        <form class="form-grid columns-3" action="<?= base_url('frais/ajouter') ?>" method="post">
            <div class="form-group">
                <label for="frais-type">Type d'operation</label>
                <select name="id_type_operation" id="frais-type" required>
                    <option value="">Selectionner</option>
                    <?php foreach ($typeOperations as $typeOperation): ?>
                        <option value="<?= $typeOperation['id'] ?>"><?= esc($typeOperation['nomType']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="frais-min">Montant minimum</label>
                <input type="number" step="0.01" name="montant_Min" id="frais-min" placeholder="0.00" required>
            </div>

            <div class="form-group">
                <label for="frais-max">Montant maximum</label>
                <input type="number" step="0.01" name="montant_Max" id="frais-max" placeholder="0.00" required>
            </div>

            <div class="form-group">
                <label for="frais-valeur">Valeur du frais</label>
                <input type="number" step="0.01" name="valeur" id="frais-valeur" placeholder="0.00" required>
            </div>

            <div class="inline-actions">
                <button class="primary-button" type="submit">Ajouter le frais</button>
            </div>
        </form>
    </section>

    <section class="panel-card">
        <div class="section-head">
            <div>
                <h3>Liste des frais</h3>
                <p>Modifiez les plages et les montants sans quitter la page.</p>
            </div>
        </div>

        <div class="search-row">
            <input class="search-field" type="search" data-grid-search="#fraisList" placeholder="Filtrer par type ou plage de montant">
        </div>

        <div id="fraisList" class="editable-list">
            <?php if (empty($frais)): ?>
                <div class="empty-state">
                    <strong>Aucun frais n'est defini.</strong>
                    <span>Ajoutez les frais par intervalle pour chaque type d'operation.</span>
                </div>
            <?php endif; ?>

            <?php foreach ($frais as $item): ?>
                <article class="editable-card" data-search-item>
                    <form class="form-grid columns-3" action="<?= base_url('frais/modifier/' . $item['id']) ?>" method="post">
                        <div class="form-group">
                            <label for="frais-type-<?= $item['id'] ?>">Type d'operation</label>
                            <select name="id_type_operation" id="frais-type-<?= $item['id'] ?>" required>
                                <?php foreach ($typeOperations as $typeOperation): ?>
                                    <option value="<?= $typeOperation['id'] ?>" <?= (int) $typeOperation['id'] === (int) $item['id_type_operation'] ? 'selected' : '' ?>>
                                        <?= esc($typeOperation['nomType']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="frais-min-<?= $item['id'] ?>">Montant minimum</label>
                            <input type="number" step="0.01" name="montant_Min" id="frais-min-<?= $item['id'] ?>" value="<?= esc($item['montant_Min']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="frais-max-<?= $item['id'] ?>">Montant maximum</label>
                            <input type="number" step="0.01" name="montant_Max" id="frais-max-<?= $item['id'] ?>" value="<?= esc($item['montant_Max']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="frais-valeur-<?= $item['id'] ?>">Valeur</label>
                            <input type="number" step="0.01" name="valeur" id="frais-valeur-<?= $item['id'] ?>" value="<?= esc($item['valeur']) ?>" required>
                        </div>

                        <div class="inline-actions">
                            <button class="secondary-button" type="submit">Modifier</button>
                            <a class="danger-button" href="<?= base_url('frais/supprimer/' . $item['id']) ?>" data-delete-confirm="Supprimer ce frais ?">Supprimer</a>
                        </div>
                    </form>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</div>
<?php
$content = ob_get_clean();

echo view('operateur/_layout', [
    'title' => 'Gestion des frais',
    'pageHeading' => 'Gestion des frais',
    'pageDescription' => 'Ajoutez, modifiez et supprimez les commissions appliquees aux operations.',
    'activeMenu' => 'frais',
    'content' => $content,
]);