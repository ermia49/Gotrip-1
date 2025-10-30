# 🧪 Real-Time Sync - Test Guide

## Test Booking #28892 (and all others)

---

## ✅ **Step-by-Step Testing:**

### **Step 1: Open Admin Bookings Page**
```
http://localhost:10003/wp-admin/admin.php?page=gtub-bookings
```

### **Step 2: Open Browser Console**
- Press **F12** (or Cmd+Option+I on Mac)
- Click on **Console** tab

### **Step 3: Check if Real-Time Sync is Running**
You should see:
```
✅ Real-time sync initialized
```

If you see this, **sync is active!** ✅

---

## 🔄 **Test Real-Time Updates:**

### **Test 1: Change Status for Booking #28892**

1. Find booking #28892 in the list
2. Change its status using the dropdown
3. Watch the console - you should see:
```
📥 Received updates: {...}
Booking updated: #28892
```
4. A toast notification should appear: **"🔄 1 booking updated"**
5. The row should pulse with blue background briefly

---

### **Test 2: Assign Driver**

1. Select a driver from the dropdown for booking #28892
2. Watch the console for updates
3. Toast notification should appear
4. Row should highlight

---

### **Test 3: Two Tabs (Admin + Staff Portal)**

**Tab 1 - Admin:**
```
http://localhost:10003/wp-admin/admin.php?page=gtub-bookings
```

**Tab 2 - Staff Portal:**
```
http://localhost:10003/staff-portal/
```

**Steps:**
1. Open both tabs side by side
2. In Admin (Tab 1), change status of booking #28892
3. Wait 5 seconds
4. Watch Staff Portal (Tab 2) - it should update automatically!
5. Try the reverse: change something in Staff Portal, watch Admin update

---

## 🔍 **Manual Console Tests:**

### **Test A: Check Sync Object**
```javascript
// In console
console.log(GTUBRealtimeSync);
console.log('Is active:', GTUBRealtimeSync.isActive);
console.log('Last check:', GTUBRealtimeSync.lastCheck);
```

### **Test B: Force Update Check**
```javascript
// Manually trigger update check
GTUBRealtimeSync.checkForUpdates();
```

### **Test C: Test AJAX Endpoint**
```javascript
jQuery.ajax({
    url: gtubRealtime.ajaxurl,
    type: 'POST',
    data: {
        action: 'gtub_get_updates',
        nonce: gtubRealtime.nonce,
        last_check: '2025-10-29 00:00:00'
    },
    success: function(response) {
        console.log('✅ AJAX Response:', response);
    },
    error: function(xhr, status, error) {
        console.error('❌ AJAX Error:', error);
    }
});
```

### **Test D: Update Booking #28892 Directly**
```javascript
// Change status
jQuery.ajax({
    url: gtubRealtime.ajaxurl,
    type: 'POST',
    data: {
        action: 'gtub_quick_change_status',
        nonce: gtubRealtime.nonce,
        booking_id: 28892,
        status: 'confirmed'
    },
    success: function(response) {
        console.log('✅ Status changed:', response);
    }
});
```

---

## 📊 **What to Look For:**

### **In Console:**
```
✅ Real-time sync initialized
[Every 5 seconds]
📥 Received updates: {bookings: [], activities: [], stats: {...}}
```

### **When Update Happens:**
```
📥 Received updates: {bookings: [Object], ...}
Booking updated: #28892
🔄 1 booking updated
```

### **On Screen:**
- ✅ Toast notification appears (bottom-right)
- ✅ Row pulses with blue background
- ✅ Status badge changes color
- ✅ Dropdown values update

---

## 🚨 **Troubleshooting:**

### **Issue: No "Real-time sync initialized" message**

**Solution:**
1. Hard refresh: **Ctrl+Shift+R** (or Cmd+Shift+R on Mac)
2. Clear browser cache
3. Check if you're on the correct page

---

### **Issue: "GTUBRealtimeSync is not defined"**

**Solution:**
```javascript
// Check if script is loaded
console.log(document.querySelectorAll('script[src*="realtime-sync"]'));
```

If empty, the script isn't loading. Try:
1. Deactivate and reactivate the plugin
2. Clear WordPress cache
3. Hard refresh browser

---

### **Issue: Updates not appearing**

**Solution:**
1. Check if polling is active:
```javascript
console.log('Active:', GTUBRealtimeSync.isActive);
```

2. If false, restart it:
```javascript
GTUBRealtimeSync.startPolling();
```

3. Check last check time:
```javascript
console.log('Last check:', GTUBRealtimeSync.lastCheck);
```

---

### **Issue: AJAX 403 Error**

**Solution:**
```javascript
// Check nonce
console.log('Nonce:', gtubRealtime.nonce);

// If undefined, refresh the page
location.reload(true);
```

---

## 🎯 **Expected Behavior:**

### **When you change booking #28892:**

**Immediately:**
- ✅ Dropdown changes
- ✅ AJAX request sent

**Within 5 seconds (in other tabs):**
- ✅ Status badge updates
- ✅ Row highlights briefly
- ✅ Toast notification appears
- ✅ Stats update (if affected)

---

## 📝 **Test Checklist:**

- [ ] Console shows "Real-time sync initialized"
- [ ] `GTUBRealtimeSync` object exists
- [ ] `gtubRealtime` object exists with nonce
- [ ] Changing status triggers update
- [ ] Assigning driver triggers update
- [ ] Toast notifications appear
- [ ] Rows highlight on update
- [ ] Two tabs sync with each other
- [ ] Admin → Staff Portal sync works
- [ ] Staff Portal → Admin sync works
- [ ] No JavaScript errors in console
- [ ] No AJAX 403 errors

---

## 🎉 **Success Criteria:**

✅ **Real-time sync is working if:**
1. Console shows initialization message
2. Updates appear within 5 seconds
3. Toast notifications show
4. Rows highlight on change
5. Two tabs stay in sync
6. No errors in console

---

## 🔧 **Quick Fixes:**

### **Fix 1: Restart Sync**
```javascript
GTUBRealtimeSync.stopPolling();
GTUBRealtimeSync.lastCheck = '2025-10-29 00:00:00';
GTUBRealtimeSync.isActive = true;
GTUBRealtimeSync.startPolling();
console.log('✅ Sync restarted!');
```

### **Fix 2: Force Immediate Update**
```javascript
GTUBRealtimeSync.checkForUpdates();
```

### **Fix 3: Clear and Reload**
```javascript
location.reload(true);
```

---

## 📞 **Debug Information:**

Run this to get full debug info:
```javascript
console.log('=== REAL-TIME SYNC DEBUG ===');
console.log('Sync object:', typeof GTUBRealtimeSync);
console.log('Is active:', GTUBRealtimeSync?.isActive);
console.log('Last check:', GTUBRealtimeSync?.lastCheck);
console.log('Interval:', gtubRealtime?.interval);
console.log('Nonce:', gtubRealtime?.nonce);
console.log('AJAX URL:', gtubRealtime?.ajaxurl);
console.log('User ID:', gtubRealtime?.user_id);
console.log('Is admin:', gtubRealtime?.is_admin);
```

---

**Now test booking #28892 and watch the magic happen!** ✨🔄

**Any changes should sync within 5 seconds!** ⏱️✅


