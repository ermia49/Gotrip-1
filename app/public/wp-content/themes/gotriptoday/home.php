<?php
/*Template Name: Home*/

get_header(); ?>


<section class="hero-section bg-dark">    
    <?php gotriptoday_social_icons(); ?>
    <div class="swiper background-swiper">
        <div class="swiper-wrapper h-100">
            <div class="swiper-slide h-100"
                style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/bg-img/slide1.webp')">
            </div>
            <div class="swiper-slide h-100"
                style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/bg-img/1.jpg')">
            </div>
        </div>
    </div>
    <!-- Background Slider Navigation -->
    <div class="background-slider-nav d-none d-sm-flex">
        <div class="background-button-prev">
            <i class="icon-arrow-left"></i>
        </div>
        <div class="background-button-next">
            <i class="icon-arrow-right"></i>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12">
                <ul class="nav forms-tabs mb-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="tab-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1"
                            type="button" role="tab" aria-controls="tab1" aria-selected="true">Transfer</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="tab-link" href="<?php echo home_url('/day-trip'); ?>" type="button">Day Trip</a>
                    </li>
                </ul>
                <div class="tab-content pt-3" id="">
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                        <div class="go_trip_form">
                            <?php get_template_part('partials/content', 'tab1'); ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- About Company -->
<section class="about-company-section">
    <!-- Divider -->
    <div class="divider"></div>

    <div class="container">
        <div class="row g-5 align-items-center">
            <!-- About Thumbnail -->
            <div class="col-12 col-lg-6">
                <div class="about-thumbnail">
                    <!-- Shape -->
                    <div class="shape wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1000ms">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/core-img/shape.png" alt="Shape">
                    </div>

                    <!-- First Image -->
                    <div class="first-img wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1000ms">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bg-img/7.jpg" alt="First Image">
                    </div>

                    <!-- Second Image -->
                    <div class="second-img wow fadeInUp" data-wow-delay="600ms" data-wow-duration="1000ms">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bg-img/8.jpg" alt="<?php bloginfo('name'); ?>">

                        <!-- Play Video -->
                        <div class="play-video-btn video-btn" data-video="https://youtu.be/zCSmY_WjvPs">
                            <div class="icon">
                                <i class="ti ti-player-play-filled"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Third Image -->
                    <div class="third-img wow fadeInUp" data-wow-delay="800ms" data-wow-duration="1000ms">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bg-img/9.jpg" alt="Image 9">
                    </div>
                </div>
            </div>

            <!-- About Content -->
            <div class="col-12 col-lg-6">
                <div class="about-content ps-md-5">
                    <div class="section-heading">

                        <h2 class="mb-4">How It Works</h2>
                    </div>

                    <div class="d-flex flex-column gap-4 mb-5">
                        <!-- Single Item -->
                        <div class="about-card-sm d-flex align-items-center gap-3">
                            <div class="icon">
                                <i class="ti ti-building-pavilion"></i>
                            </div>
                            <div>
                                <h4>Choose Trip Type</h4>
                                <p class="mb-0">Select from Airport Transfer, City-to-City Ride, Day Trip, or Hourly
                                    Service</p>
                            </div>
                        </div>

                        <!-- Single Item -->
                        <div class="about-card-sm d-flex align-items-center gap-3">
                            <div class="icon">
                                <i class="ti ti-list-check"></i>
                            </div>
                            <div>
                                <h4>Enter Your Details</h4>
                                <p class="mb-0">Add pickup & drop-off locations, date, time, and any extra preferences
                                </p>
                            </div>
                        </div>
                        <!-- Single Item -->
                        <div class="about-card-sm d-flex align-items-center gap-3">
                            <div class="icon">
                                <i class="ti ti-ruler-measure"></i>
                            </div>
                            <div>
                                <h4>Get Instant Price & Confirm</h4>
                                <p class="mb-0">See your price instantly. Review the service and confirm your booking
                                    with a few clicks</p>
                            </div>
                        </div>
                        <div class="about-card-sm d-flex align-items-center gap-3">
                            <div class="icon">
                                <i class="ti ti-car"></i>
                            </div>
                            <div>
                                <h4>Ride in Comfort</h4>
                                <p class="mb-0"> Your professional driver arrives on time. Enjoy Wi-Fi, bottled water,
                                    and a smooth journey</p>
                            </div>
                        </div>
                    </div>
                    <a href="<?php bloginfo('url'); ?>/day-trips" class="btn btn-success">Book Now <i
                            class="icon-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="divider"></div>
