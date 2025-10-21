<?php
/**
 * SEO Analytics & Tracking Configuration
 * 
 * This file adds Google Analytics, Google Search Console verification,
 * and other tracking codes for SEO monitoring
 */

// Prevent direct access
if (!defined('ABSPATH')) exit;

/**
 * Add Google Analytics 4 (GA4) tracking code
 * Replace 'G-XXXXXXXXXX' with your actual GA4 Measurement ID
 */
add_action('wp_head', 'add_google_analytics', 1);
function add_google_analytics() {
    // Only add on frontend, not in admin
    if (is_admin()) return;
    
    $ga_id = 'G-XXXXXXXXXX'; // REPLACE WITH YOUR GA4 ID
    
    if (empty($ga_id) || $ga_id === 'G-XXXXXXXXXX') return;
    ?>
    <!-- Google Analytics 4 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($ga_id); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo esc_js($ga_id); ?>', {
            'anonymize_ip': true,
            'cookie_flags': 'SameSite=None;Secure'
        });
        
        // Track form submissions
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form[action*="booking"], form[action*="quote"]');
            forms.forEach(function(form) {
                form.addEventListener('submit', function() {
                    gtag('event', 'form_submit', {
                        'event_category': 'engagement',
                        'event_label': 'booking_form'
                    });
                });
            });
            
            // Track external link clicks
            const externalLinks = document.querySelectorAll('a[href^="http"]:not([href*="' + location.hostname + '"])');
            externalLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    gtag('event', 'click', {
                        'event_category': 'outbound',
                        'event_label': link.href
                    });
                });
            });
        });
    </script>
    <?php
}

/**
 * Add Google Search Console verification meta tag
 * Replace with your actual verification code from Search Console
 */
add_action('wp_head', 'add_google_search_console_verification', 1);
function add_google_search_console_verification() {
    if (!is_front_page() && !is_home()) return;
    
    $verification_code = ''; // ADD YOUR VERIFICATION CODE HERE
    
    if (!empty($verification_code)) {
        echo '<meta name="google-site-verification" content="' . esc_attr($verification_code) . '">' . "\n";
    }
}

/**
 * Track key conversion events
 */
add_action('wp_footer', 'add_conversion_tracking');
function add_conversion_tracking() {
    // Check if on thank you / confirmation page
    if (is_page('thank-you') || is_page('confirmation') || isset($_GET['order_id'])) {
        ?>
        <script>
            gtag('event', 'conversion', {
                'send_to': 'YOUR-CONVERSION-ID',
                'value': 1.0,
                'currency': 'EUR',
                'event_category': 'booking',
                'event_label': 'completed_booking'
            });
        </script>
        <?php
    }
}

/**
 * Add structured data for local business (Frankfurt location)
 */
add_action('wp_footer', 'add_local_business_schema');
function add_local_business_schema() {
    if (!is_front_page() && !is_home()) return;
    ?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "GoTrip Today - Frankfurt",
      "image": "<?php echo get_template_directory_uri(); ?>/assets/images/logo.png",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Frankfurt Airport",
        "addressLocality": "Frankfurt am Main",
        "addressRegion": "Hessen",
        "postalCode": "60549",
        "addressCountry": "DE"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 50.110924,
        "longitude": 8.682127
      },
      "url": "<?php echo esc_url(home_url('/')); ?>",
      "telephone": "+49-69-XXXXXXX",
      "priceRange": "€€€",
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday",
          "Sunday"
        ],
        "opens": "00:00",
        "closes": "23:59"
      }
    }
    </script>
    <?php
}

/**
 * Add FAQ Schema for common questions
 */
add_action('wp_footer', 'add_faq_schema');
function add_faq_schema() {
    if (!is_front_page() && !is_home()) return;
    ?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "How do I book a private transfer from Frankfurt Airport?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "You can book a private transfer from Frankfurt Airport through our online booking system. Simply select your pickup location, destination, date, time, and number of passengers. Compare available chauffeur services and vehicles, then confirm your booking with instant confirmation."
          }
        },
        {
          "@type": "Question",
          "name": "What types of vehicles are available for day trips in Germany?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "We offer luxury sedans (Mercedes E-Class, BMW 5 Series), executive vans (Mercedes V-Class, Vito), and premium buses (Mercedes Sprinter) for day trips across Germany. All vehicles come with professional licensed chauffeurs and are perfect for Rhine Valley tours, Heidelberg trips, and Black Forest excursions."
          }
        },
        {
          "@type": "Question",
          "name": "Are all chauffeurs licensed and insured?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes, all chauffeurs in our marketplace are fully licensed, professionally trained, and insured. We verify all drivers to ensure the highest safety and service standards for your private transfers and day trips."
          }
        },
        {
          "@type": "Question",
          "name": "How much does an airport transfer from Frankfurt cost?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Frankfurt airport transfer prices vary based on your destination, vehicle type, and time of service. Use our comparison tool to view prices from multiple providers and choose the best option for your needs. We offer transparent pricing with no hidden fees."
          }
        },
        {
          "@type": "Question",
          "name": "Can I book a day trip from Frankfurt to Heidelberg?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes, Heidelberg day trips from Frankfurt are one of our most popular services. Choose from executive sedans or premium vans with professional chauffeurs. The journey takes approximately 1 hour each way, and you can customize your itinerary including castle visits and old town tours."
          }
        }
      ]
    }
    </script>
    <?php
}

/**
 * Track scroll depth for engagement metrics
 */
add_action('wp_footer', 'add_scroll_tracking');
function add_scroll_tracking() {
    if (is_admin()) return;
    ?>
    <script>
    (function() {
        let scrollDepth = 0;
        const milestones = [25, 50, 75, 100];
        const tracked = {};
        
        function trackScrollDepth() {
            const scrollPercent = Math.round((window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100);
            
            milestones.forEach(function(milestone) {
                if (scrollPercent >= milestone && !tracked[milestone]) {
                    tracked[milestone] = true;
                    if (typeof gtag === 'function') {
                        gtag('event', 'scroll_depth', {
                            'event_category': 'engagement',
                            'event_label': milestone + '%',
                            'value': milestone
                        });
                    }
                }
            });
        }
        
        let scrollTimeout;
        window.addEventListener('scroll', function() {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(trackScrollDepth, 150);
        });
    })();
    </script>
    <?php
}

/**
 * Add performance monitoring
 */
add_action('wp_footer', 'add_performance_tracking', 999);
function add_performance_tracking() {
    if (is_admin()) return;
    ?>
    <script>
    window.addEventListener('load', function() {
        if ('performance' in window && 'timing' in window.performance) {
            setTimeout(function() {
                const perfData = window.performance.timing;
                const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
                const connectTime = perfData.responseEnd - perfData.requestStart;
                const renderTime = perfData.domComplete - perfData.domLoading;
                
                if (typeof gtag === 'function') {
                    gtag('event', 'timing_complete', {
                        'name': 'load',
                        'value': pageLoadTime,
                        'event_category': 'performance'
                    });
                    
                    // Track if page load is too slow (>3 seconds)
                    if (pageLoadTime > 3000) {
                        gtag('event', 'slow_page_load', {
                            'event_category': 'performance',
                            'event_label': window.location.pathname,
                            'value': pageLoadTime
                        });
                    }
                }
            }, 0);
        }
    });
    </script>
    <?php
}
