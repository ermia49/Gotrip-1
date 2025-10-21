# Google reCAPTCHA v3 Setup Instructions

## What was Updated

The contact form on the home page has been upgraded with:

1. **Professional Design**
   - 2-column layout for name and email
   - Clear labels with icons
   - Better spacing and validation
   - Loading states and animations
   - Success/error message display

2. **Google reCAPTCHA v3 Protection**
   - Invisible reCAPTCHA (no checkbox needed)
   - Protects against bots and spam
   - Score-based verification (threshold: 0.5)

## Setup Google reCAPTCHA

### Step 1: Get reCAPTCHA Keys

1. Go to [Google reCAPTCHA Admin Console](https://www.google.com/recaptcha/admin)
2. Click **"+"** to create a new site
3. Fill in the form:
   - **Label**: GoTripToday Contact Form
   - **reCAPTCHA type**: Select **reCAPTCHA v3**
   - **Domains**: Add your domains:
     - `gotriptoday.com`
     - `www.gotriptoday.com`
     - `localhost` (for testing)
   - Accept the reCAPTCHA Terms of Service
4. Click **Submit**

You'll receive two keys:
- **Site Key** (public) - Used in the frontend
- **Secret Key** (private) - Used in the backend

### Step 2: Add Keys to Your Site

#### Frontend (home.php - Line ~492)

Replace `6LfYourSiteKeyHere` with your actual Site Key in TWO places:

```javascript
// Line 485:
<script src="https://www.google.com/recaptcha/api.js?render=YOUR_SITE_KEY_HERE"></script>

// Line 491:
const RECAPTCHA_SITE_KEY = 'YOUR_SITE_KEY_HERE';
```

#### Backend (inc/extra.php - Line ~9)

Replace `6LfYourSecretKeyHere` with your actual Secret Key:

```php
$recaptcha_secret = 'YOUR_SECRET_KEY_HERE'; // Replace with your actual reCAPTCHA secret key
```

### Step 3: Test the Form

1. Open your home page: `http://localhost:10003`
2. Scroll to the contact section
3. Fill in all fields (now with better validation)
4. Click "Send Message"
5. You should see a success message if everything is configured correctly

## Features Added

### Professional Form Design
- ✅ 2-column responsive layout
- ✅ Visible labels with icons
- ✅ Better placeholder text
- ✅ Required field validation
- ✅ Email format validation
- ✅ Loading spinner on submit
- ✅ Success/error messages with animations
- ✅ Professional rounded corners and spacing

### Security Features
- ✅ Google reCAPTCHA v3 (invisible)
- ✅ Score-based bot detection (threshold: 0.5)
- ✅ Server-side verification
- ✅ Sanitized input fields
- ✅ Email validation
- ✅ AJAX form submission (no page reload)

### User Experience
- ✅ Real-time validation
- ✅ Disabled button while sending
- ✅ Clear success/error messages
- ✅ Auto-hide success messages after 5 seconds
- ✅ Form reset after successful submission
- ✅ Accessibility improvements

## Troubleshooting

### Form not submitting?
- Check browser console for JavaScript errors
- Verify both Site Key and Secret Key are correctly added
- Ensure your domain is registered in Google reCAPTCHA admin

### reCAPTCHA not loading?
- Check if the reCAPTCHA script is loading (Network tab in DevTools)
- Verify your Site Key is correct
- Try in incognito mode to rule out browser extensions

### "Security verification failed" error?
- Verify the Secret Key in `inc/extra.php` is correct
- Check if the score threshold (0.5) is appropriate
- Test from a different IP address

### Email not sending?
- Check WordPress email configuration
- Verify SMTP settings if using an SMTP plugin
- Check spam folders
- Test with a simple email first

## Files Modified

1. `/wp-content/themes/gotriptoday/home.php`
   - Updated contact form HTML
   - Added professional CSS styles
   - Added reCAPTCHA JavaScript

2. `/wp-content/themes/gotriptoday/inc/extra.php`
   - Added reCAPTCHA server-side verification
   - Enhanced security checks

## Next Steps

1. Get your reCAPTCHA keys from Google
2. Replace placeholder keys in both files
3. Test the form thoroughly
4. Monitor spam submissions
5. Adjust the score threshold if needed (currently 0.5)

## Support

If you need help:
- [Google reCAPTCHA Documentation](https://developers.google.com/recaptcha/docs/v3)
- Check WordPress error logs
- Test with browser DevTools console open
