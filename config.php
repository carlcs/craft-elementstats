<?php
namespace Craft;

return [
    'defaultDateColumns' => [
        // Default Element Types
        'Asset'       => 'assetfiles.dateCreated',
        'Category'    => 'categories.dateCreated',
        'Entry'       => 'entries.dateCreated',
        'GlobalSet'   => 'globalsets.dateCreated',
        'MatrixBlock' => 'matrixblocks.dateCreated',
        'Tag'         => 'tags.dateCreated',
        'User'        => 'users.dateCreated',

        // Plugin Element Types
        'AmForms_Form'        => 'forms.dateCreated',
        'AmForms_Submission'  => 'submissions.dateCreated',
        'Social_LoginAccount' => 'login_accounts.dateCreated',
        'SproutForms_Entry'   => 'entries.dateCreated',
        'SproutForms_Form'    => 'forms.dateCreated',
        'SuperTable_Block'    => 'supertableblocks.dateCreated',
    ],

    'defaultNumberFormat' => '{{ total|number }}',

    'stats' => [
        'all-entries' => [
            'name'        => 'All Entries',
            'link'        => 'entries',
            'elementType' => ElementType::Entry,
        ],
        'all-assets' => [
            'name'        => 'All Assets',
            'link'        => 'assets',
            'elementType' => ElementType::Asset,
        ],
    ],
];
