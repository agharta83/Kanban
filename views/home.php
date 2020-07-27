<div class="container">
    <?php foreach($viewVars as $list): ?>
        <div class="list" data-id="<?=$list->id?>">
            <h2>
                <span><?=$list->name?></span>
                <i class="fas fa-edit editTitle"></i>
            </h2>
            <form class="editList">
                <input type="text" class="list-input" value="<?=$list->name?>">
                <button>Ok</button>
                <button type="button" class="cancel">Annuler</button>
            </form>
            <ul class="list-cards">

                <?php foreach( $list->getCards() as $card ): ?>
                    <li class="list-cards-card" data-id="<?=$card->id?>">
                        <div>
                            <span><?=$card->title?></span>
                            <i class="fas fa-edit edit-card"></i>
                        </div>
                    </li>
                <?php endforeach; ?>

                <li class="create-card">
                    <form>
                        <input type="text" name="" value="" placeholder="Acheter du lait">
                        <button>Ok</button>
                    </form>
                </li>
            </ul>
        </div>
    <?php endforeach; ?>

    <div class="list create">
        <button>
            <i class="fas fa-plus"></i>
            <span>Créer une liste</span>
        </button>
    </div>
</div>
