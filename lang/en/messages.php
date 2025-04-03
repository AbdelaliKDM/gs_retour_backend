<?php
// lang/en/messages.php
return [
  'profile' => [

    'active' => [
      'default' => [
        'title' => 'Profile Status Updated',
        'content' => 'Your profile is now active and fully functional.',
      ],
      'suspended' => [
        'default' => [
          'title' => 'Profile Suspended by Administrator',
          'content' => 'Your profile has been suspended by an administrator. Please contact support for more information.',
        ],
        'invoice' => [
          'title' => 'Profile Suspended - Invoice Pending',
          'content' => 'Your profile has been suspended due to an unpaid invoice. Please settle your outstanding payment to reactivate your account.',
        ],
        'profile' => [
          'title' => 'Profile Suspended - Incomplete Information',
          'content' => 'Your profile is currently suspended due to missing or incomplete profile information. Please update your details to reactivate your account.',
        ],
        'truck' => [
          'title' => 'Profile Suspended - Truck Information Missing',
          'content' => 'Your profile is suspended due to incomplete truck information. Please provide the required truck details to reactivate your account.',
        ],
      ],
    ],

  ],

  'review' => [
    'title' => 'New Review Received',
    'content' => 'A new review with a rating of :rating stars has been submitted for your trip.',
  ],

  'trip' => [
    'ongoing' => [
      'title' => 'Trip In Progress',
      'content' => 'Your trip (ID: :id) is currently ongoing.',
    ],
    'paused' => [
      'title' => 'Trip Paused',
      'content' => 'Your trip (ID: :id) has been temporarily paused.',
    ],
    'canceled' => [
      'title' => 'Trip Canceled',
      'content' => 'Your trip (ID: :id) has been canceled.',
    ],
    'completed' => [
      'title' => 'Trip Completed',
      'content' => 'Congratulations! Your trip (ID: :id) has been successfully completed.',
    ],
  ],

  'shipment' => [
    'shipped' => [
      'title' => 'Shipment Dispatched',
      'content' => 'Your shipment (ID: :shipment_id) has been shipped and is on its way.',
    ],
    'delivered' => [
      'title' => 'Shipment Delivered',
      'content' => 'Your shipment (ID: :shipment_id) has been successfully delivered.',
    ],
  ],

  'order' => [
    'created' => [
      'title' => 'New Order Received',
      'content' => 'You have received a new order (ID: :order_id). Please review and process it.',
    ],
    'accepted' => [
      'title' => 'Order Accepted',
      'content' => 'Your order (ID: :order_id) has been accepted.',
    ],
    'rejected' => [
      'title' => 'Order Rejected',
      'content' => 'Unfortunately, your order (ID: :order_id) has been rejected.',
    ],
  ],

  'payment' => [
    'wallet' => [
      'paid' => [
        'title' => 'Wallet Payment Successful',
        'content' => 'Your wallet payment has been processed successfully.',
      ],
      'failed' => [
        'title' => 'Wallet Payment Failed',
        'content' => 'There was an issue processing your wallet payment. Please try again.',
      ],
    ],
    'invoice' => [
      'paid' => [
        'title' => 'Invoice Payment Completed',
        'content' => 'Your invoice payment has been successfully completed.',
      ],
      'failed' => [
        'title' => 'Invoice Payment Failed',
        'content' => 'Payment for the invoice was unsuccessful. Please review and retry.',
      ],
    ],
  ],
];