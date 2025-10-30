# WordPress Admin Notices - Quick Fixes

These notices are from **other plugins** (not GoTrip Booking Manager). Here's how to fix each:

---

## 1. ⚠️ **Stripe SSL Certificate Warning**

**Issue:** Stripe requires SSL for secure checkout.

**Fix for Local Development:**
Since you're on `localhost:10003`, this is expected. For local development:

### **Option A: Ignore (Recommended for Local)**
This warning is safe to ignore on localhost. SSL is only required for production.

### **Option B: Add Local SSL**
If you want to test with SSL locally:
```bash
# For Local by Flywheel
1. Right-click site in Local app
2. Click "Trust"
3. Site will be accessible via https://
```

### **For Production:**
```bash
# Get free SSL certificate
1. Use Let's Encrypt (free)
2. Or use Cloudflare (free)
3. Or contact your hosting provider
```

---

## 2. ⚠️ **Chauffeur Booking System License**

**Issue:** CHBS plugin needs license verification.

**Fix:**
```
1. Go to: WordPress Admin → CHBS → Plugin Options
2. Enter your license key (if you have one)
3. Click "Save Changes"
```

**If you don't have a license:**
- The plugin will still work with basic features
- Some premium features may be disabled
- You can purchase a license from the CHBS website

**For Development/Testing:**
- You can dismiss this notice
- Core CHBS functionality works without license
- Our GoTrip Booking Manager integration will still work

---

## 3. ⚠️ **UpdraftPlus Vault Configuration**

**Issue:** UpdraftPlus backup plugin needs UpdraftVault configuration.

**Fix Option 1: Configure UpdraftVault**
```
1. Go to: Settings → UpdraftPlus Backups
2. Click "Settings" tab
3. Under "Remote Storage", configure UpdraftVault
4. Enter your UpdraftVault credentials
5. Click "Save Changes"
```

**Fix Option 2: Use Different Backup Storage (Recommended)**
```
1. Go to: Settings → UpdraftPlus Backups
2. Click "Settings" tab
3. Under "Remote Storage", choose a different option:
   - Dropbox
   - Google Drive
   - Amazon S3
   - Or "None" for local backups only
4. Click "Save Changes"
```

**Fix Option 3: Disable Remote Backups**
```
1. Go to: Settings → UpdraftPlus Backups
2. Click "Settings" tab
3. Under "Remote Storage", select "None"
4. Click "Save Changes"
```

---

## 🎯 **Quick Action Plan**

### **For Local Development (Recommended):**
1. ✅ **Stripe SSL**: Ignore (or click "Dismiss")
2. ✅ **CHBS License**: Click "Dismiss" (plugin works without license)
3. ✅ **UpdraftPlus**: Set to "None" or configure backup storage

### **To Dismiss All Notices:**
```php
// Add to wp-config.php (temporary, for development only)
define('WP_DISABLE_ADMIN_NOTICES', true);
```

**⚠️ Warning:** This will hide ALL admin notices, including important ones.

---

## 🔍 **Check GoTrip Booking Manager Status**

To verify our plugin is working correctly:

```
1. Go to: GoTrip Manager → 🏥 Health Check
2. Review all component statuses
3. Fix any errors or warnings shown
```

---

## 📝 **Summary**

| Notice | Severity | Action for Local Dev |
|--------|----------|---------------------|
| Stripe SSL | Low | Dismiss (SSL not needed on localhost) |
| CHBS License | Low | Dismiss (basic features work) |
| UpdraftPlus | Low | Set backup to "None" or configure |

**None of these affect GoTrip Booking Manager functionality!** ✅

---

## 🚀 **Next Steps**

1. Dismiss or fix the notices above
2. Go to **GoTrip Manager → Dashboard**
3. Run **Health Check** to verify our system
4. Start creating bookings and drivers!

---

## 💡 **Pro Tip**

To hide specific plugin notices permanently, you can use a plugin like:
- **Disable Admin Notices** (free plugin)
- **Admin Notices Manager** (free plugin)

Or add this to your theme's `functions.php`:
```php
// Hide specific admin notices
add_action('admin_head', function() {
    // Hide Stripe SSL notice on localhost
    if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
        echo '<style>.stripe-ssl-notice { display: none !important; }</style>';
    }
});
```

---

**Your GoTrip Booking Manager is fully functional regardless of these notices!** 🎉


