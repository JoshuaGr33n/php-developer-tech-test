document.addEventListener('DOMContentLoaded', function () {
    const matchesContainer = document.querySelector('.matches');

    const storedResults = localStorage.getItem('matchedCompanies');
    if (storedResults) {
        const matchedCompanies = JSON.parse(storedResults);

        if (matchesContainer) {
            matchesContainer.innerHTML = '';
            if (matchedCompanies.length === 0) {
                matchesContainer.innerHTML = '<p>No matching companies found.</p>';
            } else {
                matchedCompanies.forEach(company => {
                    const companyElement = document.createElement('div');
                    companyElement.classList.add('matches__match');
                    companyElement.innerHTML = `
                        <h3>${company.name}</h3>
                        <p>${company.description}</p>
                        <a href="#" class="matches__match__more">more</a>
                        <div class="match__details" style="display:none">
                            <p><strong>Email:</strong> ${company.email}</p>
                            <p><strong>Phone:</strong> ${company.phone}</p>
                            <p><strong>Website:</strong> <a href="${company.website}" target="_blank">${company.website}</a></p>
                            <p>${company.credits} credits left</p>
                        </div>
                    `;
                    matchesContainer.appendChild(companyElement);

                    companyElement.querySelector('.matches__match__more').addEventListener('click', function (e) {
                        e.preventDefault();
                        const details = companyElement.querySelector('.match__details');
                        const moreLink = this;

                        // Toggle visibility of details
                        if (details.style.display === 'none') {
                            details.style.display = 'block';
                            moreLink.textContent = 'less';
                        } else {
                            details.style.display = 'none';
                            moreLink.textContent = 'more';
                        }
                    });
                });
            }
        }
    } else {
        // If no data in localStorage, display a message
        if (matchesContainer) {
            matchesContainer.innerHTML = '<p>No results found. Please submit the form again.</p>';
        }
    }
});
