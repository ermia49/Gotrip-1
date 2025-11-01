# CHBS Booking Form Refactor Rules

Last updated: 2025-11-01

Use these rules for all tasks involving the Chauffeur Booking System (CHBS) booking form.

1) Preserve core markup contract
- Do not change, remove, or rename elements rendered by `template/public/public.php` and `public-step-*.php`.
- Keep all `chbs_*` field names, hidden inputs, classes such as `chbs-main`, `chbs-form-field`, and IDs intact.

2) Avoid editing plugin core files
- Never modify files inside `wp-content/plugins/chauffeur-booking-system/` directly.
- Use theme/mu-plugin filters, actions, CSS, or JS overrides instead.

3) No DOM replacements
- Do not inject or swap out the CHBS booking form HTML with custom markup.
- Custom UI work must layer on top of the existing structure.

4) Respect asset dependencies
- Do not dequeue bundled CHBS scripts/styles (jQuery UI, intlTelInput, qTip, Google Maps helpers, etc.).
- Ensure Google Maps consent flow (`chbs_google_maps_enable`) remains intact.

5) Configuration-first approach
- Prefer adjusting booking form settings via CHBS admin meta boxes (service types, fields, labels, styles).
- Use available filters (`chbs_email_template_*`, `chbs_booking_summary_before_price`) for content changes.

6) Theme-level enhancements only
- Add CSS in the theme targeting `.chbs-booking-form-id-XXXX` for visual tweaks.
- Add JS enhancements by enqueueing scripts that run after `chbs-booking-form`, without altering core behaviour.

7) Preserve AJAX / validation flows
- Do not rename AJAX actions, tamper with nonces, or remove hidden inputs required for pricing, routing, or payments.

8) Keep generated CSS pipeline intact
- Do not overwrite `CHBSBookingFormStyle::createCSSFile` output; layer additional styles via theme assets if needed.

9) Respect global branding
- Always align colors, typography, spacing, and interactions with the site’s theme and brand guidelines.

---

Implementation notes we follow in this repo

- All style changes are layered as theme CSS/inline CSS using `.chbs-booking-form-id-<ID>`-prefixed selectors with high specificity only when necessary.
- JavaScript runs after CHBS assets (footer) and never rewrites or replaces CHBS markup; only progressive enhancements.
- We do not dequeue or replace CHBS assets. If conflicts occur, we resolve via more specific theme selectors or small JS hooks.
- If a change requires CHBS config, we do it in the plugin admin first. Theme code is a last-mile override.

