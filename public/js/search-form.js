const searchFormContainer = document.querySelector('.search-form-container');
const searchToggle = document.querySelector('.search-toggle');
const searchClose = document.querySelector('.search-close');

searchToggle.addEventListener('click', () => {
  searchFormContainer.classList.add('visible');
});

searchClose.addEventListener('click', () => {
  searchFormContainer.classList.remove('visible');
});
m;
