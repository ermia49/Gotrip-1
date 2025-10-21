<?php
/**
 * SEO Configuration for GoTrip Today
 * 
 * Primary Focus: Private transfers, chauffeur services, and day trips with premium vehicles
 * Secondary Focus: Marketplace-style listings comparing providers, routes, and vehicles
 * 
 * Core Keywords: private transfers, airport transfers, chauffeur service, private day trips,
 * car with driver, premium taxi, executive transfer, luxury travel marketplace,
 * book ride online, licensed chauffeurs
 */

// Prevent direct access
if (!defined('ABSPATH')) exit;

/**
 * Global SEO Settings
 */
class GoTrip_SEO_Config {
    
    /**
     * Core keyword family for the website
     */
    public static $core_keywords = [
        'Frankfurt airport transfer',
        'private transfers Germany',
        'chauffeur service Frankfurt',
        'day trips from Frankfurt',
        'car with driver Germany',
        'FRA airport taxi',
        'executive transfer Frankfurt',
        'Germany travel marketplace',
        'book transfer Frankfurt',
        'licensed chauffeurs Germany'
    ];
    
    /**
     * Secondary keywords
     */
    public static $secondary_keywords = [
        'luxury cars Frankfurt',
        'executive vans Germany',
        'Rhine Valley tour',
        'Heidelberg day trip',
        'professional drivers Frankfurt',
        'airport chauffeur FRA',
        'Frankfurt city tours',
        'Black Forest excursion',
        'Rothenburg tour',
        'verified drivers Germany'
    ];
    
