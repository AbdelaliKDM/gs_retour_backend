<?php

return [
  'profile' => [

    'active' => [
      'default' => [
        'title' => 'Mise à jour du statut du profil',
        'content' => 'Votre profil est maintenant actif et entièrement fonctionnel.',
      ],
      'suspended' => [
        'admin' => [
          'title' => 'Profil Suspendu par un Administrateur',
          'content' => 'Votre profil a été suspendu par un administrateur. Veuillez contacter le support pour plus d\'informations.',
        ],
        'invoice' => [
          'title' => 'Profil Suspendu - Facture Non Payée',
          'content' => 'Votre profil a été suspendu en raison d\'une facture impayée. Veuillez régler votre paiement en attente pour réactiver votre compte.',
        ],
        'profile' => [
          'title' => 'Profil Suspendu - Informations Incomplètes',
          'content' => 'Votre profil est actuellement suspendu en raison d\'informations manquantes ou incomplètes. Veuillez mettre à jour vos détails pour réactiver votre compte.',
        ],
        'truck' => [
          'title' => 'Profil Suspendu - Informations sur le Véhicule Manquantes',
          'content' => 'Votre profil est suspendu en raison d\'informations incomplètes sur le véhicule. Veuillez fournir les détails requis du véhicule pour réactiver votre compte.',
        ],
        'inactive' => [
            'profile' => [
              'title' => 'Profil Inactif - En Attente d\'Approbation',
              'content' => 'Votre compte est temporairement inactif jusqu\'à ce que l\'administrateur approuve vos informations de profil mises à jour. Merci pour votre patience.',
            ],
            'truck' => [
              'title' => 'Profil Inactif - Informations du Camion en Attente',
              'content' => 'Votre compte est temporairement inactif jusqu\'à ce que l\'administrateur approuve les informations mises à jour de votre camion. Merci pour votre patience.',
            ],
            'payment' => [
              'title' => 'Profil Inactif - Vérification de Paiement',
              'content' => 'Votre compte est temporairement inactif jusqu\'à ce que l\'administrateur vérifie votre paiement récent. Merci pour votre patience.',
            ],
          ],
      ],
    ],

  ],

  'review' => [
    'title' => 'Nouvelle Revue Reçue',
    'content' => 'Une nouvelle revue avec une note de :rating étoiles a été soumise pour votre voyage.',
  ],

  'trip' => [
    'ongoing' => [
      'title' => 'Voyage en Cours',
      'content' => 'Votre voyage (ID : :id) est actuellement en cours.',
    ],
    'paused' => [
      'title' => 'Voyage Mis en Pause',
      'content' => 'Votre voyage (ID : :id) a été temporairement mis en pause.',
    ],
    'canceled' => [
      'title' => 'Voyage Annulé',
      'content' => 'Votre voyage (ID : :id) a été annulé.',
    ],
    'completed' => [
      'title' => 'Voyage Terminé',
      'content' => 'Félicitations ! Votre voyage (ID : :id) a été accompli avec succès.',
    ],
  ],

  'shipment' => [
    'shipped' => [
      'title' => 'Expédition Envoyée',
      'content' => 'Votre expédition (ID : :shipment_id) a été expédiée et est en route.',
    ],
    'delivered' => [
      'title' => 'Expédition Livrée',
      'content' => 'Votre expédition (ID : :shipment_id) a été livrée avec succès.',
    ],
  ],

  'order' => [
    'created' => [
      'title' => 'Nouvelle Commande Reçue',
      'content' => 'Vous avez reçu une nouvelle commande (ID : :order_id). Veuillez la examiner et la traiter.',
    ],
    'accepted' => [
      'title' => 'Commande Acceptée',
      'content' => 'Votre commande (ID : :order_id) a été acceptée.',
    ],
    'rejected' => [
      'title' => 'Commande Rejetée',
      'content' => 'Malheureusement, votre commande (ID : :order_id) a été rejetée.',
    ],
  ],

  'payment' => [
    'wallet' => [
      'paid' => [
        'title' => 'Paiement du Portefeuille Réussi',
        'content' => 'Votre paiement du portefeuille a été traité avec succès.',
      ],
      'failed' => [
        'title' => 'Échec du Paiement du Portefeuille',
        'content' => 'Un problème est survenu lors du traitement de votre paiement du portefeuille. Veuillez réessayer.',
      ],
    ],
    'invoice' => [
      'paid' => [
        'title' => 'Paiement de Facture Terminé',
        'content' => 'Votre paiement de facture a été effectué avec succès.',
      ],
      'failed' => [
        'title' => 'Échec du Paiement de Facture',
        'content' => 'Le paiement de la facture a échoué. Veuillez vérifier et réessayer.',
      ],
    ],
  ],
];
