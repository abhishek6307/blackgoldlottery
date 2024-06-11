<footer class="">
<p>&copy; 2024 Black Gold Lottery. All rights reserved.</p>    
        
    </footer>
    <script>

var today = new Date();
            var dateString = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');
            document.getElementById('date').innerText = dateString;
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
const timerElements = document.getElementsByClassName('remaining-times');

function updateTimer() {
    if (timeRemaining <= 0) {
        for (let i = 0; i < timerElements.length; i++) {
            timerElements[i].textContent = "00:00";
        }
        clearInterval(timerInterval);
        
        setTimeout(function() {
            location.reload();
        }, 2000); 
        
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


function updateNumbersAndPrice() {
    const priceElement = document.getElementById('ticketPrice');
    const price = parseInt(priceElement.value);
    const quantityElement = document.getElementById('ticketCount');
    const quantity = parseInt(quantityElement.value);
    const totalPrice = price * quantity;

    document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);
    document.getElementById('winningPrice').textContent = (((price -1) * quantity) * 10);
    
    const numbersContainer = document.getElementById('numbers');
    numbersContainer.innerHTML = ''; // Clear existing circles
    for (let i = 0; i < quantity; i++) {
        numbersContainer.innerHTML += '<div class="number"></div>'; // Add new circles based on quantity
    }
}
</script>
