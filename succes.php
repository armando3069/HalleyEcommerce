<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
</head>

<body>
    <h1>Plata a fost finalizată cu succes!</h1>
    <p>Mulțumim pentru comanda ta.</p>

    <script>
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    if (cart.length > 0) {
        localStorage.removeItem('cart');
        console.log('Coșul a fost golit.');
    } else {
        console.log('Coșul este deja gol.');
    }
    </script>
</body>

</html>