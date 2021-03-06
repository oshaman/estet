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

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'Поле :attribute должно содержать только буквы.',
    'alpha_dash'           => 'Поле :attribute может иметь буквенно-цифровые символы, а также тире и символы подчеркивания.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'Поле :attribute должно содержать от :min до :max символов.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'Не корректные данные в поле :attribute.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'В поле :attribute не дата.',
    'date_format'          => 'Данные в поле :attribute не соответствует формату :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'Поле :attribute должно содержать :digits цифр.',
    'digits_between'       => 'В поле :attribute должно быть от :min до :max цифр.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'В поле :attribute должен быть реальный адрес электронной почты.',
    'exists'               => 'Выбранное поле :attribute не является корректным.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'В поле :attribute должно быть изображение.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'Параметр в поле :attribute должен быть целым числом.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'Значение в поле :attribute не может быть больше :max.',
        'file'    => 'Размер файла в поле :attribute не должен превышать :max килобайт.',
        'string'  => 'Поле :attribute не должно содержать более :max символов.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'Для загрузки в поле :attribute допустимы следующие типы файлов: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'Значение в поле :attribute не должно быть меньше :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'Выбранное поле :attribute не является корректным.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'Недопустимые символы в поле :attribute.',
    'required'             => 'Поле :attribute обязательно к заполнению.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'Поле :attribute должно быть строкового типа.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'Значение в поле :attribute уже используется.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'В поле :attribute должен быть реальный адрес сайта.',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
