# 🔧 Troubleshoot 403 Error - Step by Step

## ❌ **Error:**
```
wp-admin/admin-ajax.php:1  Failed to load resource: the server responded with a status of 403 (Forbidden)
```

---

## 🎯 **STEP 1: Run Diagnostic Test**

### **Visit:**
```
http://localhost:10003/test-ajax.php
```

This will:
- ✅ Check if admin-ajax.php is accessible
- ✅ Verify plugin is active
- ✅ Check AJAX actions are registered
- ✅ Test user permissions
- ✅ Test actual AJAX call
- ✅ Check .htaccess for blocking rules
- ✅ Check for security plugins
- ✅ Show recent PHP errors

---

## 🔍 **STEP 2: Identify the Failing AJAX Action**

### **Open Browser Console:**
1. Press **F12** (or Cmd+Option+I on Mac)
2. Go to **Network** tab
3. Filter by **XHR** or **Fetch**
4. Reload the page
5. Look for **red/failed** requests to `admin-ajax.php`
6. Click on the failed request
7. Check **Payload** or **Form Data** to see the `action` parameter

### **Common Actions That Might Fail:**
- `heartbeat` - WordPress core (safe to ignore)
- `gtub_staff_get_stats` - Our plugin
- `gtub_staff_load_component` - Our plugin
- Other plugin actions

---

## 🔧 **STEP 3: Quick Fixes**

### **Fix 1: Clear All Caches**
```
http://localhost:10003/clear-cache.php
```

### **Fix 2: Disable Security Plugins**
Go to: `http://localhost:10003/wp-admin/plugins.php`

Temporarily deactivate:
- Wordfence
- iThemes Security
- All In One WP Security
- Sucuri
- Any other security plugins

Then test again.

### **Fix 3: Check .htaccess**
```bash
cat "/Users/ahmadharoonalizadeh/Local Sites/gotrip-1/app/public/.htaccess"
```

Look for rules that might block POST requests to `admin-ajax.php`.

**Common blocking rules:**
```apache
# BAD - This will block AJAX
<Files admin-ajax.php>
  Order Deny,Allow
  Deny from all
</Files>

# BAD - This might block AJAX
RewriteRule ^wp-admin/admin-ajax\.php$ - [F]
```

If you find these, comment them out or remove them.

### **Fix 4: Check Server Error Logs**
```bash
# PHP error log
tail -f "/Users/ahmadharoonalizadeh/Local Sites/gotrip-1/logs/php/error.log"

# Nginx error log
tail -f "/Users/ahmadharoonalizadeh/Local Sites/gotrip-1/logs/nginx/error.log"
```

Look for 403 errors or ModSecurity blocks.

### **Fix 5: Enable WordPress Debug**
Add to `wp-config.php` (before "That's all, stop editing!"):
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', true);
```

Then check:
```bash
tail -f "/Users/ahmadharoonalizadeh/Local Sites/gotrip-1/app/public/wp-content/debug.log"
```

---

## 🎯 **STEP 4: Test Specific AJAX Calls**

### **Test in Browser Console:**

```javascript
// Test 1: WordPress Heartbeat (should work)
jQuery.post(ajaxurl, {
  action: 'heartbeat',
  data: {}
}, function(response) {
  console.log('Heartbeat:', response);
}).fail(function(xhr) {
  console.error('Heartbeat failed:', xhr.status, xhr.statusText);
});

// Test 2: Our Plugin Stats
jQuery.post(ajaxurl, {
  action: 'gtub_staff_get_stats',
  nonce: gtubStaff.nonce
}, function(response) {
  console.log('Stats:', response);
}).fail(function(xhr) {
  console.error('Stats failed:', xhr.status, xhr.statusText);
});

// Test 3: Check if nonce exists
console.log('Nonce available:', typeof gtubStaff !== 'undefined' && gtubStaff.nonce);
```

---

## 🔍 **STEP 5: Check ModSecurity (If on Production Server)**

If you're on a production server (not localhost), ModSecurity might be blocking AJAX.

### **Check ModSecurity Logs:**
```bash
grep "admin-ajax" /var/log/modsec_audit.log
```

### **Common ModSecurity Rules That Block AJAX:**
- Rule 950109 (Multiple URL Encoding)
- Rule 950117 (Remote File Inclusion)
- Rule 960024 (Meta-Character Anomaly)

### **Whitelist admin-ajax.php:**
Add to `.htaccess`:
```apache
<IfModule mod_security.c>
  SecRuleRemoveById 950109 950117 960024
</IfModule>
```

---

## 🎯 **STEP 6: Check Local by Flywheel Settings**

Since you're using Local by Flywheel:

### **Check Site Settings:**
1. Open Local app
2. Right-click your site → "Open Site Shell"
3. Run:
```bash
wp option get siteurl
wp option get home
```

Make sure both return: `http://localhost:10003`

### **Restart Site:**
1. In Local app, click "Stop Site"
2. Wait 5 seconds
3. Click "Start Site"

---

## 🔧 **STEP 7: Check Nginx Configuration**

### **View Nginx Config:**
```bash
cat "/Users/ahmadharoonalizadeh/Local Sites/gotrip-1/conf/nginx/site.conf.hbs"
```

### **Look for:**
```nginx
# BAD - This will block AJAX
location ~* /wp-admin/admin-ajax\.php {
    deny all;
}

# BAD - This might block POST
if ($request_method = POST) {
    return 403;
}
```

If you find these, remove them.

---

## 🎯 **MOST COMMON CAUSES & FIXES**

### **1. Security Plugin Blocking (80% of cases)**
**Solution:** Temporarily disable all security plugins

### **2. ModSecurity Rules (10% of cases)**
**Solution:** Whitelist admin-ajax.php in ModSecurity

### **3. .htaccess Rules (5% of cases)**
**Solution:** Check and remove blocking rules

### **4. Server Firewall (3% of cases)**
**Solution:** Contact hosting provider

### **5. Plugin Conflict (2% of cases)**
**Solution:** Disable all plugins except ours, test, then re-enable one by one

---

## ✅ **VERIFICATION CHECKLIST**

After trying fixes, verify:

- [ ] Can you access `http://localhost:10003/wp-admin/admin-ajax.php` directly?
- [ ] Does the test page (`test-ajax.php`) show all green checkmarks?
- [ ] Can you see AJAX calls succeeding in Network tab?
- [ ] Are there any 403 errors in browser console?
- [ ] Are there any PHP errors in error log?

---

## 🆘 **IF NOTHING WORKS**

### **Nuclear Option: Reset Permissions**

```bash
cd "/Users/ahmadharoonalizadeh/Local Sites/gotrip-1/app/public"

# Reset file permissions
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;

# Reset wp-admin permissions
chmod 755 wp-admin
chmod 644 wp-admin/admin-ajax.php
```

### **Reinstall WordPress Core:**
```bash
wp core download --force --skip-content
```

This will replace core files without touching plugins/themes.

---

## 📊 **REPORT BACK**

After running the diagnostic test, tell me:

1. **Which test failed?** (from test-ajax.php)
2. **What action is failing?** (from Network tab)
3. **What's the exact error message?** (from Response tab)
4. **Any security plugins active?**
5. **Any errors in PHP log?**

Then I can give you the **exact fix**! 🎯

---

## 🎉 **EXPECTED RESULT**

After fixing, you should see:
- ✅ No 403 errors in console
- ✅ AJAX calls succeed (200 status)
- ✅ Real-time sync works
- ✅ Staff portal loads
- ✅ All features functional

---

**Run the diagnostic test first:** `http://localhost:10003/test-ajax.php` 🚀


