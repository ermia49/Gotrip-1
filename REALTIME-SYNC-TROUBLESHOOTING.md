# 🔍 Real-Time Sync Troubleshooting

## Issue: Updates not syncing for booking #28892

---

## ✅ **Quick Fix Steps:**

### **Step 1: Check if Real-Time Sync is Running**

Open browser console (F12) on the bookings page and check for:
```
✅ Real-time sync initialized
```

If you don't see this, the script isn't loading.

---

### **Step 2: Manually Test the Sync**

In browser console, run:
```javascript
// Check if sync object exists
console.log(typeof GTUBRealtimeSync);

// Manually trigger update check
GTUBRealtimeSync.checkForUpdates();

// Check last check time
console.log('Last check:', GTUBRealtimeSync.lastCheck);
```

---

### **Step 3: Test AJAX Endpoint**

In browser console:
```javascript
jQuery.ajax({
    url: ajaxurl,
    type: 'POST',
    data: {
        action: 'gtub_get_updates',
        nonce: gtubRealtime.nonce,
        last_check: '2025-10-29 00:00:00'
    },
    success: function(response) {
        console.log('Response:', response);
    },
    error: function(xhr, status, error) {
        console.error('Error:', error);
    }
});
```

---

### **Step 4: Check Database Column**

The `updated_at` column might be missing. Let's add it manually:

**Option A: Via WordPress Admin**
```
http://localhost:10003/wp-admin/admin.php?page=gtub-settings
```
(We'll add a "Fix Database" button)

**Option B: Via SQL**
```sql
ALTER TABLE wp_gtub_bookings 
ADD COLUMN updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at;

ALTER TABLE wp_gtub_bookings 
ADD INDEX idx_updated_at (updated_at);

UPDATE wp_gtub_bookings 
SET updated_at = created_at 
WHERE updated_at IS NULL;
```

---

### **Step 5: Force Update Booking #28892**

In browser console:
```javascript
// Manually update the booking
jQuery.ajax({
    url: ajaxurl,
    type: 'POST',
    data: {
        action: 'gtub_quick_change_status',
        nonce: jQuery('[data-booking-id="28892"]').find('.gtub-quick-status').data('nonce') || gtubRealtime.nonce,
        booking_id: 28892,
        status: 'confirmed'
    },
    success: function(response) {
        console.log('Update response:', response);
    }
});
```

---

## 🔧 **Common Issues:**

### **Issue 1: Script Not Loading**
**Symptom:** No console message "Real-time sync initialized"

**Fix:**
1. Clear browser cache (Ctrl+Shift+Delete)
2. Hard refresh (Ctrl+Shift+R)
3. Check if you're on the bookings page

---

### **Issue 2: AJAX 403 Error**
**Symptom:** Console shows "403 Forbidden"

**Fix:**
Already fixed in previous session, but verify nonce is correct:
```javascript
console.log('Nonce:', gtubRealtime.nonce);
```

---

### **Issue 3: Database Column Missing**
**Symptom:** No updates detected

**Fix:**
Run the SQL query above to add `updated_at` column

---

### **Issue 4: Polling Not Active**
**Symptom:** Updates don't appear

**Fix:**
```javascript
// Check if polling is active
console.log('Is active:', GTUBRealtimeSync.isActive);

// Manually start polling
GTUBRealtimeSync.startPolling();
```

---

## 🧪 **Testing Real-Time Sync:**

### **Test 1: Console Check**
```javascript
// Open console on bookings page
// You should see:
✅ Real-time sync initialized

// Every 5 seconds you should see:
📥 Received updates: {...}
```

### **Test 2: Manual Update**
1. Open Admin bookings page
2. Open browser console (F12)
3. Change a booking status
4. Watch console for:
```
📥 Received updates: {bookings: Array(1), ...}
Booking updated: #28892
```

### **Test 3: Two Tabs**
1. Open Admin in Tab 1
2. Open Staff Portal in Tab 2
3. Change status in Tab 1
4. Watch Tab 2 update (within 5 seconds)

---

## 🔍 **Debug Mode:**

Add this to your console to see all sync activity:
```javascript
// Enable verbose logging
GTUBRealtimeSync.on('booking_updated', function(booking) {
    console.log('📝 Booking updated:', booking);
});

GTUBRealtimeSync.on('stats_updated', function(stats) {
    console.log('📊 Stats updated:', stats);
});

// Check sync status every second
setInterval(function() {
    console.log('Sync active:', GTUBRealtimeSync.isActive, 
                'Last check:', GTUBRealtimeSync.lastCheck);
}, 1000);
```

---

## 🚀 **Quick Fix Script:**

Run this in browser console to force everything:
```javascript
// Force clear and restart
GTUBRealtimeSync.stopPolling();
GTUBRealtimeSync.lastCheck = '2025-10-29 00:00:00';
GTUBRealtimeSync.isActive = true;
GTUBRealtimeSync.startPolling();

console.log('✅ Real-time sync restarted!');
```

---

## 📝 **What to Check:**

1. ✅ Browser console shows "Real-time sync initialized"
2. ✅ No JavaScript errors in console
3. ✅ `gtubRealtime` object exists
4. ✅ `GTUBRealtimeSync` object exists
5. ✅ AJAX requests return 200 OK
6. ✅ Database has `updated_at` column
7. ✅ Polling is active (every 5 seconds)

---

## 🎯 **Expected Console Output:**

```
✅ Real-time sync initialized

[After 5 seconds]
📥 Received updates: {
    bookings: [],
    activities: [],
    stats: {...},
    has_updates: false
}

[When booking changes]
📥 Received updates: {
    bookings: [
        {id: 28892, status: "confirmed", ...}
    ],
    has_updates: true
}
Booking updated: #28892
🔄 1 booking updated
```

---

## 💡 **Immediate Test:**

1. Open: `http://localhost:10003/wp-admin/admin.php?page=gtub-bookings`
2. Press F12 (open console)
3. Look for: `✅ Real-time sync initialized`
4. If you see it: **Sync is working!**
5. If you don't: **Script not loading**

---

## 🔧 **If Still Not Working:**

### **Force Reload Everything:**
```javascript
// In console
location.reload(true);
```

### **Clear All Caches:**
1. Browser cache (Ctrl+Shift+Delete)
2. WordPress cache: `http://localhost:10003/clear-cache.php`
3. Plugin cache: Deactivate → Activate plugin

### **Check Network Tab:**
1. Open DevTools (F12)
2. Go to Network tab
3. Look for `admin-ajax.php` requests
4. Check if they return 200 OK

---

**Try these steps and let me know what you see in the console!** 🔍


