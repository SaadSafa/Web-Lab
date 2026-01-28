function getCsrfToken() {
  var meta = document.querySelector('meta[name="csrf-token"]');
  return meta ? meta.getAttribute('content') : '';
}

function setMessage(container, message, isError) {
  if (!container) return;
  container.textContent = message;
  container.className = isError ? 'text-rose-200 text-xs mt-4' : 'text-emerald-200 text-xs mt-4';
}

function initOrderStatusForm(form) {
  var button = form.querySelector('button[type="submit"]');
  var message = form.parentElement.querySelector('[data-order-status-message]');

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    if (button) button.disabled = true;
    setMessage(message, 'Saving...', false);

    var formData = new FormData(form);

    fetch(form.action, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': getCsrfToken(),
        'Accept': 'application/json'
      },
      body: formData
    })
      .then(function (res) {
        if (!res.ok) {
          return res.json().then(function (data) {
            throw data;
          });
        }
        return res.json();
      })
      .then(function () {
        setMessage(message, 'Status updated.', false);
      })
      .catch(function () {
        setMessage(message, 'Could not update status.', true);
      })
      .finally(function () {
        if (button) button.disabled = false;
      });
  });
}

document.addEventListener('DOMContentLoaded', function () {
  var form = document.querySelector('[data-order-status-form]');
  if (form) {
    initOrderStatusForm(form);
  }
});
