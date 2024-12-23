// Function to show a category
function showCategory(category) {
    document.querySelectorAll('.menu-list').forEach(el => el.style.display = 'none');
    document.getElementById(category).style.display = 'block';
}

function generateBill() {
    let subtotal = 0;
    const billItems = document.getElementById('bill-items');
    billItems.innerHTML = ""; // Clear previous bill items
    let itemsDetails = "";

    // Get all the input fields with class "quantity" and process the selected quantities
    const quantities = document.querySelectorAll('.quantity');
    quantities.forEach(input => {
        const itemRow = input.closest('tr');
        const itemName = itemRow.querySelector('td:first-child').textContent.trim();
        const itemPrice = parseInt(itemRow.querySelector('td:nth-child(2)').textContent.replace('₹', '').trim());
        const itemQuantity = parseInt(input.value);

        if (itemQuantity > 0) {
            const totalItemPrice = itemPrice * itemQuantity;
            subtotal += totalItemPrice;

            // Add item and price to the bill
            const row = document.createElement('tr');
            row.innerHTML = `<td>${itemName}</td><td>${itemQuantity}</td><td>₹${itemPrice}</td><td>₹${totalItemPrice}</td>`;
            billItems.appendChild(row);

            // Append item details to itemsDetails string
            itemsDetails += `${itemName} - Qty: ${itemQuantity}, Price: ₹${itemPrice}, Total: ₹${totalItemPrice}\n`;
        }
    });

    // Calculate tax and total
    const tax = subtotal * 0.05;
    const total = subtotal + tax;

    // Display the calculated amounts
    document.getElementById('subtotal-amount').innerText = `₹${subtotal.toFixed(2)}`;
    document.getElementById('tax-amount').innerText = `₹${tax.toFixed(2)}`;
    document.getElementById('total-amount').innerText = `₹${total.toFixed(2)}`;

    // Display current date and time
    const now = new Date();
    const dateTime = `${now.toLocaleDateString()} ${now.toLocaleTimeString()}`;
    document.getElementById('bill-date-time').innerText = `Date & Time: ${dateTime}`;

    // Display thank-you message
    document.getElementById('greetings').innerText = "Thank you for visiting Sunny Restaurant!";

    // Fill hidden fields for email
    document.getElementById('hidden-items').value = itemsDetails;
    document.getElementById('hidden-subtotal').value = subtotal.toFixed(2);
    document.getElementById('hidden-tax').value = tax.toFixed(2);
    document.getElementById('hidden-total').value = total.toFixed(2);

    // Debugging: log hidden field values
    console.log('Hidden Items:', document.getElementById('hidden-items').value);
    console.log('Hidden Subtotal:', document.getElementById('hidden-subtotal').value);
    console.log('Hidden Tax:', document.getElementById('hidden-tax').value);
    console.log('Hidden Total:', document.getElementById('hidden-total').value);
}
