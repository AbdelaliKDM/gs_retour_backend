<?php

return [
  'title' => [
    'wallet' => 'Wallet payments',
    'invoice' => 'Invoice payments',
  ],
  'breadcrumb' => 'Payments',
  'browse' => [
    'wallet' => 'Wallet payments',
    'invoice' => 'Invoice payments',
  ],

  'actions' => [
    'info' => 'Info',
    'delete' => 'Delete',
    'accept' => 'Accept',
    'reject' => 'Reject',
  ],

  'table' => [
    'header' => [
      'wallet' => 'Wallet payments table',
      'invoice' => 'Invoice payments table',
    ],
    'user' => 'User',
    'amount' => 'Amount',
    'type' => 'Type',
    'status' => 'Status',
    'created_at' => 'Date',
    'actions' => 'Actions',
  ],

  'types' => [
    'wallet' => 'Wallet',
    'invoice' => 'Invoice',
  ],

  'statuses' => [
    'pending' => 'Pending',
    'failed' => 'Failed',
    'paid' => 'Paid',
  ],

  'payment_methods' => [
    'wallet' => 'Wallet',
    'ccp' => 'CCP',
    'baridi' => 'Baridi Mob',
    'chargily' => 'Chargily Pay',
  ],

  'modals' => [
    'delete' => 'Delete Payment',
    'accept' => 'Accept Payment',
    'reject' => 'Reject Payment',
    'info' => 'Payment Information',
    'wallet_info' => 'Wallet Payment Information',
    'invoice_info' => 'Invoice Payment Information',
  ],
  'payer_information' => 'Payer Information',
  'payment_information' => 'Payment Information',
  'wallet_information' => 'Wallet Information',
  'invoice_information' => 'Invoice Information',
  'labels' => [
    'name' => 'Name',
    'phone' => 'Phone',
    'email' => 'Email',
    'type' => 'Type',
    'amount' => 'Amount',
    'status' => 'Status',
    'paid_at' => 'Paid At',
    'account_number' => 'Account Number',
    'receipt' => 'Receipt',
    'payment_method' => 'Payment Method',
    'balance' => 'Current Balance',
    'charges' => 'Number of Charges',
    'total_amount' => 'Total Amount',
    'tax_amount' => 'Tax Amount',
    'month' => 'Invoice Month',
  ],

  'accept' => [
    'confirmation' => 'Confirm Payment Acceptance',
    'notice' => 'This will mark the payment as approved and complete the transaction.',
    'confirm_checkbox' => 'I confirm this payment should be accepted',
  ],

  'reject' => [
    'confirmation' => 'Confirm Payment Rejection',
    'notice' => 'This will mark the payment as rejected and notify the payer.',
    'confirm_checkbox' => 'I confirm this payment should be rejected',
  ],
];
