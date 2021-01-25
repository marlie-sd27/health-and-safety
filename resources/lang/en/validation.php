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

    'accepted' => 'The value must be accepted.',
    'active_url' => 'The value is not a valid URL.',
    'after' => 'The value must be a date after :date.',
    'after_or_equal' => 'The value must be a date after or equal to :date.',
    'alpha' => 'The value may only contain letters.',
    'alpha_dash' => 'The value may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The value may only contain letters and numbers.',
    'array' => 'The value must be an array.',
    'before' => 'The value must be a date before :date.',
    'before_or_equal' => 'The value must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The value must be between :min and :max.',
        'file' => 'The value must be between :min and :max kilobytes.',
        'string' => 'The value must be between :min and :max characters.',
        'array' => 'The value must have between :min and :max items.',
    ],
    'boolean' => 'The value field must be true or false.',
    'confirmed' => 'The value confirmation does not match.',
    'date' => 'The value is not a valid date.',
    'date_equals' => 'The value must be a date equal to :date.',
    'date_format' => 'The value does not match the format :format.',
    'different' => 'The value and :other must be different.',
    'digits' => 'The value must be :digits digits.',
    'digits_between' => 'The value must be between :min and :max digits.',
    'dimensions' => 'The value has invalid image dimensions.',
    'distinct' => 'This value must not have any duplicates.',
    'email' => 'The value must be a valid email address.',
    'ends_with' => 'The value must end with one of the following: :values.',
    'exists' => 'The selected value is invalid.',
    'file' => 'The value must be a file.',
    'filled' => 'The value field must have a value.',
    'gt' => [
        'numeric' => 'The value must be greater than :value.',
        'file' => 'The value must be greater than :value kilobytes.',
        'string' => 'The value must be greater than :value characters.',
        'array' => 'The value must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The value must be greater than or equal :value.',
        'file' => 'The value must be greater than or equal :value kilobytes.',
        'string' => 'The value must be greater than or equal :value characters.',
        'array' => 'The value must have :value items or more.',
    ],
    'image' => 'The value must be an image.',
    'in' => 'The selected value is invalid.',
    'in_array' => 'The value field does not exist in :other.',
    'integer' => 'The value must be an integer.',
    'ip' => 'The value must be a valid IP address.',
    'ipv4' => 'The value must be a valid IPv4 address.',
    'ipv6' => 'The value must be a valid IPv6 address.',
    'json' => 'The value must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The value must be less than :value.',
        'file' => 'The value must be less than :value kilobytes.',
        'string' => 'The value must be less than :value characters.',
        'array' => 'The value must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The value must be less than or equal :value.',
        'file' => 'The value must be less than or equal :value kilobytes.',
        'string' => 'The value must be less than or equal :value characters.',
        'array' => 'The value must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'The value may not be greater than :max.',
        'file' => 'The value may not be greater than :max kilobytes.',
        'string' => 'The value may not be greater than :max characters.',
        'array' => 'The value may not have more than :max items.',
    ],
    'mimes' => 'The value must be a file of type: :values.',
    'mimetypes' => 'The value must be a file of type: :values.',
    'min' => [
        'numeric' => 'The value must be at least :min.',
        'file' => 'The value must be at least :min kilobytes.',
        'string' => 'The value must be at least :min characters.',
        'array' => 'The value must have at least :min items.',
    ],
    'not_in' => 'The selected value is invalid.',
    'not_regex' => 'The value format is invalid.',
    'numeric' => 'The value must be a number.',
    'password' => 'The password is incorrect.',
    'present' => 'The value field must be present.',
    'regex' => 'The value format is invalid.',
    'required' => 'This field is required.',
    'required_if' => 'The value field is required when :other is :value.',
    'required_unless' => 'The value field is required unless :other is in :values.',
    'required_with' => 'The value field is required when :values is present.',
    'required_with_all' => 'The value field is required when :values are present.',
    'required_without' => 'The value field is required when :values is not present.',
    'required_without_all' => 'The value field is required when none of :values are present.',
    'same' => 'The value and :other must match.',
    'size' => [
        'numeric' => 'The value must be :size.',
        'file' => 'The value must be :size kilobytes.',
        'string' => 'The value must be :size characters.',
        'array' => 'The value must contain :size items.',
    ],
    'starts_with' => 'The value must start with one of the following: :values.',
    'string' => 'The value must be a string.',
    'timezone' => 'The value must be a valid zone.',
    'unique' => 'The value has already been taken.',
    'uploaded' => 'The value failed to upload.',
    'url' => 'The value format is invalid.',
    'uuid' => 'The value must be a valid UUID.',

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
        'requirees_sites' => [
            'required_if' => 'At least one site must be checked',
        ],
        'requirees_emails' => [
            'required_if' => 'Please enter at least one email address'
        ]
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
