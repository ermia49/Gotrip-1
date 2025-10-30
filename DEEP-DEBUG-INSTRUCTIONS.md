# 🔍 DEEP DEBUG - Real-Time Sync

## 📋 **Follow These Steps Exactly:**

---

## **Step 1: Clear Everything**

1. **Clear Browser Cache:**
   - Mac: **Cmd + Shift + Delete**
   - Select "Cached images and files"
   - Click "Clear data"

2. **Hard Refresh:**
   - Mac: **Cmd + Shift + R**

---

## **Step 2: Open Debug Page**
```
http://localhost:10003/debug-realtime-sync.php
```

This will show:
- ✅ PHP classes loaded
- ✅ Database structure
- ✅ AJAX endpoints registered
- ✅ Script files exist

Click "Test AJAX Endpoint" to verify it works.

---

## **Step 3: Go to Admin Bookings**
```
http://localhost:10003/wp-admin/admin.php?page=gtub-bookings
```

---

## **Step 4: Open Console**
Press **Cmd + Option + I** (Mac)

---

## **Step 5: Look for These Messages**

You should see:
```
GTUBRealtimeSync.init() called
gtubRealtime exists: true
gtubRealtime config: {ajaxurl: "...", nonce: "...", interval: 5000}
✅ Real-time sync initialized
Polling interval: 5000ms
```

If you see these, it's working!

---

## **Step 6: Watch for Updates**

Every 5 seconds you should see:
```
🔍 Checking for updates, last_check: 2025-10-29 18:00:00
📥 Response: {success: true, data: {...}}
✓ No updates
```

---

## **Step 7: Test Update**

1. Open another tab with Staff Portal
2. Change a booking status
3. Within 5 seconds, console should show:
```
🔍 Checking for updates...
📥 Response: {success: true, data: {has_updates: true, bookings: [...]}}
✅ Updates found!
```

---

## 🚨 **If Not Working:**

### **Check 1: Scripts Loading**
In console, type:
```javascript
typeof jQuery
// Should return: "function"

typeof gtubRealtime
// Should return: "object"

typeof GTUBRealtimeSync
// Should return: "object"
```

### **Check 2: Manual Init**
If GTUBRealtimeSync exists but didn't initialize, run:
```javascript
GTUBRealtimeSync.init();
```

### **Check 3: Manual Update Check**
```javascript
GTUBRealtimeSync.checkForUpdates();
```

### **Check 4: View Config**
```javascript
console.log(gtubRealtime);
```

---

## 📊 **Common Issues:**

### **Issue 1: "gtubRealtime is not defined"**
- Script not loading on this page
- Check the admin hook

### **Issue 2: No polling messages**
- Script loaded but not initialized
- Try manual init

### **Issue 3: 403/404 AJAX errors**
- Nonce expired
- Logout and login again

### **Issue 4: Updates not detected**
- Database `updated_at` not changing
- Check if ON UPDATE CURRENT_TIMESTAMP is set

---

## 🔧 **Debug Info to Share:**

When reporting the issue, share:
1. What you see in console
2. Any error messages
3. Results of the manual checks
4. Screenshot of console

---

## 📝 **Alternative Test:**

If admin page doesn't work, test on:
```
http://localhost:10003/check-admin-hook.php
```

This will redirect to admin bookings and log the hook name in console.

---

**Follow these steps and tell me exactly what you see in the console!** 🔍