    /**
     * Get SEO meta data for specific page types
     */
    public static function get_page_seo($page_type) {
        $site_name = get_bloginfo('name');
        
        $seo_data = [
            'home' => [
                'title' => 'GoTrip Today | Premium Transfers & Day Trips',
                'description' => 'Book luxury daily transfers, airport rides, and private day trips with professional chauffeurs in Frankfurt and Germany. Compare trusted providers and get instant confirmation.',
                'keywords' => implode(', ', array_merge(self::$core_keywords, self::$secondary_keywords)),
                'og_type' => 'website',
                'schema_type' => 'Organization'
            ],
            
            'marketplace' => [
                'title' => 'Marketplace | Compare Frankfurt Transfers & Germany Day Trips',
                'description' => 'Discover and book premium transfers and day trips across Frankfurt and Germany. Choose from licensed chauffeurs, executive cars, and curated experiences from trusted providers.',
                'keywords' => 'transfer marketplace, day trip marketplace, book transfers Frankfurt, chauffeur marketplace Germany, private driver Frankfurt, Frankfurt airport transfer, Germany day trips, licensed chauffeurs Germany, executive cars Frankfurt, compare transfer prices',
                'og_type' => 'website',
                'schema_type' => 'Service'
            ],
            
            'transfers' => [
                'title' => 'Private Transfers Frankfurt | Airport & City-to-City Rides',
                'description' => 'Enjoy stress-free Frankfurt airport and intercity transfers with professional chauffeurs. Luxury sedans, SUVs, and vans available for every journey across Germany.',
                'keywords' => 'Frankfurt airport transfer, city-to-city transfer Germany, private car service Frankfurt, executive sedan Frankfurt, professional chauffeur Germany, FRA airport taxi, intercity transfer, luxury car Frankfurt',
                'og_type' => 'service',
                'schema_type' => 'Service',
                'h1' => 'Private Transfers Frankfurt – Reliable, Comfortable, On Time'
            ],
            
            'day-trips' => [
                'title' => 'Private Day Trips from Frankfurt | Explore Germany with Local Drivers',
                'description' => 'Experience curated day trips from Frankfurt with professional chauffeurs. Explore Rhine Valley, Heidelberg, Rothenburg, and top German destinations at your own pace in premium comfort.',
                'keywords' => 'private day trips Frankfurt, guided tours Germany, local chauffeur Frankfurt, scenic routes Germany, day tours from Frankfurt, Rhine Valley tour, Heidelberg day trip, Rothenburg tour, Black Forest excursion',
                'og_type' => 'service',
                'schema_type' => 'Service',
                'h1' => 'Discover Germany with Private Day Trips from Frankfurt'
            ],
            
            'hourly' => [
                'title' => 'Hourly Chauffeur Service Frankfurt | Rent Car with Driver',
                'description' => 'Flexible hourly bookings with professional drivers in Frankfurt. Ideal for business meetings, shopping tours, or special events across Germany.',
                'keywords' => 'hourly car hire Frankfurt, rent car with driver Germany, private chauffeur hourly Frankfurt, business travel chauffeur, Frankfurt chauffeur by hour, executive driver hourly',
                'og_type' => 'service',
                'schema_type' => 'Service',
                'h1' => 'Rent a Car with Driver – Hourly Chauffeur Service Frankfurt'
            ],
            
            'about' => [
                'title' => 'About GoTrip Today | Frankfurt Chauffeur Marketplace',
                'description' => 'GoTrip Today connects travelers with trusted chauffeurs and operators in Frankfurt and Germany. We focus on reliability, luxury, and transparency.',
                'keywords' => 'about gotrip today, chauffeur marketplace Frankfurt, trusted drivers Germany, luxury transfers Frankfurt, reliable chauffeur service',
                'og_type' => 'website',
                'schema_type' => 'AboutPage'
            ],
            
            'contact' => [
                'title' => 'Contact GoTrip Today | Frankfurt Customer Support & Partners',
                'description' => 'Get in touch for bookings, partnerships, or customer support in Frankfurt. Available 24/7 via email or WhatsApp for all Germany transfers.',
                'keywords' => 'contact chauffeur service Frankfurt, travel booking support, gotrip contact, Frankfurt transfer support, Germany chauffeur inquiries',
                'og_type' => 'website',
                'schema_type' => 'ContactPage'
            ],
            
            'blog' => [
                'title' => 'Frankfurt Travel Guides & Germany Day Trip Tips | GoTrip Today',
                'description' => 'Discover travel tips, route ideas, and top destinations for day trips from Frankfurt across Germany. Expert guides for Rhine Valley, Heidelberg, and more.',
                'keywords' => 'Frankfurt travel blog, Germany chauffeur tips, destination guides Germany, day trip ideas Frankfurt, Rhine Valley guide, Heidelberg travel tips',
                'og_type' => 'website',
                'schema_type' => 'Blog'
            ]
        ];
        
        return isset($seo_data[$page_type]) ? $seo_data[$page_type] : $seo_data['home'];
    }
    