</section>


<!-- Tours Section -->
<section class="deals-section">
    <div class="container">
        <div class="divider"></div>
        <div class="d-flex flex-wrap justify-content-between gap-5 align-items-center">
            <div class="section-heading">
                <span class="sub-title text-success">Day Trips Options</span>
                <h2 class="mb-0 text-white">Book Your Next Day Trips</h2>
            </div>
            <div class="deals-navigation-container">
                <div class="deals-button-prev">
                    <i class="icon-arrow-left"></i>
                </div>
                <div class="deals-button-next">
                    <i class="icon-arrow-right"></i>
                </div>
            </div>
        </div>

        <div class="divider-sm"></div>
        <!-- Tour Slider -->
        <div class="swiper deals-swiper">
            <div class="swiper-wrapper">

                <?php
                    $args = array(
                        'post_type' => 'tours',
                        'posts_per_page' => 10, // Change this number as needed
                        'post_status' => 'publish',
                    );

                    $tours_query = new WP_Query($args);

                    if ($tours_query->have_posts()):
                        while ($tours_query->have_posts()):
                            $tours_query->the_post();
                            ?>

                <?php get_template_part('partials/tour', 'slide'); ?>

                <?php
                        endwhile;
                        wp_reset_postdata();
                    else:
                        echo '<p>No tours found.</p>';
                    endif;
                    ?>



            </div>
        </div>
        <div class="divider"></div>
    </div>
</section>

<!-- Featured Destination -->
<section class="featured-destination bg-secondary">
    <!-- Divider -->
    <div class="divider"></div>

    <div class="container">
        <div class="row g-4 g-lg-5 align-items-end">
            <div class="col-12 col-sm-6">
                <div class="section-heading">
                    <span class="sub-title text-success">Fits Your Journey
                    </span>
                    <h2 class="mb-0">Premium Travel Solutions</h2>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 offset-lg-2">
                <div class="section-heading">
                    <p class="mb-0">We specialize in private day trips, city-to-city transfers, airport pickups, and
                        personalized chauffeur services across</p>
                </div>
            </div>
        </div>

        <div class="divider-sm"></div>

        <div class="row g-4 featured-destination-cards">
            <!-- Featured Destination Card -->
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="featured-destination-card wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1000ms">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/aireport.jpg" alt="">

                    <!-- Overlay Content -->
                    <div class="overlay-content d-flex flex-wrap gap-4 align-items-end justify-content-between">
                        <div>
                            <h4 class="text-white">Airport Transfer</h4>
                            <p class="mt-1 text-white">Punctual, reliable, and stress-free – enjoy a smooth and
                                comfortable ride to the airport</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="featured-destination-card wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1000ms">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/city.jpg" alt="City Tour">
                    <div class="overlay-content d-flex flex-wrap gap-4 align-items-end justify-content-between">
                        <div>
                            <h4 class="text-white">City Tour</h4>
                            <p class="mt-1 text-white">Explore the city's highlights in ultimate comfort and style</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="featured-destination-card wow fadeInUp" data-wow-delay="600ms" data-wow-duration="1000ms">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/reserve.jpg" alt="Reserve">
                    <div class="overlay-content d-flex flex-wrap gap-4 align-items-end justify-content-between">
                        <div>
                            <h4 class="text-white">Reserve Your Fleet</h4>
                            <p class="mt-1 text-white">Discover Our Premium Fleet Now</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Divider -->
    <div class="divider"></div>
</section>

