<?php
namespace Craft;

// Prep gallery images stats
$criteria = craft()->elements->getCriteria('Entry');
$criteria->id = 20;
$galleryEntry = $criteria->first();

// Prep news ratio stats
$criteria = craft()->elements->getCriteria('Entry');
$criteria->section = 'news';
$newsTotal = $criteria->total();

$criteria = craft()->elements->getCriteria('Entry');
$criteria->section = 'news';
$criteria->type = 'sports';
$sportsNewsTotal = $criteria->total();

$criteria = craft()->elements->getCriteria('Entry');
$criteria->section = 'news';
$criteria->type = 'health';
$healthNewsTotal = $criteria->total();

// Return the stats configurations
return [
    'stats' => [
        // Basic example
        'all-entries' => [
            'name'        => 'All Entries',
            'link'        => 'entries',
            'elementType' => 'Entry',
        ],

        // Custom criteria examples
        'sports-news' => [
            'name'        => 'Sports News',
            'link'        => 'entries/news',
            'elementType' => 'Entry',
            'criteria'    => [
                'section' => 'news',
                'type'    => 'sports',
            ],
        ],
        'gallery-images' => [
            'name'        => 'Gallery Images',
            'link'        => 'assets',
            'elementType' => 'Asset',
            'criteria'    => [
                'relatedTo' => $galleryEntry,
            ],
        ],

        // Custom date column example
        'events' => [
            'name'        => 'Events',
            'link'        => 'entries/events',
            'elementType' => 'Entry',
            'dateColumn'  => 'content.field_startDate',
            'criteria'    => [
                'section' => 'events',
            ],
        ],

        // Custom total and number format examples
        'sports-news-ratio' => [
            'name'         => 'Sports News',
            'total'        => $sportsNewsTotal / $newsTotal * 100,
            'numberFormat' => '{{ total|number_format(1) }}%',
        ],
        'health-news-ratio' => [
            'name'         => 'Health News',
            'total'        => $healthNewsTotal / $newsTotal * 100,
            'numberFormat' => '{{ total|number_format(1) }}%',
        ],

        // Matrix block element type example
        'quotes' => [
            'name'        => 'Quotes',
            'link'        => '#',
            'elementType' => 'MatrixBlock',
            'criteria'    => [
                'fieldId' => 17,
                'type'    => 'blockquote',
            ],
        ],

        // A plugin’s element type example
        'twitter-login-accounts' => [
            'name'        => 'Twitter',
            'link'        => 'social',
            'elementType' => 'Social_LoginAccount',
            'dateColumn'  => 'login_accounts.dateCreated',
            'criteria'    => [
                'providerHandle' => 'twitter',
            ],
        ],
        'google-login-accounts' => [
            'name'        => 'Google',
            'link'        => 'social',
            'elementType' => 'Social_LoginAccount',
            'dateColumn'  => 'login_accounts.dateCreated',
            'criteria'    => [
                'providerHandle' => 'google',
            ],
        ],
        'facebook-login-accounts' => [
            'name'        => 'Facebook',
            'link'        => 'social',
            'elementType' => 'Social_LoginAccount',
            'dateColumn'  => 'login_accounts.dateCreated',
            'criteria'    => [
                'providerHandle' => 'facebook',
            ],
        ],
    ],
];
