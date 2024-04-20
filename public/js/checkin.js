const infoPopupContainer = document.querySelector(
  '[data-info-popup-container]'
);
const contactInfoForm = document.querySelectorAll('[data-contact-info-form]');
const infoPopupClose = document.querySelector('[data-info-popup-close]');

const infoPopupNameField = document.querySelector(
  '[data-info-popup-name-field]'
);
const infoPopupEmailField = document.querySelector(
  '[data-info-popup-email-field]'
);
const infoPopupPhoneField = document.querySelector(
  '[data-info-popup-phone-field]'
);

contactInfoForm.forEach((form) => {
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    infoPopupContainer.classList.add('visible');

    const formData = new FormData(e.target);
    const entries = Object.fromEntries(formData);
    const name = entries.name;
    const email = entries.email;
    const phone = entries.phone;

    console.log(entries);

    infoPopupNameField.innerText = name;
    infoPopupEmailField.innerText = email;
    infoPopupPhoneField.innerText = phone;
  });
});
infoPopupClose.addEventListener('click', () => {
  infoPopupContainer.classList.remove('visible');
});
