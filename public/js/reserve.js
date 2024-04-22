const timeField = document.querySelector('[data-time]');
const timeNext = document.querySelector('[data-time-next]');
const timePrev = document.querySelector('[data-time-prev]');

const datePicker = document.querySelector('[data-date]');
const dateNext = document.querySelector('[data-date-next]');
const datePrev = document.querySelector('[data-date-prev]');
const formattedDateField = document.querySelector('[data-formatted-date]');

const guestsField = document.querySelector('[data-guests]');
const guestsNext = document.querySelector('[data-guests-next]');
const guestsPrev = document.querySelector('[data-guests-prev]');

// show formatted date as soon as the page loads.
updateFormattedDate();

stepUp(timeNext, timeField, 'time');
stepDown(timePrev, timeField, 'time');

stepUp(dateNext, datePicker, 'date');
stepDown(datePrev, datePicker, 'date');

stepUp(guestsNext, guestsField, 'guests');
stepDown(guestsPrev, guestsField, 'guests');

formattedDateField.addEventListener('click', () => {
  datePicker.style.display = 'block';
});

datePicker.addEventListener('update', () => {
  updateFormattedDate();
});

function stepUp(stepBtn, field, fieldName) {
  stepBtn.addEventListener('click', () => {
    if (fieldName === 'time') {
      field.stepUp(10);
    } else {
      field.stepUp();
    }

    // show formatted date if date field
    if (fieldName === 'date') {
      updateFormattedDate();
    }
  });
}

function stepDown(stepBtn, field, fieldName) {
  stepBtn.addEventListener('click', () => {
    if (fieldName === 'time') {
      field.stepDown(10);
    } else {
      field.stepDown();
    }
    // show formatted date if date field
    if (fieldName === 'date') {
      updateFormattedDate();
    }
  });
}

// get the formatted version of date that should be shown on UI.
function updateFormattedDate() {
  const inputDate = new Date(datePicker.value);
  const options = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  };
  const formattedDate = inputDate.toLocaleDateString('en-US', options);
  formattedDateField.value = formattedDate;
  datePicker.style.display = 'none';
}
