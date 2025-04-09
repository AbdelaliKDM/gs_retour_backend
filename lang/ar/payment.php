<?php

return [
  'title' => [
    'wallet' => 'مدفوعات المحافظ',
    'invoice' => 'مدفوعات الفواتير',
  ],
  'breadcrumb' => 'المدفوعات',
  'browse' => [
    'wallet' => 'مدفوعات المحافظ',
    'invoice' => 'مدفوعات الفواتير',
  ],

  'actions' => [
    'info' => 'التفاصيل',
    'delete' => 'حذف',
    'accept' => 'قبول',
    'reject' => 'رفض',
  ],

  'table' => [
    'header' => [
      'wallet' => 'جدول مدفوعات المحافظ',
      'invoice' => 'جدول مدفوعات الفواتير',
    ],
    'user' => 'المستخدم',
    'amount' => 'المبلغ',
    'type' => 'النوع',
    'status' => 'الحالة',
    'created_at' => 'التاريخ',
    'actions' => 'الإجراءات',
    'id' => 'المعرف',
    'month' => 'الشهر',
  ],

  'types' => [
    'wallet' => 'محفظة',
    'invoice' => 'فاتورة',
  ],

  'statuses' => [
    'pending' => 'قيد الانتظار',
    'failed' => 'فاشل',
    'paid' => 'مدفوع',
    'unpaid' => 'غير مدفوع',
    'unpayable' => 'غير قابل للدفع',
  ],

  'payment_methods' => [
    'wallet' => 'محفظة',
    'ccp' => 'الحساب الجاري البريدي',
    'baridi' => 'بريدي موب',
    'chargily' => 'شارجيلي باي',
  ],

  'modals' => [
    'delete' => 'حذف الدفع',
    'accept' => 'قبول الدفع',
    'reject' => 'رفض الدفع',
    'info' => 'معلومات الدفع',
    'wallet_info' => 'معلومات دفع المحفظة',
    'invoice_info' => 'معلومات دفع الفاتورة',
  ],
  'payer_information' => 'معلومات الدافع',
  'payment_information' => 'معلومات الدفع',
  'wallet_information' => 'معلومات المحفظة',
  'invoice_information' => 'معلومات الفاتورة',
  'labels' => [
    'name' => 'الاسم',
    'phone' => 'الهاتف',
    'email' => 'البريد الإلكتروني',
    'type' => 'النوع',
    'amount' => 'المبلغ',
    'status' => 'الحالة',
    'paid_at' => 'تاريخ الدفع',
    'account_number' => 'رقم الحساب',
    'receipt' => 'الإيصال',
    'payment_method' => 'طريقة الدفع',
    'balance' => 'الرصيد الحالي',
    'charges' => 'عدد الشحنات',
    'total_amount' => 'المبلغ الإجمالي',
    'tax_amount' => 'مبلغ الضريبة',
    'month' => 'شهر الفاتورة',
  ],

  'accept' => [
    'confirmation' => 'تأكيد قبول الدفع',
    'notice' => 'سيؤدي هذا إلى وضع علامة على الدفع على أنه مقبول وإكمال العملية.',
    'confirm_checkbox' => 'أؤكد أنه يجب قبول هذا الدفع',
  ],

  'reject' => [
    'confirmation' => 'تأكيد رفض الدفع',
    'notice' => 'سيؤدي هذا إلى وضع علامة على الدفع على أنه مرفوس وإخطار الدافع.',
    'confirm_checkbox' => 'أؤكد أنه يجب رفض هذا الدفع',
  ],

  'wallet' => [
    'wallet_information' => 'معلومات المحفظة',
    'balance' => 'الرصيد',
    'no_payments' => 'لا توجد مدفوعات',
  ],

  'invoice' => [
    'invoice_information' => 'معلومات الفاتورة',
    'total_due' => 'المبلغ المستحق',
    'no_invoices' => 'لا توجد فواتير',
  ],
];
