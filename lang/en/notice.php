<?php

return [
    'title' => 'Notices',
    'breadcrumb' => 'Notices',
    'browse' => 'Browse Notices',
    'actions' => [
        'create' => 'Create',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'send' => 'Send',
        'view' => 'View',
    ],

    'table' => [
        'header' => 'Notices List',
        'title' => 'Title',
        'content' => 'Content',
        'priority' => 'Priority',
        'created_at' => 'Created At',
        'actions' => 'Actions',
    ],

    'modals' => [
        'create' => 'Create Notice',
        'update' => 'Update Notice',
        'delete' => 'Delete Notice',
        'send' => 'Send Notice',
    ],

    'labels' => [
        'title_ar' => 'Title (Arabic)',
        'title_en' => 'Title (English)',
        'title_fr' => 'Title (French)',
        'content_ar' => 'Content (Arabic)',
        'content_en' => 'Content (English)',
        'content_fr' => 'Content (French)',
        'priority' => 'Priority Level',
        'recipient_type' => 'Send To',
        'delivery_method' => 'Delivery Method',
    ],

    'placeholders' => [
        'title_ar' => 'Enter notice title in Arabic',
        'title_en' => 'Enter notice title in English',
        'title_fr' => 'Enter notice title in French',
        'content_ar' => 'Enter notice content in Arabic',
        'content_en' => 'Enter notice content in English',
        'content_fr' => 'Enter notice content in French',
    ],


    'priority' => [
        'optional' => 'Optional',
        'required' => 'Required',
    ],

    'recipients' => [
        'all' => 'All Users (Renters & Drivers)',
        'renters' => 'Renters Only',
        'drivers' => 'Drivers Only',
    ],

    'delivery' => [
        'app_only' => 'In-App Notification Only',
        'app_and_push' => 'In-App + Push Notification (FCM)',
    ],

    'hints' => [
        'priority' => 'Select how urgent/important this notice is',
    ],

    'accept' => [
        'confirmation' => 'Confirm Notice Activation',
        'notice' => 'Activating will make this notice visible to users.',
        'confirm_checkbox' => 'I confirm that I want to activate this notice',
    ],

    'reject' => [
        'confirmation' => 'Confirm Notice Deactivation',
        'warning' => 'Deactivating will hide this notice from users.',
        'confirm_checkbox' => 'I confirm that I want to deactivate this notice',
    ],

    'send' => [
        'confirmation' => 'Confirm Notice Distribution',
        'notice' => 'This will send the notice to selected recipients.',
        'confirm_checkbox' => 'I confirm I want to send this notice',
    ],

];