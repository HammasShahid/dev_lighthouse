const timeField = document.querySelector('[data-time]');
const timeNext = document.querySelector('[data-time-next]');
const timePrev = document.querySelector('[data-time-prev]');

const dateField = document.querySelector('[data-date]');
const dateNext = document.querySelector('[data-date-next]');
const datePrev = document.querySelector('[data-date-prev]');

const guestsField = document.querySelector('[data-guests]');
const guestsNext = document.querySelector('[data-guests-next]');
const guestsPrev = document.querySelector('[data-guests-prev]');

function stepUp(stepBtn, field, isTime) {
  stepBtn.addEventListener('click', () => {
    if (isTime) {
      field.stepUp(10);
    } else {
      field.stepUp();
    }
  });
}

function stepDown(stepBtn, field, isTime) {
  stepBtn.addEventListener('click', () => {
    if (isTime) {
      field.stepDown(10);
    } else {
      field.stepDown();
    }
  });
}

stepUp(timeNext, timeField, true);
stepDown(timePrev, timeField, true);

stepUp(dateNext, dateField, false);
stepDown(datePrev, dateField, false);

stepUp(guestsNext, guestsField, false);
stepDown(guestsPrev, guestsField, false);
