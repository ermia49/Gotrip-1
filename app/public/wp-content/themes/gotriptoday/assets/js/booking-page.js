(function () {
    "use strict";

    var RELOAD_FLAG = "gotripBookingWidgetReloaded";

    function handleWidgetStepReset() {
        var params = new URLSearchParams(window.location.search);
        if (params.get("widget_second_step") !== "1") {
            sessionStorage.removeItem(RELOAD_FLAG);
            return;
        }

        var hasReloaded = sessionStorage.getItem(RELOAD_FLAG);
        if (!hasReloaded) {
            sessionStorage.setItem(RELOAD_FLAG, "1");
            window.location.reload();
            return;
        }

        sessionStorage.removeItem(RELOAD_FLAG);
    }

    function enhanceTabs() {
        var tabLinks = document.querySelectorAll(".booking-tabs .tab-link");
        tabLinks.forEach(function (tab) {
            tab.addEventListener("focus", function () {
                tab.classList.add("is-focused");
            });
            tab.addEventListener("blur", function () {
                tab.classList.remove("is-focused");
            });
        });
    }

    function manageFormFocus() {
        var bookingForm = document.getElementById("booking-form");
        if (!bookingForm) {
            return;
        }

        var hash = window.location.hash;
        if (hash === "#booking-form") {
            bookingForm.focus({ preventScroll: false });
        }

        bookingForm.addEventListener("focus", function () {
            bookingForm.classList.add("is-focused");
        });

        bookingForm.addEventListener("blur", function () {
            bookingForm.classList.remove("is-focused");
        });
    }

    function injectTrustBadges() {
        // Only inject once
        if (document.querySelector('.chbs-trust-badges')) {
            return;
        }

        // Find the ride info or route info containers
        var targetElements = [
            '.chbs-booking-form-id-10007 .chbs-ride-info',
            '.chbs-booking-form-id-10007 .chbs-route-info',
            '.chbs-booking-form-id-10007 .chbs-route-summary'
        ];

        var insertAfter = null;
        for (var i = 0; i < targetElements.length; i++) {
            var element = document.querySelector(targetElements[i]);
            if (element) {
                insertAfter = element;
                break;
            }
        }

        if (!insertAfter) {
            // Fallback: insert after any section within the form
            insertAfter = document.querySelector('.chbs-booking-form-id-10007 .chbs-section');
        }

        if (insertAfter) {
            var trustBadgesHTML = `
                <div class="chbs-trust-badges">
                    <div class="chbs-trust-badge">
                        <div class="chbs-trust-badge-icon">✓</div>
                        <div class="chbs-trust-badge-content">
                            <div class="chbs-trust-badge-title">100% Cancellation Free</div>
                            <div class="chbs-trust-badge-subtitle">Up to 24 hours before pickup</div>
                        </div>
                    </div>
                    <div class="chbs-trust-badge">
                        <div class="chbs-trust-badge-icon">★</div>
                        <div class="chbs-trust-badge-content">
                            <div class="chbs-trust-badge-title">Satisfaction Guarantee</div>
                            <div class="chbs-trust-badge-subtitle">Premium service quality assured</div>
                        </div>
                    </div>
                    <div class="chbs-trust-badge">
                        <div class="chbs-trust-badge-icon">🚗</div>
                        <div class="chbs-trust-badge-content">
                            <div class="chbs-trust-badge-title">Door to Door Service</div>
                            <div class="chbs-trust-badge-subtitle">Convenient pickup & drop-off</div>
                        </div>
                    </div>
                    <div class="chbs-trust-badge">
                        <div class="chbs-trust-badge-icon">👋</div>
                        <div class="chbs-trust-badge-content">
                            <div class="chbs-trust-badge-title">Meet and Greet</div>
                            <div class="chbs-trust-badge-subtitle">Personalized welcome service</div>
                        </div>
                    </div>
                </div>
            `;

            // Insert the trust badges after the target element
            insertAfter.insertAdjacentHTML('afterend', trustBadgesHTML);
        }
    }

    function observeFormChanges() {
        // Watch for CHBS form updates and re-inject badges if needed
        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    // Small delay to ensure CHBS has finished updating
                    setTimeout(injectTrustBadges, 500);
                }
            });
        });

        var chbsForm = document.querySelector('.chbs-booking-form-id-10007');
        if (chbsForm) {
            observer.observe(chbsForm, {
                childList: true,
                subtree: true
            });
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        handleWidgetStepReset();
        enhanceTabs();
        manageFormFocus();
        
        // Inject trust badges initially
        injectTrustBadges();
        
        // Setup observer for dynamic content
        observeFormChanges();
        
        // Also try to inject badges after a short delay in case CHBS loads content dynamically
        setTimeout(injectTrustBadges, 1000);
        setTimeout(injectTrustBadges, 3000);
    });
})();

