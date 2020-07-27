var app = {
  positions: {},
  init: function() {

    // setTimeout(app.testAjax, 2000);
    // app.testAjax();

    $('.create-card form').on('submit', app.createCard);
    // On gère les actions de modification du titre d'une liste
    $('.editTitle').on('click', app.showFormTitle);
    $('.cancel').on('click', app.hideFormTitle);
    $('.editList').on('submit', app.editTitle);
    // On gère la modification du contenu d'une carte
    $('.edit-card').on('click', app.showFormCard)

    $( ".list-cards" ).sortable({
      connectWith: '.list-cards',
      update: app.updateList,
      stop: app.stopList
    });
  },

  // Affiche le formulaire de modification d'une carte
  showFormCard: function() {

    // On cible le conteneur de la carte
    var div = $(this).parent();

    // On récupère le texte de la carte
    var text = div.find('span').text();

    // On construit le formulaire
    var template = `
      <form>
        <input type="text" value="${text}"/>
        <button class="valid-card">Ok</button>
        <button type="button" class="cancel-card">Annuler</button>
      </form>
    `;

    // On affiche le formulaire
    var form = $( template );

    // On gère le clic sur le bouton annuler
    form.find('.cancel-card').on('click', function() {
      // On supprime le formulaire pour
      // éviter la création de doublons
      form.remove();
      // On ré-affiche le contenu de la carte
      div.show();
    });

    // On gère la validation du formulaire
    form.on('submit', app.updateCard);

    // On affiche le formulaire dans le DOM
    div.after( form );

    // On masque le contenu de la carte
    div.hide();
  },

  // Met à jour le contenu d'une carte
  updateCard: function( evt ) {

    // On empêche le rechargement de la page
    evt.preventDefault();

    // On récupère le nouveau contenu de la carte
    var text = $(this).find('input').val();

    // On récupère l'identifiant de la carte
    var cardId = $(this).parent().data('id');

    // On construit une requête AJAX avec tout ça
    $.ajax('card/' + cardId + '/update', {
      method: 'post',
      data: { title: text }
    })
    // On gère la réponse du serveur pour afficher
    // le nouveau contenu de la carte
    .done(function() {

      // Récupère le nouveau contenu de la carte et on l'affiche
      $(evt.target)
        .prev()
        .find('span')
        .text( text );

      // On masque le formulaire
      // $(evt.target).prev().show();
      // $(evt.target).remove();
      $(evt.target).find('.cancel-card').trigger('click');
    })
  },

  // Fonction qui s'exécute à chaque modification
  // dans une liste (changement de position de carte)
  updateList: function( evt, ui ) {

    // On récupère les cartes de cette
    // liste, et on enregistre leur position
    var cards = $(this).find('.list-cards-card');

    // On récupère l'identifiant de la liste
    var listId = $(this).parent().data('id');

    app.positions[ listId ] = {};
    // positions.12 = 0
    // positions.44 = 1
    cards.each(function(index, el) {

      // On récupère l'identifiant de la carte
      var id = $(el).data('id');
      // var pos = index;
      app.positions[ listId ][ id ] = index;
    });
  },

  stopList: function() {

    console.log('STOP');

    // On a trier une ou plusieurs listes, on
    // souhaite envoyer les informations au serveur
    $.ajax('card/positions', {
      method: 'post',
      data: { cards: app.positions }
    });
  },

  editTitle: function( evt ) {

    // On empêche le rechargement de la page
    evt.preventDefault();

    // On sauvegarde le ciblage du formulaire
    var form = $(this);

    // On récupère le nouveau titre
    var newTitle = $(this).find('.list-input').val();

    // On récupère l'identifiant de la liste
    var listId = $(this).parent().data('id');

    // On crée une requête AJAX pour envoyer
    // le nouveau titre au serveur
    $.ajax('list/' + listId + '/update', {
      method: 'post',
      data: { title: newTitle }
    })
    .done(function() {

      // Le serveur nous a répondu, on affiche
      // le nouveau titre à la place de l'ancien
      form.prev().find('span').text( newTitle );

      // On masque le formulaire
      // var btnCancel = form.find('.cancel').get(0);
      // On va redéfinir le "this" dans la fonction
      // "hideFormTitle" afin que tout se passe bien
      // En revanche, c'est une syntaxe qu'on est
      // pas sensé apprendre ! Donc pas de soucis
      // si on ne comprend pas !
      // app.hideFormTitle.bind( btnCancel )();

      // Ou on peut simuler le click sur le bouton annuler
      form.find('.cancel').trigger('click');
    })

  },

  // Fait apparaitre le champs de formulaire
  // pour modifier le titre d'une liste
  showFormTitle: function() {

    // On cible le formulaire lié à
    // l'îcone sur lequel on vient de cliquer
    var form = $(this).parent().next();

    // On affiche le formulaire
    form.show();

    // On cible le titre pour le masquer
    $(this).parent().hide();
  },

  // Masque le formulaire de modification
  // d'une liste et affiche le titre
  hideFormTitle: function() {

    // On cible le formulaire pour le masquer
    $(this).parent().hide();

    // On cible le titre pour l'afficher
    $(this).parent().prev().show();
  },

  createCard: function( evt ) {

    // On empêche le rechargement de la page
    evt.preventDefault();

    var container = $(this).parent();

    // On cible le champs de saisi qui est
    // à l'intérieur du formulaire qu'on
    // vient de valider
    var field = $(this).find('input');

    // On récupère la valeur
    var value = field.val();

    // On récupère l'identifiant de la liste
    var listId = $(this).parent().parent().parent().data('id');

    $.ajax('card/create', {
      method: 'post',
      data: { title: value, id: listId }
    })
    .done(function() {

      // On crée la nouvelle carte
      var template = `
        <li class="list-cards-card">
            <span>${value}</span>
            <i class="fas fa-edit"></i>
        </li>`;

      // On insère la carte dans la liste
      container
        .parent()
        .children()
        .last()
        .before(template);

      // On vide le formulaire
      field.val('');
    })
  },



  // -------------------------------
  // Tests d'Ajax
  // -------------------------------
  testAjax: function() {

    // On utilise la méthode de jQuery pour
    // créer des requêtes AJAX
    $.ajax('test', {

      success: function( response ) {

        // On transforme la réponse du serveur
        // en objet javascript
        var result = JSON.parse( response );

        // On parcours le tableau des listes
        // pour construire des "<div>"
        for (index in result) {

          // On crée la <div> et on l'affiche dans le body
          $('<div>')
            .text( result[index].name )
            .addClass('list')
            .appendTo(document.body);
        }
      }
    });
  }
};

$(app.init);
