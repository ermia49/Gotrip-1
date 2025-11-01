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

    document.addEventListener("DOMContentLoaded", function () {
        handleWidgetStepReset();
        enhanceTabs();
        manageFormFocus();
    });
})();

