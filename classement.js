// Ajouter ce code dans un fichier séparé appelé "classement.js"

document.addEventListener('DOMContentLoaded', function() {
  const recipeElements = document.querySelectorAll('.form-box0');

  recipeElements.forEach(function(recipeElement) {
    recipeElement.addEventListener('mouseover', function() {
      this.classList.add('highlight');
    });

    recipeElement.addEventListener('mouseout', function() {
      this.classList.remove('highlight');
    });
  });
});
