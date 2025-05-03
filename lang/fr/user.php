<?php

return [
  'title' => [
    'renter' => 'Locataires',
    'driver' => 'Chauffeurs',
    'inactive' => 'Inactifs',
    'suspended' => 'Suspendus',
  ],
  'breadcrumb' => 'Utilisateurs',
  'browse' => [
    'renter' => 'Locataires',
    'driver' => 'Chauffeurs',
    'inactive' => 'Inactifs',
    'suspended' => 'Suspendus'
  ],
  'actions' => [
    'create' => 'Créer',
    'update' => 'Mettre à jour',
    'delete' => 'Supprimer',
    'restore' => 'Restaurer',
    'accept' => 'Activer',
    'reject' => 'Suspendre',
    'info' => 'Informations',
  ],
  'table' => [
    'header' => [
      'renter' => 'Tableau des locataires',
      'driver' => 'Tableau des chauffeurs',
      'inactive' => 'Tableau des utilisateurs inactifs',
      'suspended' => 'Tableau des utilisateurs suspendus'
    ],
    'name' => 'Nom',
    'email' => 'Email',
    'phone' => 'Téléphone',
    'role' => 'Rôle',
    'status' => 'Statut',
    'created_at' => 'Créé le',
    'actions' => 'Actions',
  ],
  'modals' => [
    'create' => 'Créer un utilisateur',
    'update' => 'Mettre à jour l\'utilisateur',
    'delete' => 'Supprimer l\'utilisateur',
    'restore' => 'Restaurer l\'utilisateur',
    'info' => 'Informations utilisateur',
    'accept' => 'Activer l\'utilisateur',
    'reject' => 'Suspendre l\'utilisateur',
    'activate' => 'Activer l\'utilisateur',
    'suspend' => 'Suspendre l\'utilisateur',
  ],
  'labels' => [
    'name' => 'Nom',
    'email' => 'Email',
    'password' => 'Mot de passe',
    'id' => 'Identifiant',
    'phone' => 'Numéro de téléphone',
    'created_at' => 'Créé le',
    'id_card' => 'Carte d\'identité',
    'id_card_selfie' => 'Selfie avec carte d\'identité',
  ],
  'placeholders' => [
    'name' => 'Entrez votre nom',
    'email' => 'Entrez votre email',
  ],

  'roles' => [
    'null' => 'Non sélectionné',
    'renter' => 'Locataire',
    'driver' => 'Chauffeur',
    'admin' => 'Administrateur'
  ],

  'statuses' => [
    'active' => 'Actif',
    'inactive' => 'Inactif',
    'suspended' => 'Suspendu',
  ],

  'user_information' => 'Informations utilisateur',

  'truck' => [
    'title' => 'Informations sur le camion',
    'type' => 'Type de camion',
    'serial_number' => 'Numéro de série',
    'gray_card' => 'Carte grise',
    'driving_license' => 'Permis de conduire',
    'insurance_certificate' => 'Certificat d\'assurance',
    'insurance_expiry_date' => 'Expiration de l\'assurance',
    'inspection_certificate' => 'Certificat d\'inspection',
    'next_inspection_date' => 'Prochaine inspection due',
    'affiliated_with_agency' => 'Affiliation à une agence',
    'agency_document' => 'Document d\'agence',
    'truck_information' => 'Informations du camion',
    'truck_type' => 'Type de camion',
    'documents' => 'Documents du camion',
    'images' => 'Images du camion',
  ],

  'account_settings' => 'Paramètres du compte',
  'account' => 'Compte',
  'profile_details' => 'Détails du profil',
  'change_password' => 'Changer le mot de passe',
  'current_password' => 'Mot de passe actuel',
  'new_password' => 'Nouveau mot de passe',
  'confirm_new_password' => 'Confirmer le nouveau mot de passe',

  'accept' => [
    'confirmation' => 'Confirmer l\'activation de l\'utilisateur',
    'notice' => 'L\'activation restaurera l\'accès complet à toutes les fonctionnalités pour cet utilisateur.',
    'confirm_checkbox' => 'Je confirme vouloir activer cet utilisateur',
  ],

  'reject' => [
    'confirmation' => 'Confirmer la désactivation de l\'utilisateur',
    'warning' => 'La désactivation entraînera un accès limité aux fonctionnalités pour cet utilisateur.',
    'reason' => 'Raison de désactivation',
    'confirm_checkbox' => 'Je confirme vouloir désactiver cet utilisateur',
  ],

  'reasons' => [
    'admin' => 'Décision de l\'administrateur',
    'profile' => 'Informations de profil incomplètes',
    'truck' => 'Informations sur le camion incomplètes',
    'invoice' => 'Factures impayées',
  ],

  'documents' => 'Documents d\'utilisateur',

  'activate' => [
    'confirmation' => 'Confirmer l\'activation de l\'utilisateur',
    'notice' => 'L\'activation rétablira l\'accès complet de l\'utilisateur à toutes les fonctionnalités.',
    'confirm_checkbox' => 'Je confirme que je souhaite activer cet utilisateur',
  ],

  'suspend' => [
    'confirmation' => 'Confirmer la suspension de l\'utilisateur',
    'warning' => 'La suspension entraînera un accès limité aux fonctionnalités pour cet utilisateur.',
    'confirm_checkbox' => 'Je confirme que je souhaite suspendre cet utilisateur',
  ],

  'profile_message' => 'Cet utilisateur a un profil incomplet qui doit être examiné.',
  'truck_message' => 'Cet utilisateur a des informations de camion incomplètes qui doivent être examinées.',
];
