<?php

return [
    'custom_edit' => [
        'name' => [
            'required' => 'The name field is required.',
        ],
        'username' => [
            'required' => 'The username field is required.',
            'unique' => 'The username has already been taken.',
        ],
        'email' => [
            'email' => 'The email must be a valid email address.',
            'unique' => 'The email has already been taken.',
        ],
        'password' => [
            'required' => 'The password field is required.',
            'min' => 'The password must be at least 6 characters.',
        ],
        'status' => [
            'required' => 'The status field is required.',
        ],
        'current_password' => [
            'required' => 'The current password field is required.',
            'invalid' => 'The current password does not match.',
        ],
        'password' => [
            'required' => 'The new password field is required.',
            'min' => 'The new password must be at least 6 characters.',
            'confirmed' => 'The new password confirmation does not match.',
        ],
    ],


    'name.required' => 'The name field is required.',
    'code.required' => 'The code field is required.',
    'code.unique' => 'The code has already been taken.',

    //parts
    'part_name.required' => 'The part name field is required.',
    'part_store_location_id.required' => 'The part store location field is required.',
    'part_store_location_id.exists' => 'The selected store location does not exist.',
    'part_number.required' => 'The part number field is required.',
    'part_number.string' => 'The part number must be a string.',
    'part_number.max' => 'The part number may not be greater than 255 characters.',
    'part_number.unique' => 'The part number has already been taken.',
    'part_description.string' => 'The part description must be a string.',
    'part_description.max' => 'The part description may not be greater than 500 characters.',
    'image.image' => 'The part image must be an image file.',
    'image.mimes' => 'The part image must be a file of type: jpeg,png,jpg,gif,webp.',
    'image_url.image' => 'The part image URL must be an image file.',
    'image_url.mimes' => 'The part image URL must be a file of type: jpeg,png,jpg,gif,webp.',
    'part_status.required' => 'The part status field is required.',
    'part_status.in' => 'The part status must be either active or inactive.',
    'part_code.required' => 'The part code field is required.',
    'part_code.unique' => 'The part code has already been taken.',

    //mold parts
    'pattern_id.required' => 'The pattern field is required.',
    'pattern_id.exists' => 'The selected pattern does not exist.',
    'parts.required' => 'At least one part is required.',
    'parts.array' => 'The parts must be an array.',
    'parts.min' => 'At least one part is required.',
    'parts.*.part_id.required' => 'The part ID field is required for each part.',
    'parts.*.part_id.exists' => 'The selected part does not exist.',
    'parts.*.required_quantity.required' => 'The required quantity field is required for each part.',
    'parts.*.required_quantity.integer' => 'The required quantity must be an integer.',
    'parts.*.required_quantity.min' => 'The required quantity must be at least 0.',
    'parts.*.required_quantity.max' => 'The required quantity may not be greater than 1000000.',
    'parts.*.part_id.unique' => 'Each part must be unique in the list.',
    'parts.*.part_id.exists' => 'The selected part does not exist.',
    'parts.*.required_quantity.integer' => 'The required quantity must be an integer.',
    'parts.*.required_quantity.min' => 'The required quantity must be at least 0.',
    'parts.*.required_quantity.max' => 'The required quantity may not be greater than 1000000.',  
    'pattern_id.exists' => 'The selected pattern does not exist.',
    'required_quantity.required' => 'The required quantity field is required.',
    'required_quantity.integer' => 'The required quantity must be an integer.',
    'required_quantity.min' => 'The required quantity must be at least 0.',
    'status.required' => 'The status field is required.',
    'status.in' => 'The status must be either active or inactive.',

    //variants
    'part_id.required' => 'The part ID field is required.',
    'part_id.exists' => 'The selected part does not exist.',
    'attribute_id.required' => 'The attribute ID field is required.',
    'attribute_id.exists' => 'The selected attribute does not exist.',
    'image_url.image' => 'The image URL must be an image file.',
    'stock.required' => 'The stock field is required.',
    'stock.integer' => 'The stock must be an integer.',
    'stock.min' => 'The stock must be at least 0.',
    'threshold_status.required' => 'The threshold status field is required.',
    'threshold_status.integer' => 'The threshold status must be an integer.',
    'threshold_status.in' => 'The threshold status must be either 0 or 1',
    'status.required' => 'The status field is required.',
    'status.in' => 'The status must be either active or inactive.',


];