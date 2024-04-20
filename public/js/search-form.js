const searchFormContainer = document.querySelector(
  '[data-search-form-container]'
);
const searchToggle = document.querySelector('[data-search-toggle]');
const searchClose = document.querySelector('[data-search-close]');

searchToggle.addEventListener('click', () => {
  searchFormContainer.classList.add('visible');
});

searchClose.addEventListener('click', () => {
  searchFormContainer.classList.remove('visible');
});
