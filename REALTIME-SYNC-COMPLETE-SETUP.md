# 🔄 Real-Time Sync - Complete Setup Guide

## ✅ **3-Step Setup (2 Minutes)**

---

## 🚀 **Step 1: Fix Database (30 seconds)**

### **Access:**
```
http://localhost:10003/check-and-fix-db.php
```

**This will:**
- ✅ Check if `updated_at` column exists
- ✅ Add it if missing
- ✅ Create index for fast queries
- ✅ Initialize timestamps
- ✅ Test that updates work

**Expected Output:**
```
✅ Table exists
✅ updated_at column exists (or added)
✅ Index on updated_at exists (or added)
✅ updated_at is working! Timestamp changed.
```

---

## 🧪 **Step 2: Test Real-Time Sync (30 seconds)**

### **Access:**
```
http://localhost:10003/test-realtime-sync.php
```

**Click these buttons in order:**
1. ✅ **"Check Scripts"** - Verify all scripts loaded
2. ✅ **"Test AJAX"** - Verify endpoint works
3. ✅ **"Check Database"** - Verify database ready
4. ✅ **"Start Sync"** - Start real-time polling

**Expected Console Output:**
```
✅ jQuery loaded
✅ realtime-sync.js loaded
✅ GTUBRealtimeSync object exists
✅ gtubRealtime config exists
✅ AJAX endpoint is working!
🔄 Starting real-time sync...
🔍 Checking for updates...
✓ No updates (or 📥 Updates found)
```

---

## 🎯 **Step 3: Test Live Sync (1 minute)**

### **Open Two Tabs:**

**Tab 1 - Admin:**
```
http://localhost:10003/wp-admin/admin.php?page=gtub-bookings
```

**Tab 2 - Staff Portal:**
```
http://localhost:10003/staff-portal/
```

### **Test:**
1. In Tab 1 (Admin), find booking #28892
2. Change its status or assign a driver
3. **Watch Tab 2 (Staff Portal) update within 5 seconds!** ✅
4. Try the reverse: change in Tab 2, watch Tab 1 update

### **What You Should See:**
- ✅ Toast notification: `🔄 1 booking updated`
- ✅ Row highlights with blue pulse
- ✅ Status badge changes color
- ✅ Dropdown values update

---

## 🔍 **Troubleshooting:**

### **Issue 1: Scripts Not Loading**

**Check:**
```
http://localhost:10003/test-realtime-sync.php
```
Click "Check Scripts"

**If scripts missing:**
1. Deactivate plugin
2. Reactivate plugin
3. Hard refresh browser (Ctrl+Shift+R)

---

### **Issue 2: AJAX 403 Error**

**Check:**
```
http://localhost:10003/test-realtime-sync.php
```
Click "Test AJAX"

**If 403 error:**
- Nonce might be invalid
- Try logging out and back in
- Clear browser cache

---

### **Issue 3: Database Not Ready**

**Check:**
```
http://localhost:10003/check-and-fix-db.php
```

**Look for:**
- ✅ updated_at column exists
- ✅ Index exists
- ✅ Test update works

**If any ❌:**
- The page will auto-fix it
- Refresh the page to verify

---

### **Issue 4: Updates Not Syncing**

**Open Console (F12) and check for:**
```
✅ Real-time sync initialized
```

**If missing:**
1. Check if you're on the bookings page
2. Hard refresh (Ctrl+Shift+R)
3. Check console for JavaScript errors

**If present but not syncing:**
1. Check database has `updated_at` column
2. Verify AJAX endpoint works (test page)
3. Check console for AJAX errors

---

## 📊 **How It Works:**

```
┌─────────────────────────────────────┐
│ 1. User changes booking #28892      │
│    (status, driver, etc.)           │
└─────────────────────────────────────┘
              ↓
┌─────────────────────────────────────┐
│ 2. Database updates booking         │
│    SET updated_at = NOW()           │
└─────────────────────────────────────┘
              ↓
┌─────────────────────────────────────┐
│ 3. Real-time sync polls (5 sec)     │
│    WHERE updated_at > last_check    │
└─────────────────────────────────────┘
              ↓
┌─────────────────────────────────────┐
│ 4. Updates detected!                │
│    - Send to all connected clients  │
└─────────────────────────────────────┘
              ↓
┌─────────────────────────────────────┐
│ 5. UI Updates:                      │
│    - Toast notification             │
│    - Row highlight                  │
│    - Badge update                   │
└─────────────────────────────────────┘
```

