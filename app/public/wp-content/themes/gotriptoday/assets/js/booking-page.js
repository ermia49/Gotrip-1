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

    function moveStepper() {
        // Wait for CHBS form to load
        var attempts = 0;
        var maxAttempts = 50; // 5 seconds max wait

        function tryMoveStepper() {
            attempts++;
            
            var stepper = document.querySelector('.chbs-booking-form-id-10007 .chbs-main-navigation-default');
            var trustStrip = document.querySelector('.booking-trust-strip .container');
            
            if (stepper && trustStrip && attempts < maxAttempts) {
                // Create container for stepper under trust strip
                var stepperContainer = document.createElement('div');
                stepperContainer.className = 'booking-stepper-container';
                stepperContainer.setAttribute('aria-label', 'Booking Progress Steps');
                
                // Clone the stepper (to preserve event listeners)
                var stepperClone = stepper.cloneNode(true);
                stepperContainer.appendChild(stepperClone);
                
                // Add container under trust strip
                trustStrip.appendChild(stepperContainer);
                
                // Hide original stepper (but keep it functional)
                stepper.style.cssText = 'position: absolute !important; left: -9999px !important; visibility: hidden !important;';
                
                console.log('Stepper moved under trust component successfully');
                return true;
            }
            
            if (attempts < maxAttempts) {
                setTimeout(tryMoveStepper, 100);
            } else {
                console.log('Could not move stepper - CHBS form may not have loaded');
            }
            
            return false;
        }
        
        tryMoveStepper();
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

    document.addEventListener("DOMContentLoaded", function () {
        handleWidgetStepReset();
        enhanceTabs();
        manageFormFocus();
        
        // Move stepper after a slight delay to ensure CHBS is loaded
        setTimeout(moveStepper, 500);
    });
})();

