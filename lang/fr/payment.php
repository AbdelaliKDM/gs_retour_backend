<?php

return [
  'title' => [
    'wallet' => 'Paiements portefeuille',
    'invoice' => 'Paiements factures',
  ],
  'breadcrumb' => 'Paiements',
  'browse' => [
    'wallet' => 'Paiements portefeuille',
    'invoice' => 'Paiements factures',
  ],

  'actions' => [
    'info' => 'Détails',
    'delete' => 'Supprimer',
    'accept' => 'Accepter',
    'reject' => 'Rejeter',
  ],

  'table' => [
    'header' => [
      'wallet' => 'Tableau des paiements portefeuille',
      'invoice' => 'Tableau des paiements factures',
    ],
    'user' => 'Utilisateur',
    'amount' => 'Montant',
    'type' => 'Type',
    'status' => 'Statut',
    'created_at' => 'Date',
    'actions' => 'Actions',
  ],

  'types' => [
    'wallet' => 'Portefeuille',
    'invoice' => 'Facture',
  ],

  'statuses' => [
    'pending' => 'En attente',
    'failed' => 'Échoué',
    'paid' => 'Payé',
  ],

  'modals' => [
    'delete' => 'Supprimer le paiement',
    'accept' => 'Accepter le paiement',
    'reject' => 'Rejeter le paiement',
    'info' => 'Informations de paiement',
    'wallet_info' => 'Informations de paiement portefeuille',
    'invoice_info' => 'Informations de paiement facture',
  ],

  'payment_methods' => [
    'wallet' => 'Portefeuille',
    'ccp' => 'CCP',
    'baridi' => 'Baridi Mob',
    'chargily' => 'Chargily Pay',
  ],

  'payer_information' => 'Informations du payeur',
  'payment_information' => 'Informations de paiement',
  'wallet_information' => 'Informations du portefeuille',
  'invoice_information' => 'Informations de la facture',
  'labels' => [
    'name' => 'Nom',
    'phone' => 'Téléphone',
    'email' => 'Email',
    'type' => 'Type',
    'amount' => 'Montant',
    'status' => 'Statut',
    'paid_at' => 'Payé le',
    'account_number' => 'Numéro de compte',
    'receipt' => 'Reçu',
    'payment_method' => 'Méthode de paiement',
    'balance' => 'Solde actuel',
    'charges' => 'Nombre de charges',
    'total_amount' => 'Montant total',
    'tax_amount' => 'Montant des taxes',
    'month' => 'Mois de facturation',
  ],

  'accept' => [
    'confirmation' => 'Confirmer l\'acceptation du paiement',
    'notice' => 'Cela marquera le paiement comme approuvé et complétera la transaction.',
    'confirm_checkbox' => 'Je confirme que ce paiement doit être accepté',
  ],

  'reject' => [
    'confirmation' => 'Confirmer le rejet du paiement',
    'notice' => 'Cela marquera le paiement comme rejeté et en informera le payeur.',
    'confirm_checkbox' => 'Je confirme que ce paiement doit être rejeté',
  ],
];
