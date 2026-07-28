import Modal from 'bootstrap/js/dist/modal';

let notifAlert = function (message) {
  window.alert(message);
};

let notifConfirm = function (message, callback) {
  const modalElement = document.getElementById('confirmation-modal');

  if (modalElement === null) {
    if (window.confirm(message)) {
      callback();
    }

    return;
  }

  const body = modalElement.querySelector('.modal-body');
  if (body !== null) {
    body.innerHTML = message;
  }

  const modal = Modal.getOrCreateInstance(modalElement);
  const confirmButton = modalElement.querySelector('#confirmation-button');

  if (confirmButton !== null) {
    const freshButton = confirmButton.cloneNode(true);
    confirmButton.replaceWith(freshButton);
    freshButton.addEventListener('click', () => {
      modal.hide();
      callback();
    }, { once: true });
  }

  modal.show();
};

export {notifAlert, notifConfirm};
