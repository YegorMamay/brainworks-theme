<?php
/**
 * Schema.org JSON-LD Markup.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Output JSON-LD schema in wp_head.
 */
function schema_json_ld()
{
    $schema = [];

    // Organization Schema
    $logo_id = get_theme_mod('brainworks_main_logo');
    $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';

    $schema['organization'] = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
        'logo' => $logo_url,
        'sameAs' => [],
    ];

    // Add social links to sameAs
    for ($i = 1; $i <= 10; $i++) {
        $social_url = get_theme_mod('brainworks_social_' . $i);
        if ($social_url) {
            $schema['organization']['sameAs'][] = esc_url($social_url);
        }
    }

    // WebSite Schema
    $schema['website'] = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => home_url('/?s={search_term_string}'),
            'query-input' => 'required name=search_term_string',
        ],
    ];

    // Article Schema (for Single Posts)
    if (is_single()) {
        $schema['article'] = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title(),
            'image' => has_post_thumbnail() ? get_the_post_thumbnail_url(null, 'full') : [],
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => [
                '@type' => 'Person',
                'name' => get_the_author(),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => $logo_url,
                ],
            ],
            'description' => get_the_excerpt(),
        ];
    }

    // Output JSON-LD
    foreach ($schema as $type => $data) {
        echo '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
add_action('wp_head', 'schema_json_ld');
