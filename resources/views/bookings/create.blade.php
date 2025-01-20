@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6">
        <h1 class="text-2xl font-bold mb-6">Boek een Vakantie: {{ $vacation->title }}</h1>

        <div id="payment-choice-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
            <div class="bg-white rounded-lg shadow-lg w-96 p-6">
                <h2 class="text-xl font-semibold mb-4">Betaling Bevestigen</h2>
                <p id="downpayment-amount" class="mb-2">Aanbetaling: €{{ number_format($vacation->price * 0.2, 2, ',', '.') }}</p>
                <p id="fullpayment-amount" class="mb-4">Volledig Bedrag: €{{ number_format($vacation->price, 2, ',', '.') }}</p>
                <div class="flex justify-between">
                    <button id="choose-downpayment" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Aanbetaling
                    </button>
                    <button id="choose-fullpayment" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Volledig Betalen
                    </button>
                </div>
                <button id="close-choice-modal" class="mt-4 w-full bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Annuleren
                </button>
            </div>
        </div>

        <div id="payment-confirmation-modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
            <div class="bg-white rounded-lg shadow-lg w-96 p-6">
                <h2 class="text-xl font-semibold mb-4">Bevestig Betaling</h2>
                <p id="payment-amount" class="text-lg mb-4">Te betalen bedrag: €0,00</p>
                <div class="flex justify-between">
                    <button id="confirm-payment" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Bevestig
                    </button>
                    <button id="close-confirmation-modal" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Annuleren
                    </button>
                </div>
            </div>
        </div>

        <form id="booking-form" action="{{ route('bookings.store', $vacation->id) }}" method="POST">
        @csrf

            <div id="guests-container">
                <div class="guest-item border rounded-lg p-4 mb-4" data-guest-index="0">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Gast 1</h2>
                        <button type="button" class="text-red-500 hover:text-red-700 remove-guest-button hidden">
                            Verwijder
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="guests[0][first_name]" class="block text-sm font-medium text-gray-700">Voornaam</label>
                            <input type="text" name="guests[0][first_name]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label for="guests[0][middle_name]" class="block text-sm font-medium text-gray-700">Tussenvoegsel</label>
                            <input type="text" name="guests[0][middle_name]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="guests[0][last_name]" class="block text-sm font-medium text-gray-700">Achternaam</label>
                            <input type="text" name="guests[0][last_name]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="guests[0][date_of_birth]" class="block text-sm font-medium text-gray-700">Geboortedatum</label>
                            <input type="date" name="guests[0][date_of_birth]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label for="guests[0][email]" class="block text-sm font-medium text-gray-700">E-mail</label>
                            <input type="email" name="guests[0][email]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>
                </div>
            </div>

            <div id="warning-container" class="hidden bg-red-100 text-red-700 px-4 py-2 rounded-lg mb-4">

            </div>

            <button type="button" id="add-guest-button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4">
                Voeg nog een gast toe
            </button>

            <div class="flex justify-end mb-4">
                <p class="text-lg font-semibold text-gray-800">Totale Kosten: €<span id="total-cost">0.00</span></p>
            </div>

            <div class="mt-6">
                <button type="button" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600" id="confirm-payment-button">
                    Bevestig Boeking
                </button>
            </div>
        </form>
    </div>

    <script>
        // Set guest price dynamically from the server
        const guestPrice = {{ $vacation->price }};

        let guestIndex = 1; // Tracks the unique index for guest inputs
        let totalGuests = 1; // Tracks the total number of guests displayed

        function updateGuestLabels() {
            const guestItems = document.querySelectorAll('.guest-item');
            guestItems.forEach((item, index) => {
                const label = item.querySelector('h2');
                label.textContent = `Gast ${index + 1}`;
                item.setAttribute('data-guest-index', index);
                const inputs = item.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    input.name = input.name.replace(/\d+/, index);
                });
            });
        }

        function updateTotalCost() {
            const totalCostElement = document.getElementById('total-cost');
            totalCostElement.textContent = (totalGuests * guestPrice).toFixed(2);
        }

        document.getElementById('add-guest-button').addEventListener('click', function () {
            const maxGuests = {{ $vacation->remainingSlots() }}; // Fetch remaining slots from the backend

            // Check if adding another guest exceeds the maximum allowed
            if (totalGuests >= maxGuests) {
                displayWarning('Er zijn geen beschikbare plaatsen meer voor deze vakantie.');
                return;
            }

            const container = document.getElementById('guests-container');

            const newGuest = `
                <div class="guest-item border rounded-lg p-4 mb-4" data-guest-index="${guestIndex}">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Gast ${guestIndex + 1}</h2>
                        <button type="button" class="text-red-500 hover:text-red-700 remove-guest-button">
                            Verwijder
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Voornaam</label>
                            <input type="text" name="guests[${guestIndex}][first_name]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tussenvoegsel</label>
                            <input type="text" name="guests[${guestIndex}][middle_name]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Achternaam</label>
                            <input type="text" name="guests[${guestIndex}][last_name]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Geboortedatum</label>
                            <input type="date" name="guests[${guestIndex}][date_of_birth]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">E-mail</label>
                            <input type="email" name="guests[${guestIndex}][email]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newGuest);
            guestIndex++;
            totalGuests++;
            updateTotalCost();
            attachRemoveEvent();
            updateGuestLabels();
        });

        function displayWarning(message) {
            const warningContainer = document.getElementById('warning-container');
            warningContainer.textContent = message;
            warningContainer.classList.remove('hidden'); // Show the warning

            // Automatically hide the warning after 5 seconds
            setTimeout(() => {
                warningContainer.classList.add('hidden');
            }, 5000);
        }


        function attachRemoveEvent() {
            document.querySelectorAll('.remove-guest-button').forEach(button => {
                button.removeEventListener('click', handleRemoveGuest); // Prevent duplicate event listeners
                button.addEventListener('click', handleRemoveGuest);
            });
        }

        function handleRemoveGuest(event) {
            const guestItem = event.target.closest('.guest-item');
            guestItem.remove();
            totalGuests--;
            updateTotalCost();
            updateGuestLabels();
        }

        document.addEventListener('DOMContentLoaded', () => {
            const choiceModal = document.getElementById('payment-choice-modal');
            const confirmationModal = document.getElementById('payment-confirmation-modal');
            const confirmPaymentButton = document.getElementById('confirm-payment');
            const paymentAmountElement = document.getElementById('payment-amount');

            const downpaymentButton = document.getElementById('choose-downpayment');
            const fullpaymentButton = document.getElementById('choose-fullpayment');
            const confirmPaymentTrigger = document.getElementById('confirm-payment-button');

            const closeChoiceModal = document.getElementById('close-choice-modal');
            const closeConfirmationModal = document.getElementById('close-confirmation-modal');
            const bookingForm = document.getElementById('booking-form');

            let selectedPaymentType = null;

            function calculatePrice() {
                const guestCount = document.querySelectorAll('.guest-item').length; // Count guests
                const pricePerGuest = {{ $vacation->price }};
                const totalPrice = guestCount * pricePerGuest;
                const downpayment = totalPrice * 0.2; // 20% of total price

                return { totalPrice, downpayment };
            }

            // Show the payment choice modal
            confirmPaymentTrigger.addEventListener('click', () => {
                const { totalPrice, downpayment } = calculatePrice();

                // Update modal with calculated prices
                document.getElementById('downpayment-amount').textContent = `Aanbetaling: €${downpayment.toFixed(2).replace('.', ',')}`;
                document.getElementById('fullpayment-amount').textContent = `Volledig Bedrag: €${totalPrice.toFixed(2).replace('.', ',')}`;

                choiceModal.classList.remove('hidden');
            });

            // Handle downpayment selection
            downpaymentButton.addEventListener('click', () => {
                selectedPaymentType = 'downpayment';
                const { downpayment } = calculatePrice();
                paymentAmountElement.textContent = `Te betalen bedrag: €${downpayment.toFixed(2).replace('.', ',')}`;
                choiceModal.classList.add('hidden');
                confirmationModal.classList.remove('hidden');
            });

            // Handle full payment selection
            fullpaymentButton.addEventListener('click', () => {
                selectedPaymentType = 'fullpayment';
                const { totalPrice } = calculatePrice();
                paymentAmountElement.textContent = `Te betalen bedrag: €${totalPrice.toFixed(2).replace('.', ',')}`;
                choiceModal.classList.add('hidden');
                confirmationModal.classList.remove('hidden');
            });

            // Confirm payment
            confirmPaymentButton.addEventListener('click', () => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'payment_type';
                input.value = selectedPaymentType;
                bookingForm.appendChild(input);
                bookingForm.submit();
            });

            // Close modals
            closeChoiceModal.addEventListener('click', () => {
                choiceModal.classList.add('hidden');
            });

            closeConfirmationModal.addEventListener('click', () => {
                confirmationModal.classList.add('hidden');
            });
        });


        // Attach remove event to the initial guest
        attachRemoveEvent();

        // Update the initial total cost
        updateTotalCost();
    </script>
@endsection
