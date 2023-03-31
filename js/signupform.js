// Get the form element
const form = document.querySelector('form');

// Add event listener to form submission
form.addEventListener('submit', (event) => {
  // Prevent default form submission behavior
  event.preventDefault();

  // Get form data
  const formData = new FormData(form);

  // Send form data using AJAX
  fetch('../database/addAccount.php', {
    method: 'POST',
    body: formData
  })
  .then(response => {
    // Check the response status and display appropriate message
    if (response.ok) {
      // Account created successfully
      console.log('Account created successfully');
    } else {
      // Error creating account
      console.log('Error creating account');
    }
  })
  .catch(error => {
    console.error(error);
  });
});