<!-- Contact Section -->
<section class="contact-section"
    style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/bg-img/34.jpg');">
    <!-- Divider -->
    <div class="divider"></div>

    <div class="container">
        <div class="row g-5">
            <div class="col-12 col-lg-6 order-2 order-lg-0">
                <div class="section-heading">
                    <span class="sub-title text-white">Get in touch</span>
                    <h2 class="mb-4 text-white">Have Questions? We're Listening</h2>
                    <p class="text-white mb-5">At GoTripToday, we turn journeys into unforgettable experiences. Based in
                        Germany and serving international travelers, we craft seamless and personalized travel
                        adventures worldwide.</p>
                </div>

                <form id="contactForm" class="me-lg-5" action="#" method="post">
                    <div class="contact-form">
                        <div class="row g-4">
                            <div class="col-12 col-md-6">
                                <input type="text" id="name" class="form-control" name="name"
                                    placeholder="Full Name *" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="email" id="email" class="form-control" name="email"
                                    placeholder="Email Address *" required>
                            </div>
                            <div class="col-12">
                                <input type="text" id="subject" class="form-control" name="subject"
                                    placeholder="Subject *" required>
                            </div>
                            <div class="col-12">
                                <textarea name="message" id="message" class="form-control" rows="6"
                                    placeholder="Your Message *" required></textarea>
                            </div>
                            
                            <!-- reCAPTCHA Badge Info -->
                            <div class="col-12">
                                <p class="text-white-50 small mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle;">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    This form is protected by Google reCAPTCHA to ensure you're not a robot.
                                </p>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="recaptcha_token" name="recaptcha_token">
                    <div class="submit-btn mt-4">
                        <button type="submit" class="btn btn-light" id="submitBtn">
                            <span class="btn-text">Send Message</span>
                            <span class="btn-loader" style="display: none;">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                Sending...
                            </span>
                            <i class="icon-arrow-right ms-2"></i>
                        </button>
                    </div>
                </form>
                <div id="formResponse"></div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="row g-4 align-items-center">
                    <div class="col-12 col-sm-6">
                        <div class="d-flex gap-5 flex-column">
                            <div class="happy-counts wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1000ms">
                                <h3 class="counter">986<span>+</span></h3>
                                <h5 class="mb-0">Happy Travelers</h5>
                            </div>

                            <div class="happy-counts wow fadeInUp" data-wow-delay="400ms" data-wow-duration="1000ms">
                                <h3 class="counter">400<span>+</span></h3>
                                <h5 class="mb-0">Positive Reviews</h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="happy-counts wow fadeInUp" data-wow-delay="600ms" data-wow-duration="1000ms">
                            <h3 class="counter">260<span>+</span></h3>
                            <h5 class="mb-0">Award Winning</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Divider -->
    <div class="divider"></div>
</section>


<?php get_template_part('partials/home', 'services'); ?>

<!-- Blog Section -->
<section class="blog-section">
    <!-- Divider -->
    <div class="divider"></div>

    <div class="container">
        <div class="row g-5 align-items-end">
            <div class="col-12 col-md-6">
                <div class="section-heading">
                    <span class="sub-title text-success">Blog &amp; News</span>
                    <h2 class="mb-0">Latest News &amp; Articles</h2>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="text-md-end">
                    <a href="<?php bloginfo('url'); ?>/blog" class="btn btn-success">View All Blogs <i
                            class="icon-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="divider-sm"></div>
    <div class="container">
        <div class="row g-4 g-xxl-5">
            <?php
            $args = array(
                'post_type' => 'post', // or 'tours' or any custom post type
                'posts_per_page' => 3,
                'post_status' => 'publish',
            );

            $blog_query = new WP_Query($args);

            if ($blog_query->have_posts()):
                while ($blog_query->have_posts()):
                    $blog_query->the_post();
                    get_template_part('partials/blog-card');
                endwhile;
                wp_reset_postdata();
            else:
                echo '<p>No blog posts found.</p>';
            endif;
            ?>
        </div>
    </div>
    <div class="divider"></div>
</section>

<style>
/* Professional Contact Form Styles - Complete Override */
.contact-section .contact-form {
    padding: 40px !important;
    background-color: rgba(255, 255, 255, 0.95) !important;
    border-radius: 18px !important;
}

.contact-section .contact-form .form-control {
    height: 56px !important;
    border: 2px solid #e0e0e0 !important;
    border-radius: 12px !important;
    padding: 16px 20px !important;
    font-size: 15px !important;
    transition: all 0.3s ease !important;
    background: #fff !important;
    color: #333 !important;
    width: 100% !important;
    display: block !important;
    opacity: 1 !important;
    visibility: visible !important;
}

.contact-section .contact-form .form-control:focus {
    border-color: #3cb371 !important;
    box-shadow: 0 0 0 4px rgba(60, 179, 113, 0.1) !important;
    background: #fff !important;
    outline: none !important;
}

