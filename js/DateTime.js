function updateDateTime() {
        const now = new Date();
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        };
        document.getElementById('datetime').textContent = now.toLocaleDateString('en-US', options);
}

    // Update immediately
    updateDateTime();
    
    // Then update every second
    setInterval(updateDateTime, 1000);
