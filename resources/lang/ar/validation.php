<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute يجب الموافقة عليها',
    'active_url' => ':attribute رابط غير صحيح',
    'after' => ':attribute يجب أن تكون تارخ بعد :date.',
    'after_or_equal' => ':attribute يجب أن تكون تاريخ احدث أو مطابق لـ :date.',
    'alpha' => ':attribute يجب ان يحتوي على احرف فقط',
    'alpha_dash' => ':attribute يجب أن تتألف من أرقام واحرف وعلامة شريطية فقط',
    'alpha_num' => ':attribute يجب أن تتكون من أحرف وارقام فقط',
    'array' => ':attribute must be an array.',
    'before' => ':attribute يجب ان يكون تاريخ قبل :date.',
    'before_or_equal' => ':attribute يجب ان يكون تاريخ قبل أو مطابق لـ :date.',
    'between' => [
        'numeric' => ' :attribute يجب أن تكون ما بين :min و :max.',
        'file' => ' :attribute يجب أن تكون ما بين :min و :max كيلوبايت.',
        'string' => ' :attribute يجب أن تكون ما بين :min و :max احرف.',
        'array' => ' :attribute يجب أن تكون ما بين :min و :max سلع.',
    ],
    'boolean' => ' :attribute يجب أن تكون صحيحة أو خاطئة',
    'confirmed' => ' :attribute التأكيد غير مطابق',
    'date' => ' :attribute تاريخ غير صحيح',
    'date_equals' => ' :attribute يجب أن يكون تاريخ مطابق لـ :date.',
    'date_format' => ' :attribute غير مطابق للصيغة :format.',
    'different' => ' :attribute و :other يجب أن يكونو مختلفين',
    'digits' => ' :attribute يجب ان تتألف من :digits ارقام.',
    'digits_between' => ' :attribute يجب ان تكون مابين :min و :max أرقام',
    'dimensions' => ' :attribute يحوي ابعاد صورة غير صحيحة',
    'distinct' => ' :attribute يحوي قيمة مكررة',
    'email' => ' :attribute يجب ان يتكون من بريد الكتروني صحيح',
    'ends_with' => ' :attribute يجب أن ينتهي بإحدى القيم التالية :values',
    'exists' => ' المعين :attribute غير صحيح.',
    'file' => ' :attribute يجب أن يكون بصيغة ملف',
    'filled' => ' :attribute يجب ان يحوي قيمة',
    'gt' => [
        'numeric' => ' :attribute يجب أن يكون اكبر من than :value.',
        'file' => ' :attribute يجب أن يكون اكبر من :value كيلوبايت.',
        'string' => ' :attribute يجب أن يكون اكبر من :value أحرف.',
        'array' => ' :attribute يجب أن يكون اكبر من :value سلع.',
    ],
    'gte' => [
        'numeric' => ' :attribute يجب أن يكون أكبر من أو يساوي :value.',
        'file' => ' :attribute يجب أن يكون أكبر من أو يساوي :value كيلوبايت.',
        'string' => ' :attribute يجب أن يكون أكبر من أو يساوي :value أحرف.',
        'array' => ' :attribute يجب ان يحوي :value سلع أو اكثر.',
    ],
    'image' => ' :attribute يجب أن يكون صورة.',
    'in' => ' المعين :attribute غير صحيح.',
    'in_array' => ' :attribute الخانة لا توجد في :other.',
    'integer' => ' :attribute يجب ان تكون رقم صحيح.',
    'ip' => ' :attribute يجب أن يكون عنوان كمبيوتر متصل بالشبكة صحيح IP address.',
    'ipv4' => ' :attribute يجب أن يكون عنوان IPv4 صحيح.',
    'ipv6' => ' :attribute يجب أن يكون عنوان IPv6 address.',
    'json' => ' :attribute يجب أن يكون صيغة JSON نص.',
    'lt' => [
        'numeric' => ' :attribute يجب أن يكون اقل من :value.',
        'file' => ' :attribute يجب ان يكون اقل من :value كيلو بايت.',
        'string' => ' :attribute يجب ان يكون اقل من than :value احرف.',
        'array' => ' :attribute يجب ان يكون اقل من :value سلع.',
    ],
    'lte' => [
        'numeric' => ' :attribute يجب أن يكون اقل أو اكثر من :value.',
        'file' => ' :attribute يجب ان يكون اقل أو يساوي :value كيلو بايت.',
        'string' => ' :attribute يجب ان يكون اقل أو يساوي :value احرف.',
        'array' => ' :attribute يجب أن لا يكون اكثر من :value سلع.',
    ],
    'max' => [
        'numeric' => ' :attribute يجب أن لا يكون اكبر من :max.',
        'file' => ' :attribute يجب أن لا يكون اكبر من :max كيلو بايت.',
        'string' => ' :attribute يجب أن لا يكون اكبر من :max احرف.',
        'array' => ' :attribute يجب أن لا يكون اكبر من :max سلع.',
    ],
    'mimes' => ' :attribute يجب ان يكون ملف صيغة :values.',
    'mimetypes' => ' :attribute يجب ان يكون ملف صيغة: :values.',
    'min' => [
        'numeric' => ' :attribute يجب أن يكون على الأقل :min.',
        'file' => ' :attribute يجب أن يكون على الأقل :min كيلو بايت.',
        'string' => ' :attribute يجب أن يكون على الأقل :min احرف.',
        'array' => ' :attribute يجب أن يكون على الأقل :min سلع.',
    ],
    'not_in' => ' المعين :attribute غير صحيح.',
    'not_regex' => ' :attribute صيغة غير صحيحة.',
    'numeric' => ' :attribute يجب أن يكون رقم.',
    'present' => ' :attribute خانة يجب أن تكون موجودة.',
    'regex' => ' :attribute صيغة غير صحيحة',
    'required' => ' :attribute خانة مطلوبة',
    'required_if' => ' :attribute خانة مطلوبة عندما :other تكون :value.',
    'required_unless' => ' :attribute خانة مطلوبة الا اذا :other موجودة في :values.',
    'required_with' => ' :attribute خانة مطلوبة عندما :values تكون موجودة.',
    'required_with_all' => ' :attribute خانة مطلوبة عندما :values موجودة.',
    'required_without' => ' :attribute خانة مطلوبة عندما :values تكون غير موجودة.',
    'required_without_all' => ' :attribute خانة مطلوبة عندما لا يوجد احدى هذه القيم :values',
    'same' => ' :attribute و :other يجب ان يتطابقا.',
    'size' => [
        'numeric' => ' :attribute يجب أن يكون :size.',
        'file' => ' :attribute يجب أن يكون  :size كيلوبايت.',
        'string' => ' :attribute يجب أن يكون :size احرف.',
        'array' => ' :attribute يجب ان يحوي على :size سلع.',
    ],
    'starts_with' => ' :attribute يجب ان تبدأ باحدى القيم التالية: :values',
    'string' => ' :attribute يجب ان تكون صيغة نص',
    'timezone' => ' :attribute نطاق زمني صحيح',
    'unique' => ' :attribute مسجل مسبقا',
    'uploaded' => ' :attribute لم تتم عملية الرفع بنجاح',
    'url' => ' :attribute صيغة غير صحيحة.',
    'uuid' => ' :attribute صيغة UUID. صحيحة',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
