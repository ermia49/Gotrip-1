# 🧪 Test Integration Wiring - Quick Verification

## 🎯 **Quick Tests to Run Right Now**

---

## ✅ **Test 1: Verify Plugin is Active**

### **Visit:**
```
http://localhost:10003/wp-admin/plugins.php
```

### **Check:**
- ✅ "GoTrip Unified Booking System" is active
- ✅ Version: 1.0.0
- ✅ No errors displayed

---

## ✅ **Test 2: Verify Database Tables**

### **Visit:**
```
http://localhost:10003/wp-admin/admin.php?page=gtub-dashboard
```

### **Check:**
- ✅ Page loads without errors
- ✅ Stats cards display
- ✅ No database errors

---

## ✅ **Test 3: Test Manual Sync**

### **Visit:**
```
http://localhost:10003/wp-admin/admin.php?page=gtub-sync
```

### **Steps:**
1. Click "Sync All Bookings Now"
2. Wait for results

### **Expected:**
```
✅ CHBS: Synced X bookings
✅ JetBooking: Synced X bookings  
✅ GTBM: Synced X bookings
```

---

## ✅ **Test 4: Verify Bookings Display**

### **Visit:**
```
http://localhost:10003/wp-admin/admin.php?page=gtub-bookings
```

### **Check:**
- ✅ Booking list displays
- ✅ Filters work
- ✅ Source badges show (CHBS, MANUAL, etc.)
- ✅ Quick actions work

---

## ✅ **Test 5: Test REST API**

### **Open Browser Console** (F12) and run:

```javascript
// Test GET bookings
fetch('/wp-json/gotrip/v1/bookings')
  .then(r => r.json())
  .then(data => console.log('Bookings:', data));

// Test GET stats
fetch('/wp-json/gotrip/v1/stats')
  .then(r => r.json())
  .then(data => console.log('Stats:', data));
```

### **Expected:**
```json
{
  "total": 2,
  "today": 0,
  "pending": 1,
  "confirmed": 1,
  "revenue": 0
}
```

---

## ✅ **Test 6: Verify Staff Portal**

### **Visit:**
```
http://localhost:10003/staff-portal/
```

### **Check:**
- ✅ Page loads without header/footer
- ✅ Green sidebar displays
- ✅ Dashboard loads
- ✅ Can switch between components

---

## ✅ **Test 7: Verify Frontend Pages**

### **Visit:**
```
http://localhost:10003/all-bookings/
```

### **Check:**
- ✅ Booking cards display
- ✅ "View Details" modal works
- ✅ GoTrip branding visible

---

## ✅ **Test 8: Verify Cron Jobs**

### **Check Scheduled Events:**

Visit:
```
http://localhost:10003/wp-admin/tools.php?page=cron-events
```

Or use WP-CLI:
```bash
wp cron event list
```

### **Expected:**
```
✅ gtub_sync_bookings - hourly
✅ gtub_parse_emails - every_15_minutes
```

---

## ✅ **Test 9: Trigger Manual Cron**

### **Run in Terminal:**
```bash
cd "/Users/ahmadharoonalizadeh/Local Sites/gotrip-1/app/public"

# Trigger sync
wp cron event run gtub_sync_bookings

# Check last sync time
wp option get gtub_last_sync
```

### **Expected:**
```
Success: Executed the cron event 'gtub_sync_bookings'
2025-10-29 16:30:00
```

---

## ✅ **Test 10: Check Integration Classes**

### **Verify Classes are Loaded:**

Visit:
```
http://localhost:10003/wp-admin/admin.php?page=gtub-dashboard
```

Open browser console and run:
```javascript
// Check if classes exist (via AJAX test)
jQuery.post(ajaxurl, {
  action: 'gtub_staff_get_stats',
  nonce: gtubStaff.nonce
}, function(response) {
  console.log('Stats Response:', response);
});
```

---

## 🔍 **QUICK DIAGNOSTIC CHECKLIST**

### **✅ Core Plugin**
- [ ] Plugin is active
- [ ] No PHP errors
- [ ] Admin menu appears

### **✅ Database**
- [ ] Tables exist (wp_gtub_bookings, etc.)
- [ ] Can query tables
- [ ] No SQL errors

### **✅ Integrations**
- [ ] CHBS sync works (manual)
- [ ] JetBooking sync works (manual)
- [ ] WooCommerce hooks registered
- [ ] Email parser class loaded

### **✅ Admin Interface**
- [ ] Dashboard loads
- [ ] Booking list loads
- [ ] Filters work
- [ ] Quick actions work

### **✅ Frontend**
- [ ] Staff portal loads
- [ ] All bookings page loads
- [ ] Shortcodes work

### **✅ API & Cron**
- [ ] REST API responds
- [ ] Cron jobs scheduled
- [ ] Cron handlers hooked

---

## 🚨 **IF SOMETHING FAILS**

### **1. Check PHP Error Log:**
```bash
tail -f "/Users/ahmadharoonalizadeh/Local Sites/gotrip-1/logs/php/error.log"
```

### **2. Check WordPress Debug Log:**
```bash
tail -f "/Users/ahmadharoonalizadeh/Local Sites/gotrip-1/app/public/wp-content/debug.log"
```

### **3. Enable Debug Mode:**
Edit `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

### **4. Clear All Caches:**
```
http://localhost:10003/clear-cache.php
```

### **5. Reactivate Plugin:**
```
1. Go to: wp-admin/plugins.php
2. Deactivate "GoTrip Unified Booking System"
3. Activate it again
```

---

## 📊 **EXPECTED RESULTS**

After running all tests, you should have:

✅ **Plugin Active** - No errors  
✅ **Database Tables** - All created  
✅ **Manual Sync** - Works for CHBS/JetBooking  
✅ **Booking List** - Displays synced bookings  
✅ **REST API** - Returns data  
✅ **Staff Portal** - Loads without header/footer  
✅ **Frontend Pages** - Display bookings  
✅ **Cron Jobs** - Scheduled and hooked  

---

## 🎯 **NEXT STEPS AFTER TESTING**

1. **If all tests pass:** ✅ System is fully wired and functional
2. **If CHBS sync fails:** ⚠️ Need to verify CHBS hook names
3. **If JetBooking sync fails:** ⚠️ Need to verify JetBooking hook names
4. **If WooCommerce sync fails:** ⚠️ Need to create test order with booking meta

---

## 🎉 **SUCCESS CRITERIA**

The integration is **fully wired** if:

✅ Manual sync works for all sources  
✅ Bookings display in admin  
✅ Staff portal loads correctly  
✅ REST API returns data  
✅ Cron jobs are scheduled  
✅ No PHP errors in logs  

**Status:** Ready for production testing! 🚀


