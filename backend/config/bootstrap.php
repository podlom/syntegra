<?php
Yii::$container->set('dosamigos\tinymce\TinyMce', [
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => [
        'plugins' => [
            'advlist autolink lists link charmap hr preview pagebreak',
            'searchreplace wordcount textcolor visualblocks visualchars code fullscreen nonbreaking',
            'save insertdatetime media table contextmenu template paste image responsivefilemanager filemanager',
        ],
        'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | responsivefilemanager link image media',
        'external_filemanager_path' => '/plugins/responsivefilemanager/filemanager/',
        'filemanager_title' => 'Responsive Filemanager',
        'external_plugins' => [
            //Иконка/кнопка загрузки файла в диалоге вставки изображения.
            'filemanager' => '/plugins/responsivefilemanager/filemanager/plugin.min.js',
            //Иконка/кнопка загрузки файла в панеле иснструментов.
            'responsivefilemanager' => '/plugins/responsivefilemanager/tinymce/plugins/responsivefilemanager/plugin.min.js',
        ],
        'relative_urls' => false,
        //'document_base_url'=>  Yii::getAlias('@frontendBaseUrl'),
    ]
]);