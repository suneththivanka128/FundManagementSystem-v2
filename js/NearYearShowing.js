document.addEventListener('DOMContentLoaded', function() {
    const yearInput = document.getElementById('year-input');
    const yearDropdown = document.getElementById('year-dropdown');
    
    // Show dropdown when input is clicked
    yearInput.addEventListener('focus', function() {
        populateYearDropdown();
        yearDropdown.style.display = 'block';
    });
    
    // Hide dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target !== yearInput) {
            yearDropdown.style.display = 'none';
        }
    });
    
    function populateYearDropdown() {
        yearDropdown.innerHTML = '';
        const currentYear = new Date().getFullYear();
        const yearsToShow = 2;
        
        for (let i = 0; i < yearsToShow; i++) {
            const year = currentYear - i;
            const yearElement = document.createElement('div');
            yearElement.textContent = year;
            
            yearElement.addEventListener('click', function() {
                yearInput.value = year;
                yearDropdown.style.display = 'none';
            });
            
            yearDropdown.appendChild(yearElement);
        }
    }
});