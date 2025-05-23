<?php

return [
  'title' => [
    'renter' => 'المستأجرين',
    'driver' => 'السائقين',
    'inactive' => 'غير نشط',
    'suspended' => 'معلق',
  ],
  'breadcrumb' => 'المستخدمين',
  'browse' => [
    'renter' => 'المستأجرون',
    'driver' => 'السائقون',
    'inactive' => 'غير النشطون',
    'suspended' => 'المعلقون'
  ],
  'actions' => [
    'create' => 'إنشاء',
    'update' => 'تحديث',
    'delete' => 'حذف',
    'restore' => 'استعادة',
    'accept' => 'تفعيل',
    'reject' => 'تعليق',
    'info' => 'التفاصيل',
  ],
  'table' => [
    'header' => [
      'renter' => 'جدول المستأجرين',
      'driver' => 'جدول السائقين',
      'inactive' => 'جدول المستخدمين غير النشطين',
      'suspended' => 'جدول المستخدمين المعلقين'
    ],
    'name' => 'الاسم',
    'email' => 'البريد الإلكتروني',
    'phone' => 'الهاتف',
    'role' => 'الدور',
    'status' => 'الحالة',
    'created_at' => 'تاريخ الإنشاء',
    'actions' => 'الإجراءات',
  ],
  'modals' => [
    'create' => 'إنشاء مستخدم',
    'update' => 'تحديث المستخدم',
    'delete' => 'حذف المستخدم',
    'restore' => 'استعادة المستخدم',
    'info' => 'معلومات المستخدم',
    'accept' => 'تفعيل المستخدم',
    'reject' => 'تعليق المستخدم',
    'activate' => 'تفعيل المستخدم',
    'suspend' => 'تعليق المستخدم',
  ],
  'labels' => [
    'name' => 'الاسم',
    'email' => 'البريد الإلكتروني',
    'password' => 'كلمة المرور',
    'id' => 'المعرف',
    'phone' => 'رقم الهاتف',
    'created_at' => 'تاريخ الإنشاء',
    'id_card' => 'بطاقة الهوية',
    'id_card_selfie' => 'سيلفي مع بطاقة الهوية',
  ],
  'placeholders' => [
    'name' => 'أدخل اسمك',
    'email' => 'أدخل بريدك الإلكتروني',
  ],

  'roles' => [
    'null' => 'غير محدد',
    'renter' => 'مستأجر',
    'driver' => 'سائق',
    'admin' => 'مدير'
  ],

  'statuses' => [
    'active' => 'نشط',
    'inactive' => 'غير نشط',
    'suspended' => 'معلق',
  ],

  'user_information' => 'معلومات المستخدم',

  'truck' => [
    'title' => 'معلومات الشاحنة',
    'type' => 'نوع الشاحنة',
    'serial_number' => 'الرقم التسلسلي',
    'gray_card' => 'البطاقة الرمادية',
    'driving_license' => 'رخصة القيادة',
    'insurance_certificate' => 'شهادة التأمين',
    'insurance_expiry_date' => 'انتهاء التأمين',
    'inspection_certificate' => 'شهادة الفحص',
    'next_inspection_date' => 'موعد الفحص القادم',
    'affiliated_with_agency' => 'الانتماء لوكالة',
    'agency_document' => 'وثيقة الوكالة',
    'truck_information' => 'معلومات الشاحنة',
    'truck_type' => 'نوع الشاحنة',
    'documents' => 'وثائق الشاحنة',
    'images' => 'صور الشاحنة',
  ],

  'account_settings' => 'إعدادات الحساب',
  'account' => 'الحساب',
  'profile_details' => 'تفاصيل الملف الشخصي',
  'change_password' => 'تغيير كلمة المرور',
  'current_password' => 'كلمة المرور الحالية',
  'new_password' => 'كلمة المرور الجديدة',
  'confirm_new_password' => 'تأكيد كلمة المرور الجديدة',

  'accept' => [
    'confirmation' => 'تأكيد تفعيل المستخدم',
    'notice' => 'التفعيل سيعيد للمستخدم الوصول الكامل لجميع الميزات.',
    'confirm_checkbox' => 'أؤكد رغبتي في تفعيل هذا المستخدم',
  ],

  'reject' => [
    'confirmation' => 'تأكيد تعطيل المستخدم',
    'warning' => 'التعطيل سيؤدي إلى وصول محدود للميزات لهذا المستخدم.',
    'reason' => 'سبب التعطيل',
    'confirm_checkbox' => 'أؤكد رغبتي في تعطيل هذا المستخدم',
  ],

  'reasons' => [
    'admin' => 'قرار المدير',
    'profile' => 'معلومات الملف الشخصي غير مكتملة',
    'truck' => 'معلومات الشاحنة غير مكتملة',
    'invoice' => 'فواتير غير مدفوعة',
  ],

  'documents' => 'وثائق المستخدم',

  'activate' => [
    'confirmation' => 'تأكيد تنشيط المستخدم',
    'notice' => 'سيؤدي التنشيط إلى استعادة المستخدم للوصول الكامل إلى جميع الوظائف.',
    'confirm_checkbox' => 'أؤكد أنني أريد تنشيط هذا المستخدم',
  ],

  'suspend' => [
    'confirmation' => 'تأكيد تعليق المستخدم',
    'warning' => 'سيؤدي التعليق إلى وصول محدود إلى الوظائف لهذا المستخدم.',
    'confirm_checkbox' => 'أؤكد أنني أريد تعليق هذا المستخدم',
  ],

  'profile_message' => 'هذا المستخدم لديه ملف تعريف غير مكتمل يحتاج إلى مراجعة.',
  'truck_message' => 'هذا المستخدم لديه معلومات شاحنة غير مكتملة تحتاج إلى مراجعة.',
];
