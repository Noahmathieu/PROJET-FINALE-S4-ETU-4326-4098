<?php
$typeOperations = $typeOperations ?? [];

ob_start();
?>
<div class="dual-grid">
    <section class="panel-card">
        <div class="panel-head">
            <div>
                <h3>Ajouter un type d'operation</h3>
                <p>Definissez les categories qui seront ensuite reliees aux frais.</p>
            </div>
        </div>

        <form class="form-grid" action="<?= base_url('typeOperation/ajouter') ?>" method="post">
            <div class="form-group">
                <label for="nomType">Nom du type</label>
                <input type="text" name="nomType" id="nomType" placeholder="Ex: Transfert" required>
            </div>

            <button class="primary-button" type="submit">Enregistrer le type</button>
        </form>
    </section>

    <section class="panel-card">
        <div class="section-head">
            <div>
                <h3>Types disponibles</h3>
                <p>Chaque type peut etre modifie ou supprime directement ici.</p>
            </div>
        </div>

        <div class="search-row">
            <input class="search-field" type="search" data-grid-search="#typeOperationList" placeholder="Rechercher un type d'operation">
        </div>

        <div id="typeOperationList" class="editable-list">
            <?php if (empty($typeOperations)): ?>
                <div class="empty-state">
                    <strong>Aucun type d'operation n'est defini.</strong>
                    <span>Ajoutez les categories de base pour structurer les frais et les historiques.</span>
                </div>
            <?php endif; ?>

            <?php foreach ($typeOperations as $typeOperation): ?>
                <article class="editable-card" data-search-item>
                    <form class="form-grid" action="<?= base_url('typeOperation/modifier/' . $typeOperation['id']) ?>" method="post">
                        <div class="form-group">
                            <label for="type-<?= $typeOperation['id'] ?>">Nom du type</label>
                            <input type="text" id="type-<?= $typeOperation['id'] ?>" name="nomType" value="<?= esc($typeOperation['nomType']) ?>" required>
                        </div>

                        <div class="inline-actions">
                            <button class="secondary-button" type="submit">Modifier</button>
                            <a class="danger-button" href="<?= base_url('typeOperation/supprimer/' . $typeOperation['id']) ?>" data-delete-confirm="Supprimer le type d'operation <?= esc($typeOperation['nomType']) ?> ?">Supprimer</a>
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
    'title' => "Gestion des types d'operation",
    'pageHeading' => "Gestion des types d'operation",
    'pageDescription' => 'Structurez les operations pour que les frais et historiques restent lisibles.',
    'activeMenu' => 'typeOperation',
    'content' => $content,
]);