    /**
     * Generate Organization Schema
     */
    public static function get_organization_schema() {
        $site_name = get_bloginfo('name');
        $site_url = home_url('/');
        $logo_url = get_template_directory_uri() . '/assets/img/logo.png';
        
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $site_name,
            'description' => 'Premium private transfers and chauffeur services marketplace connecting customers with licensed drivers and luxury vehicles in Frankfurt and Germany',
            'url' => $site_url,
            'logo' => $logo_url,
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Frankfurt',
                'addressRegion' => 'Hesse',
                'addressCountry' => 'DE'
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => '50.110924',
                'longitude' => '8.682127'
            ],
            'areaServed' => [
                '@type' => 'Country',
                'name' => 'Germany'
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => get_option('gotrip_phone', '+49-69-XXXXXXX'),
                'contactType' => 'Customer Service',
                'availableLanguage' => ['English', 'German'],
                'areaServed' => 'DE'
            ],
            'sameAs' => [
                get_option('gotrip_facebook', ''),
                get_option('gotrip_instagram', ''),
                get_option('gotrip_twitter', '')
            ]
        ];
    }
    
    /**
     * Generate Service Schema
     */
    public static function get_service_schema($service_type = 'Frankfurt Private Transfer Service') {
        $site_name = get_bloginfo('name');
        
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'serviceType' => $service_type,
            'provider' => [
                '@type' => 'Organization',
                'name' => $site_name,
                'description' => 'Luxury travel marketplace with licensed chauffeurs in Frankfurt and Germany'
            ],
            'areaServed' => [
                [
                    '@type' => 'City',
                    'name' => 'Frankfurt',
                    'containedIn' => [
                        '@type' => 'Country',
                        'name' => 'Germany'
                    ]
                ],
                [
                    '@type' => 'Country',
                    'name' => 'Germany'
                ]
            ],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Frankfurt & Germany Transfer Services',
                'itemListElement' => [
                    [
                        '@type' => 'Offer',
                        'itemOffered' => [
                            '@type' => 'Service',
                            'name' => 'Frankfurt Airport Transfer (FRA)',
                            'description' => 'Professional airport chauffeur service from Frankfurt Airport with licensed drivers'
                        ]
                    ],
                    [
                        '@type' => 'Offer',
                        'itemOffered' => [
                            '@type' => 'Service',
                            'name' => 'Private Day Trips from Frankfurt',
                            'description' => 'Custom day trip chauffeur services to Rhine Valley, Heidelberg, Rothenburg with luxury vehicles'
                        ]
                    ],
                    [
                        '@type' => 'Offer',
                        'itemOffered' => [
                            '@type' => 'Service',
                            'name' => 'Executive Transfer Frankfurt',
                            'description' => 'Premium executive transfers in Frankfurt with professional chauffeurs'
                        ]
                    ]
                ]
            ]
        ];
    }
    
    /**
     * Generate Breadcrumb Schema
     */
    public static function get_breadcrumb_schema($breadcrumbs) {
        $items = [];
        $position = 1;
        
        foreach ($breadcrumbs as $name => $url) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $name,
                'item' => $url
            ];
        }
        
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items
        ];
    }
    
    /**
     * Output SEO meta tags
     */
    public static function output_meta_tags($page_type = 'home') {
        $seo = self::get_page_seo($page_type);
        $current_url = home_url($_SERVER['REQUEST_URI']);
        $site_name = get_bloginfo('name');
        
        ?>
        <!-- SEO Meta Tags -->
        <meta name="description" content="<?php echo esc_attr($seo['description']); ?>">
        <meta name="keywords" content="<?php echo esc_attr($seo['keywords']); ?>">
        <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
        <link rel="canonical" href="<?php echo esc_url($current_url); ?>">
        
        <!-- Open Graph Meta Tags -->
        <meta property="og:locale" content="en_US">
        <meta property="og:type" content="<?php echo esc_attr($seo['og_type']); ?>">
        <meta property="og:title" content="<?php echo esc_attr($seo['title']); ?>">
        <meta property="og:description" content="<?php echo esc_attr($seo['description']); ?>">
        <meta property="og:url" content="<?php echo esc_url($current_url); ?>">
        <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>">
        
        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?php echo esc_attr($seo['title']); ?>">
        <meta name="twitter:description" content="<?php echo esc_attr($seo['description']); ?>">
        <?php
    }
    
    /**
     * Output Schema markup
     */
    public static function output_schema($schemas = []) {
        foreach ($schemas as $schema) {
            ?>
            <script type="application/ld+json">
            <?php echo json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
            </script>
            <?php
        }
    }
}

/**
 * Add SEO to homepage
 */
add_action('wp_head', function() {
    if (is_front_page()) {
        GoTrip_SEO_Config::output_meta_tags('home');
        
        $schemas = [
            GoTrip_SEO_Config::get_organization_schema(),
            GoTrip_SEO_Config::get_service_schema('Private Transfer & Chauffeur Service Marketplace')
        ];
        
        GoTrip_SEO_Config::output_schema($schemas);
    }
}, 1);
