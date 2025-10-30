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

    function removeMarketingBlocks() {
        // Remove all Gutenberg blocks in booking section
        var selectors = [
            ".booking-section .wp-block-group",
            ".booking-section .wp-block-columns",
            ".booking-form-section .wp-block-group",
            ".booking-form-section .wp-block-columns",
            ".booking-section > .container > .wp-block-group",
            ".booking-section > .container > .wp-block-columns",
            'section.booking-section div[class*="wp-block"]:not(.booking-step):not(.booking-benefits):not(.booking-form-wrapper)',
            'section.booking-form-section div[class*="wp-block"]:not(.booking-step):not(.booking-benefits):not(.booking-form-wrapper)'
        ];

        selectors.forEach(function(selector) {
            var elements = document.querySelectorAll(selector);
            elements.forEach(function(el) {
                if (el.parentNode) {
                    el.parentNode.removeChild(el);
                }
            });
        });

        // Also remove any element containing the marketing text
        var allDivs = document.querySelectorAll('.booking-section div, .booking-form-section div');
        allDivs.forEach(function(div) {
            var text = div.textContent || '';
            if (text.includes('Trusted transfers across Germany') || 
                text.includes('Licensed EU Chauffeurs') ||
                text.includes('verified chauffeurs')) {
                if (div.parentNode) {
                    div.parentNode.removeChild(div);
                }
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        handleWidgetStepReset();
        enhanceTabs();
        manageFormFocus();
        removeMarketingBlocks();
    });
})();
