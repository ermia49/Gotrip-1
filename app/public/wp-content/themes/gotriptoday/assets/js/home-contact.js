/**
 * Home Page Contact Form Handler
 * Handles form submission with reCAPTCHA v3 validation
 */
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const formResponse = document.getElementById('formResponse');
    
    // Get reCAPTCHA site key from wp_localize_script
    const RECAPTCHA_SITE_KEY = typeof homeContactVars !== 'undefined' ? homeContactVars.recaptcha_key : '';
    
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
            
            // Check if reCAPTCHA is configured
            if (!RECAPTCHA_SITE_KEY || RECAPTCHA_SITE_KEY === 'YOUR_RECAPTCHA_SITE_KEY_HERE') {
                showMessage('reCAPTCHA is not configured. Please contact the site administrator.', 'error');
                console.error('reCAPTCHA site key not configured. Please add it to wp-config.php');
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
                        
                        fetch(homeContactVars.ajax_url, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showMessage('Thank you! Your message has been sent successfully. We\'ll get back to you soon.', 'success');
                                contactForm.reset();
                            } else {
                                showMessage(data.data.message || 'Something went wrong. Please try again.', 'error');
                            }
                        })
                        .catch(error => {
                            showMessage('Network error. Please check your connection and try again.', 'error');
                            console.error('Form submission error:', error);
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.classList.remove('loading');
                        });
                    })
                    .catch(function(error) {
                        showMessage('Security verification failed. Please refresh and try again.', 'error');
                        console.error('reCAPTCHA error:', error);
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
