import $ from 'jquery';

let notifAlert = function (message) {
  alert(message);
};

let notifConfirm = function (message, callback) {
  $('#confirmation-modal').find('.content p').html(message);
    $('#confirmation-button')
      .off('click')
      .on('click', (event) => {
        callback();
      })
    ;

  $('#confirmation-modal').modal('show');
};

export {notifAlert, notifConfirm};
