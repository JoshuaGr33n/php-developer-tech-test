document.querySelector('form').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitButton = document.querySelector('button[type="submit"]');


    if (submitButton) {
        // Disable the submit button to prevent double submission
        submitButton.disabled = true;
    }
    
    fetch('/form', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.matchedCompanies) {
            // Store matched companies in localStorage
            localStorage.setItem('matchedCompanies', JSON.stringify(data.matchedCompanies));

            // Redirect to the results page without losing data
            window.location.href = '/results';
        }
    })
    .catch(error => console.error('Error:', error))
    .finally(() => {
        submitButton.disabled = false;
    });
});