.contact-section .contact-form .form-control::placeholder {
    color: #999 !important;
}

.contact-section .contact-form textarea.form-control {
    height: auto !important;
    min-height: 150px !important;
    resize: vertical !important;
    padding-top: 16px !important;
}

.contact-section .contact-form .form-group {
    position: relative;
    z-index: 1;
    margin-bottom: 0;
}

.contact-section .contact-form .form-group label {
    display: none !important;
}

.contact-section .submit-btn {
    padding: 0 !important;
    background: transparent !important;
    border-radius: 0 !important;
    margin-top: 20px;
}

.contact-section .submit-btn .btn {
    min-width: 200px !important;
    height: 56px !important;
    font-weight: 600 !important;
    font-size: 16px !important;
    border-radius: 12px !important;
    transition: all 0.3s ease !important;
}

.contact-section .submit-btn .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(60, 179, 113, 0.3);
}

.contact-section .submit-btn .btn .btn-loader {
    display: none;
}

.contact-section .submit-btn .btn.loading .btn-text {
    display: none;
}

.contact-section .submit-btn .btn.loading .btn-loader {
    display: inline-block;
}

.contact-section .submit-btn .btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

/* Form Response Messages */
#formResponse {
    margin-top: 20px;
    padding: 16px 20px;
    border-radius: 12px;
    font-weight: 500;
    display: none;
    animation: slideIn 0.3s ease;
}

#formResponse.success {
    background: rgba(60, 179, 113, 0.15);
    border: 2px solid #3cb371;
    color: #3cb371;
    display: block;
}

#formResponse.error {
    background: rgba(220, 53, 69, 0.15);
    border: 2px solid #dc3545;
    color: #dc3545;
    display: block;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Adjustments */
@media (max-width: 767px) {
    .contact-section .contact-form {
        padding: 30px 20px !important;
    }
    
    .contact-section .contact-form .form-control {
        height: 50px !important;
        font-size: 14px !important;
    }
    
    .contact-section .submit-btn .btn {
        width: 100%;
        height: 52px !important;
    }
    
    .contact-section .contact-form textarea.form-control {
        min-height: 120px !important;
    }
}
</style>

<!-- Contact Section -->

<script src="https://www.google.com/recaptcha/api.js?render=6LfYourSiteKeyHere"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const formResponse = document.getElementById('formResponse');
    
    // Replace with your actual reCAPTCHA site key
    const RECAPTCHA_SITE_KEY = '6LfYourSiteKeyHere'; // You need to get this from Google reCAPTCHA
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate form
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const subject = document.getElementById('subject').value.trim();
            const message = document.getElementById('message').value.trim();
            
            if (!name || !email || !subject || !message) {
                showMessage('Please fill in all required fields.', 'error');
                return;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showMessage('Please enter a valid email address.', 'error');
                return;
            }
            
            // Disable button and show loading
            submitBtn.disabled = true;
            submitBtn.classList.add('loading');
            
            // Execute reCAPTCHA
            grecaptcha.ready(function() {
                grecaptcha.execute(RECAPTCHA_SITE_KEY, {action: 'contact_form'})
                    .then(function(token) {
                        // Add token to form
                        document.getElementById('recaptcha_token').value = token;
                        
                        // Submit form via AJAX
                        const formData = new FormData(contactForm);
                        formData.append('action', 'submit_contact_form');
                        
                        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showMessage('Thank you! Your message has been sent successfully. We\'ll get back to you soon.', 'success');
                                contactForm.reset();
                            } else {
                                showMessage(data.message || 'Something went wrong. Please try again.', 'error');
                            }
                        })
                        .catch(error => {
                            showMessage('Network error. Please check your connection and try again.', 'error');
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.classList.remove('loading');
                        });
                    })
                    .catch(function(error) {
                        showMessage('Security verification failed. Please refresh and try again.', 'error');
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('loading');
                    });
            });
        });
    }
    
    function showMessage(message, type) {
        formResponse.textContent = message;
        formResponse.className = type;
        formResponse.style.display = 'block';
        
        // Auto-hide success messages after 5 seconds
        if (type === 'success') {
            setTimeout(() => {
                formResponse.style.display = 'none';
            }, 5000);
        }
    }
});
</script>

<?php get_footer(); ?>
