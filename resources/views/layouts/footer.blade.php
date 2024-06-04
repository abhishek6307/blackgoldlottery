<footer class="mb-4">
<p>&copy; 2024 Black Gold Lottery. All rights reserved.</p>    
        
    </footer>
    <script>
    const pricePerTicket = 11;

    function updateNumbersAndPrice() {
        const quantity = document.getElementById('ticketCount').value;
        const numbersContainer = document.getElementById('numbers');
        numbersContainer.innerHTML = ''; // Clear existing circles
        for (let i = 0; i < quantity; i++) {
            numbersContainer.innerHTML += '<div class="number"></div>'; // Add new circles based on quantity
        }
        updatePrice(quantity);
    }

    function updatePrice(quantity) {
        const totalPrice = quantity * pricePerTicket;
        document.getElementById('ticketPrice').textContent = totalPrice.toFixed(2);
    }

    // Timer logic
    let timeRemaining = {{ $timeRemaining }};
    // const timerElement = document.getElementById('time');
    const timerElements = document.getElementsByClassName('remaining-times');

    function updateTimer() {
        if (timeRemaining <= 0) {
                for (let i = 0; i < timerElements.length; i++) {
                    timerElements[i].textContent = "00:00";
                clearInterval(timerInterval);
            }
            return;

        }
        timeRemaining -= 1;
        const minutes = Math.floor(timeRemaining / 60);
        const seconds = timeRemaining % 60;
        for (let i = 0; i < timerElements.length; i++) {
            timerElements[i].textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }
    }

    const timerInterval = setInterval(updateTimer, 1000);
</script>