---

## ✅ **Verification Checklist:**

### **Database:**
- [ ] `updated_at` column exists
- [ ] `idx_updated_at` index exists
- [ ] Timestamps update automatically
- [ ] Test update works

### **Scripts:**
- [ ] jQuery loaded
- [ ] realtime-sync.js loaded
- [ ] GTUBRealtimeSync object exists
- [ ] gtubRealtime config exists

### **AJAX:**
- [ ] Endpoint returns 200 OK
- [ ] Nonce is valid
- [ ] Response has bookings/activities
- [ ] No 403 errors

### **Live Sync:**
- [ ] Console shows "Real-time sync initialized"
- [ ] Polling every 5 seconds
- [ ] Updates detected
- [ ] Toast notifications appear
- [ ] Rows highlight
- [ ] Two tabs sync

---

## 🎯 **Expected Behavior:**

### **When You Change Booking #28892:**

**Immediately (in same tab):**
- ✅ Dropdown/field changes
- ✅ AJAX request sent
- ✅ Database updated

**Within 5 seconds (in other tabs):**
- ✅ Polling detects change
- ✅ Toast notification appears
- ✅ Row highlights briefly
- ✅ Status badge updates
- ✅ Stats update (if affected)

---

## 📝 **Test Pages:**

| Page | URL | Purpose |
|------|-----|---------|
| **Database Fix** | `/check-and-fix-db.php` | Fix database schema |
| **Sync Test** | `/test-realtime-sync.php` | Test all components |
| **Admin Bookings** | `/wp-admin/admin.php?page=gtub-bookings` | Main admin interface |
| **Staff Portal** | `/staff-portal/` | Staff interface |
| **Clear Cache** | `/clear-cache.php` | Clear all caches |

---

## 🔧 **Quick Fixes:**

### **Fix 1: Restart Everything**
```
1. Go to: http://localhost:10003/check-and-fix-db.php
2. Refresh page
3. Go to: http://localhost:10003/test-realtime-sync.php
4. Click "Start Sync"
5. Go to: http://localhost:10003/wp-admin/admin.php?page=gtub-bookings
6. Hard refresh (Ctrl+Shift+R)
7. Open console (F12)
8. Look for "Real-time sync initialized"
```

### **Fix 2: Force Database Update**
```
1. Go to: http://localhost:10003/check-and-fix-db.php
2. Scroll to bottom
3. Check if test update works
4. If not, run SQL manually (see DATABASE-FIX-GUIDE.md)
```

### **Fix 3: Clear Everything**
```
1. Clear browser cache (Ctrl+Shift+Delete)
2. Clear WordPress cache: /clear-cache.php
3. Deactivate plugin
4. Reactivate plugin
5. Hard refresh browser
```

---

## 🎉 **Success Indicators:**

### **✅ Everything is Working If:**

1. **Database Check Page:**
   - ✅ updated_at column exists
   - ✅ Index exists
   - ✅ Test update works

2. **Test Page:**
   - ✅ All scripts loaded
   - ✅ AJAX returns 200 OK
   - ✅ Sync starts without errors

3. **Admin/Staff Portal:**
   - ✅ Console: "Real-time sync initialized"
   - ✅ No JavaScript errors
   - ✅ Polling every 5 seconds

4. **Two-Tab Test:**
   - ✅ Change in Tab 1 appears in Tab 2
   - ✅ Toast notification shows
   - ✅ Row highlights
   - ✅ Within 5 seconds

---

## 📞 **Quick Links:**

```
Database Fix:
http://localhost:10003/check-and-fix-db.php

Sync Test:
http://localhost:10003/test-realtime-sync.php

Admin Bookings:
http://localhost:10003/wp-admin/admin.php?page=gtub-bookings

Staff Portal:
http://localhost:10003/staff-portal/
```

---

**Follow these 3 steps and real-time sync will work!** ✅🔄💚

**Start with the database fix, then test, then enjoy live sync!** 🚀


