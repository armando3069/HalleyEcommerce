<?php
session_start();
include 'init.php';
$pageTitle = 'Shop';


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <style>
    #cart-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        width: 100%;
    }

    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-direction: row;
        padding: 10px;
        border-bottom: 1px solid #ccc;
        margin-bottom: 10px;
        width: 500px;
        /* Lățimea fixă dorită */
        /* border: 1px solid red; */
    }

    /* Media Query pentru a se adapta la dimensiuni mai mici */
    @media (max-width: 600px) {
        .cart-item {
            width: 100%;
            /* Face ca elementul să ocupe toată lățimea disponibilă pe ecrane mici */
            box-sizing: border-box;
            /* Asigură că padding-ul și border-ul sunt incluse în lățimea totală */

        }
    }




    .cart-item img {
        width: 100px;
        height: auto;
        object-fit: contain;
    }

    .title_shop {
        text-align: center;
        margin-bottom: 30px;
    }

    .flex_items {
        display: flex;
        flex-direction: row;
    }

    .title_items {
        width: 200px;
        font-size: 1rem;
    }

    .titles_items {
        font-size: 1.2rem;
    }

    .item_quantity {
        color: black;
        width: 20px;
        height: 25px;
        text-align: center;
        border: 1px solid #D9D9D9;
        border-radius: 4px;

    }


    .item_shop {
        display: flex;
        justify-content: center;
        gap: 15px;
        align-items: center;
        flex-direction: row;
    }

    .item_price {
        font-size: 1.3rem;
        display: flex;
        justify-content: center;
        margin: 0;
    }

    .item_update {
        font-size: 1.3rem;
        margin: 0;
    }

    .item_img {
        display: flex;
        flex-direction: row;
    }

    @media (max-width: 560px) {
        .flex_items {
            flex-direction: column;
        }

    }
    </style>
</head>

<body>
    <h1 class="title_shop">Your Shopping Cart</h1>
    <div id="cart-container"></div>

    <script>
    function getProductDetails(productId) {
        return fetch(`http://localhost:1337/api/products/${productId}?populate=*`)
            .then(response => response.json())
            .then(data => data.data.attributes);
    }

    function updateCartDisplay() {
        const cartContainer = document.getElementById('cart-container');
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        cartContainer.innerHTML = '';

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
                              <p class="titles_items" >${product.title}</p>
                             </div>
                          
                          
                            <div class="item_shop">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" onclick="updateQuantity(${item.id}, -1)" class="item_update" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
                                    </svg>
                                 <div class="item_quantity">${item.quantity}</div>
                              <p onclick="updateQuantity(${item.id}, 1)" class="item_update">+</p>

                                <p class="item_price" >$${product.price}</p>
                                <svg xmlns="http://www.w3.org/2000/svg" onclick="removeFromCart(${item.id})"  width="30" height="30" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                </svg>
                            </div>

                            </div>
                    `;

                cartContainer.appendChild(cartItemDiv);

                // Adaugă la total prețul produsului înmulțit cu cantitatea sa
                totalPrice += product.price * item.quantity;
            });
        });

        // Afișează totalul după ce toate promisiunile au fost rezolvate
        Promise.all(cartPromises).then(() => {
            const totalDiv = document.createElement('div');
            totalDiv.className = 'cart-total';
            totalDiv.innerHTML = `<h2>Total: $${totalPrice.toFixed(2)}</h2>`; // Afișează prețul total
            cartContainer.appendChild(totalDiv); // Adaugă totalul sub produsele din coș
        });
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

    updateCartDisplay();
    </script>
</body>

</html>