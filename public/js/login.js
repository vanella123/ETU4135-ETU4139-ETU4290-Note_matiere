document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('login-form');
  const messageBox = document.getElementById('login-message');
  const submitButton = document.getElementById('login-submit');

  if (!form || !messageBox || !submitButton) {
    return;
  }

  const showMessage = (message) => {
    messageBox.textContent = message;
    messageBox.hidden = false;
  };

  const hideMessage = () => {
    messageBox.textContent = '';
    messageBox.hidden = true;
  };

  form.addEventListener('submit', async (event) => {
    event.preventDefault();
    hideMessage();

    const formData = new FormData(form);
    submitButton.classList.add('is-loading');
    submitButton.disabled = true;

    try {
      const response = await fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
        },
        credentials: 'same-origin',
      });

      const result = await response.json();

      if (!response.ok || result.status !== 'success') {
        showMessage(result.message || 'Identifiants invalides.');
        return;
      }

      window.location.href = result.redirect || '/dashboard';
    } catch (error) {
      showMessage('Impossible de contacter le serveur.');
    } finally {
      submitButton.classList.remove('is-loading');
      submitButton.disabled = false;
    }
  });
});