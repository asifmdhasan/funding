<?php

return [
    'custom_edit' => [
        'name' => [
            'required' => '名前は必須です。',
        ],
        'username' => [
            'required' => 'ユーザー名は必須です。',
            'unique' => 'そのユーザー名は既に使われています。',
        ],
        'email' => [
            'email' => '有効なメールアドレスを入力してください。',
            'unique' => 'そのメールアドレスは既に使われています。',
        ],
        'password' => [
            'required' => 'パスワードは必須です。',
            'min' => 'パスワードは6文字以上で入力してください。',
        ],
        'status' => [
            'required' => 'ステータスは必須です。',
        ],
        'current_password' => [
            'required' => '現在のパスワードは必須です。',
            'invalid' => '現在のパスワードが一致しません。',
        ],
        'password' => [
            'required' => '新しいパスワードは必須です。',
            'min' => '新しいパスワードは6文字以上で入力してください。',
            'confirmed' => '新しいパスワードの確認が一致しません。',
        ],
    ],

    'name.required' => '名前は必須です。',
    'code.required' => 'コードは必須です。',
    'code.unique' => 'そのコードは既に使われています。',

    // Part
    'part_name.required' => '部品名は必須です。',
    
    
    'part_store_location_id.required' => '部品の保管場所は必須です。',
    'part_store_location_id.exists' => '選択した保管場所は存在しません。',
    'part_number.required' => '部品番号は必須です。',
    'part_number.string' => '部品番号は文字列でなければなりません。',
    'part_number.max' => '部品番号は255文字以下でなければなりません。',
    'part_number.unique' => 'その部品番号は既に使われています。',
    'part_description.string' => '部品の説明は文字列でなければなりません。',
    'part_description.max' => '部品の説明は500文字以下でなければなりません。',  
    'image.image' => '部品の画像は画像ファイルでなければなりません。',
    'image.mimes' => '部品の画像はjpeg、png、jpg、gif、webp形式でなければなりません。',
    'image_url.image' => '部品の画像URLは画像ファイルでなければなりません。',
    'image_url.mimes' => '部品の画像URLはjpeg、png、jpg、gif、webp形式でなければなりません。',
    'part_status.required' => '部品のステータスは必須です。',
    'part_status.in' => '部品のステータスは、アクティブ、非アクティブのいずれかでなければなりません。',
    'part_code.required' => '部品コードは必須です。',
    'part_code.unique' => 'その部品コードは既に使われています。',

    // Variant
    'part_id.required' => '部品IDは必須です。',
    'part_id.exists' => '選択された部品は存在しません。',
    'attribute_id.required' => '属性IDは必須です。',
    'attribute_id.exists' => '選択された属性は存在しません。',
    'image_url.image' => '画像URLには画像ファイルを指定してください。',
    'stock.required' => '在庫数は必須です。',
    'stock.integer' => '在庫数は整数でなければなりません。',
    'stock.min' => '在庫数は0以上でなければなりません。',
    'threshold_status.required' => 'しきい値ステータスは必須です。',
    'threshold_status.integer' => 'しきい値ステータスは整数でなければなりません。',
    'threshold_status.in' => 'しきい値ステータスは0または1でなければなりません。',
    'status.required' => 'ステータスは必須です。',
    'status.in' => 'ステータスは「アクティブ」または「非アクティブ」でなければなりません。',


    


];