<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

//Method used to create a session and redirect to stripe
function paymentMethod($cost, $invoice)
{
  \Stripe\Stripe::setApiKey('sk_test_51JhAe3JycQsKUYZJlKFnQn6PpaV8FwQmX9DKtBsp83nVxkcgcbLHopLDrBgO9l5wvtfZSkMOeyJzrkq017JDB2Ka00lQBAh1Ey');

  $unit = preg_replace('/\$/', '', $cost);
  $unit = preg_replace('/\./', '', $unit);

  $descriptionString = "Booking at " . $invoice['startTime'] . ", Please be on time and we hope you enjoy our service!";


  $session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'customer_email' => $invoice['user']['email'],
    'line_items' => [[
      'price_data' => [
        'currency' => 'aud',
        'product_data' => [
          'name' => "Booking for a  " . $invoice['car']['carName'] . "(" . $invoice['car']['carType'] . ") at " . $invoice['location']['name'],
          'description' => $descriptionString,

        ],
        'unit_amount' => $unit,
      ],
      'quantity' => 1,

    ]],
    'mode' => 'payment',
    //Development
    'success_url' => 'http://localhost/checkout?id=' . $invoice['id'] . '&payment=success',
    'cancel_url' => 'http://localhost/checkout?id=' . $invoice['id'] . '&payment=failed',

    //Production
    #'success_url' => 'https://tsb-carshare.herokuapp.com/checkout?id=' . $invoice['id'] . '&payment=success',
    #'cancel_url' => 'https://tsb-carshare.herokuapp.com/checkout?id=' . $invoice['id'] . '&payment=failed',
  ]);


  return $session;
}
