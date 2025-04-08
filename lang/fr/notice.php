<?php

return [
    'title' => 'Avis',
    'breadcrumb' => 'Avis',
    'browse' => 'Parcourir les avis',
    'actions' => [
        'create' => 'Créer',
        'edit' => 'Modifier',
        'delete' => 'Supprimer',
        'send' => 'Envoyer',
        'view' => 'Voir',
    ],

    'table' => [
        'header' => 'Liste des avis',
        'title' => 'Titre',
        'content' => 'Contenu',
        'priority' => 'Priorité',
        'created_at' => 'Créé le',
        'actions' => 'Actions',
    ],

    'modals' => [
        'create' => 'Créer un avis',
        'update' => 'Mettre à jour l\'avis',
        'delete' => 'Supprimer l\'avis',
        'send' => 'Envoyer l\'avis',
    ],

    'labels' => [
        'title_ar' => 'Titre (Arabe)',
        'title_en' => 'Titre (Anglais)',
        'title_fr' => 'Titre (Français)',
        'content_ar' => 'Contenu (Arabe)',
        'content_en' => 'Contenu (Anglais)',
        'content_fr' => 'Contenu (Français)',
        'priority' => 'Niveau de priorité',
        'recipient_type' => 'Envoyer à',
        'delivery_method' => 'Méthode de livraison',
    ],

    'placeholders' => [
        'title_ar' => 'Entrez le titre en arabe',
        'title_en' => 'Entrez le titre en anglais',
        'title_fr' => 'Entrez le titre en français',
        'content_ar' => 'Entrez le contenu en arabe',
        'content_en' => 'Entrez le contenu en anglais',
        'content_fr' => 'Entrez le contenu en français',
    ],

    'priority' => [
        'optional' => 'Optionnel',
        'required' => 'Obligatoire',
    ],

    'recipients' => [
        'all' => 'Tous les utilisateurs (Locataires & Chauffeurs)',
        'renters' => 'Locataires seulement',
        'drivers' => 'Chauffeurs seulement',
    ],

    'delivery' => [
        'app_only' => 'Notification dans l\'application uniquement',
        'app_and_push' => 'Dans l\'application + Notification push (FCM)',
    ],

    'hints' => [
        'priority' => 'Sélectionnez l\'urgence/importance de cet avis',
    ],

    'accept' => [
        'confirmation' => 'Confirmer l\'activation de l\'avis',
        'notice' => 'L\'activation rendra cet avis visible aux utilisateurs.',
        'confirm_checkbox' => 'Je confirme vouloir activer cet avis',
    ],

    'reject' => [
        'confirmation' => 'Confirmer la désactivation de l\'avis',
        'warning' => 'La désactivation masquera cet avis aux utilisateurs.',
        'confirm_checkbox' => 'Je confirme vouloir désactiver cet avis',
    ],

    'send' => [
        'confirmation' => 'Confirmer l\'envoi de l\'avis',
        'notice' => 'Cet avis sera envoyé aux destinataires sélectionnés.',
        'confirm_checkbox' => 'Je confirme vouloir envoyer cet avis',
    ],
];