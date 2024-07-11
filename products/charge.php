<?php
// Including necessary files 
require "../includes/header.php";
// require "../config/config.php";
?>

<div class="banner">
    <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo $appurl; ?>assets/img/bg-header.jpg');">
        <div class="container">
            <h1 class="pt-5">Pay with Paypal</h1>
            <p class="lead">Save time and leave the groceries to us.</p>
            <div class="container">
                <!-- Replace "test" with your own sandbox Business account app client ID -->
                <script src="https://www.paypal.com/sdk/js?client-id=AeHPAllOMyXNJuLrmuPSpxtyFq8Rz6nGvf83SsOTeZWA8Kr-NxFm-Lbz1ABkfu8fVcUNv-pGK-UJs_t1&currency=USD"></script>
                <!-- Set up a container element for the button -->
                <div id="paypal-button-container"></div>
                <script>
                    paypal.Buttons({
                        // Sets up the transaction when a payment button is clicked
                        createOrder: (data, actions) => {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        value: '<?php echo $_SESSION['total_price']; ?>' // Can also reference a variable or function
                                    }
                                }]
                            });
                        },
                        // Finalize the transaction after payer approval
                        onApprove: (data, actions) => {
                            return actions.order.capture().then(function(orderData) {
                                // console.log('Capture Result', orderData, JSON.stringify(orderData, null, 2));
                                // const transaction = orderData.purchase_units[0].payments.captures[0];
                                // alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for more details`)
                                // window.location.href = 'index.php';
                                window.location.href = 'success.php';
                            });
                        }
                    }).render('#paypal-button-container');
                </script>

            </div>
        </div>
    </div>
</div>

<?php

require "../includes/footer.php";

?>



























<?php
// require "../includes/footer.php"; 
?>