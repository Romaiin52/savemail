
  $(document).ready(function() {

    var $container = $('div#rm_blogbundle_articletype_Categories');
    var $lienAjout = $('<a href="#" id="ajout_categorie" class="btn">Ajouter une catégorie</a>');

    $container.append($lienAjout);
    $lienAjout.click(function(e) {
      ajouterCategorie($container);
      e.preventDefault(); 
      return false;
    });

    var index = $container.find(':input').length;

    if (index == 0) {
      ajouterCategorie($container);
    } else {
      $container.children('div').each(function() {
          ajouterLienSuppression($(this));
      });
     }
      
      function ajouterCategorie($container) {
        var $prototype = $($container.attr('data-prototype').replace(/__name__label__/g, 'Catégorie n°' + (index+1)).replace(/__name__/g, index));
        ajouterLienSuppression($prototype);
        $container.append($prototype);
        index++;
      }

      function ajouterLienSuppression($prototype) {
        $lienSuppression = $('<a href="#" class="btn btn-danger">Supprimer</a>');
        $prototype.append($lienSuppression);
        $lienSuppression.click(function(e) {
          $prototype.remove();
          e.preventDefault(); 
          return false;
        });
      }
  });