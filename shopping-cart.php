<?php
session_start();
include 'init.php';
$pageTitle = 'Shop';
?>


<h3 class="title_shoping">Shopping Cart</h3>

<div class="viewport_cart_container">
    <div class="cart_main_container">
        <div class="cart-container">

            <div id="cart-container"></div>
            <img id="empty-cart-message" style="display: none;" src="./layout/img/gol.jpg" alt="" />

            <div class="cart-summary" id="cart-summary">
                <h2 class="cart_summary_title">Order Summary</h2>
                <form>
                    <label for="discount-code" class="cart_summary_discount">Discount code / Promo code</label>
                    <input type="text" id="discount-code" placeholder="Code">

                    <label for="card-number" class="cart_summary_discount">Your bonus card number</label>
                    <div class="card_apply">
                        <input type="text" id="card-number" placeholder="Enter Card Number">
                        <button class="apply_btn" type="submit">Apply</button>
                    </div>
                </form>

                <div class="summary-details">

                    <div class="summary-subtotal">
                        <p class="summery_total">Subtotal: </p>
                        <p id="subtotal"></p>
                    </div>

                    <div class="summary-subtotal">
                        <p class="summery_estimated">Estimated Tax: </p>
                        <p>$50</p>
                    </div>

                    <div class="summary-subtotal">
                        <p class="summery_estimated">Estimated Shipping & Handling: </p>
                        <p>$29</p>
                    </div>

                    <div class="summary-subtotal">
                        <p class="summery_total">Total: </p>
                        <p id="total">0</p>
                    </div>

                </div>

                <button class="checkout-btn" id="checkout-button">Checkout</button>
            </div>


        </div>
    </div>
</div>
</div>
<script src="https://js.stripe.com/v3/"></script>
<script>
function getProductDetails(productId) {
    return fetch(`http://localhost:1337/api/products/${productId}?populate=*`)
        .then(response => response.json())
        .then(data => data.data.attributes);
}

function updateCartDisplay() {
    const cartContainer = document.getElementById('cart-container');
    const cartSummary = document.getElementById('cart-summary');
    const emptyCartMessage = document.getElementById('empty-cart-message');

    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    cartContainer.innerHTML = '';
    if (cart.length === 0) {
        // Coșul este gol
        cartSummary.style.display = 'none'; // Ascunde sumarul
        emptyCartMessage.style.display = 'block'; // Afișează mesajul de coș gol
        cartContainer.style.width = '0%'
        return;
    } else {
        cartSummary.style.display = 'block'; // Afișează sumarul
        emptyCartMessage.style.display = 'none'; // Ascunde mesajul de coș gol
    }
    let totalPrice = 0; // Inițializează variabila pentru prețul total

    const cartPromises = cart.map(item => {
        return getProductDetails(item.id).then(product => {
            const cartItemDiv = document.createElement('div');
            cartItemDiv.className = 'cart-item';
            cartItemDiv.innerHTML = `
                    <div class="item_img">
                        <img src="http://localhost:1337${product.image.data[0].attributes.url}" alt="${product.title}">
                    </div>
                    <div class="flex_items">
                        <div class="title_items">
                            <p class="titles_items">${product.title}</p>
                        </div>
                        <div class="item_shop">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" onclick="updateQuantity(${item.id}, -1)" class="item_update" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
                            </svg>
                            <div class="item_quantity">${item.quantity}</div>
                            <p onclick="updateQuantity(${item.id}, 1)" class="item_update">+</p>
                            <p class="item_price">$${product.price}</p>
                            <svg xmlns="http://www.w3.org/2000/svg" onclick="removeFromCart(${item.id})" width="30" height="30" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                            </svg>
                        </div>
                    </div>
                `;

            cartContainer.appendChild(cartItemDiv);

            totalPrice += product.price * item.quantity;
        });
    });

    // Afișează totalul după ce toate promisiunile au fost rezolvate
    Promise.all(cartPromises).then(() => {
        // const totalDiv = document.createElement('div');
        // totalDiv.className = 'cart-total';
        // totalDiv.innerHTML = `<h2>Total: $${totalPrice.toFixed(2)}</h2>`;
        // cartContainer.appendChild(totalDiv);

        // Actualizează sumarul
        updateSummary(totalPrice);
    });
}

function updateSummary(totalPrice) {
    document.getElementById('subtotal').textContent = totalPrice.toFixed(2);
    const totalWithTax = totalPrice + 50 + 29; // tax + shipping
    document.getElementById('total').textContent = totalWithTax.toFixed(2);
}

function updateQuantity(productId, change) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let item = cart.find(p => p.id === productId);

    if (item) {
        item.quantity += change;
        if (item.quantity <= 0) {
            removeFromCart(productId);
        } else {
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartDisplay();
        }
    }
}

function removeFromCart(productId) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.filter(p => p.id !== productId);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
}

const stripe = Stripe(
    'pk_test_51Q26cmAev2naXbW6Ec9IxzcXuuPZFJA11ZTzRzgUbYNR4pQqN5c9vdPiXRIGCQf5ixLsgybJjXRdcLZQIn6lgESo00PeIRLvV8'
); // Cheia publică de la Stripe

document.getElementById('checkout-button').addEventListener('click', function() {
    // Colectează produsele din localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Trimite produsele către PHP pentru procesarea plății
    fetch('/Halley/checkout.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(cart), // Trimite produsele din coș
        })
        .then(response => response.json())
        .then(session => {
            if (session.error) {
                console.error(session.error);
            } else {
                return stripe.redirectToCheckout({
                    sessionId: session.id
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});
updateCartDisplay();
</script>
<?php
  include $tpl . 'footer.php'; 
?>