# 🔄 Sync CHBS & DayTrip Bookings - Complete Guide

## 🎯 **Quick Action**

### **Step 1: Check What Tables Exist**
```
http://localhost:10003/check-tables.php
```

This will show you:
- ✅ All CHBS tables and their structure
- ✅ All JetBooking (DayTrip) tables and their structure
- ✅ GTBM bookings count
- ✅ Current unified bookings
- ✅ Column names for each table

---

### **Step 2: Run Manual Sync**
```
http://localhost:10003/manual-sync.php
```

This will:
- 🔄 Sync all CHBS bookings
- 🔄 Sync all JetBooking (DayTrip) bookings
- 🔄 Sync all GTBM bookings
- 📊 Show detailed results
- ✅ Display total synced count

---

### **Step 3: Verify Sync**
```
http://localhost:10003/wp-admin/admin.php?page=gtub-bookings
```

Check if bookings appear in the unified system.

---

## 🔍 **Why Bookings Might Not Sync**

### **1. No Bookings Exist**
- CHBS has no bookings yet
- JetBooking has no tours booked
- GTBM has no manual bookings

**Solution:** Create test bookings first

---

### **2. Table Structure Mismatch**
- CHBS table name is different
- JetBooking column names are different

**Solution:** The sync now auto-detects tables and columns ✅

---

### **3. Already Synced**
- Bookings were already synced before
- Duplicate detection prevents re-syncing

**Solution:** This is normal! Check unified bookings table

---

## 📊 **Expected Results**

### **After Running manual-sync.php:**

```
🚗 CHBS Bookings:
Array (
    [synced] => 5
    [failed] => 0
    [total] => 5
    [message] => Synced 5 CHBS bookings, 0 failed
)

🎫 JetBooking Tours:
Array (
    [synced] => 3
    [failed] => 0
    [total] => 3
    [message] => Synced 3 JetBooking bookings, 0 failed
)

📝 GTBM Bookings:
Array (
    [synced] => 2
    [failed] => 0
    [total] => 2
    [message] => Synced 2 GTBM bookings, 0 failed
)

Total Synced: 10
Total Failed: 0
Total in Unified System: 10
```

---

## 🎯 **Troubleshooting**

### **If "0 synced":**

1. **Check if bookings exist:**
   ```
   http://localhost:10003/check-tables.php
   ```
   Look for row counts in each table

2. **Check if already synced:**
   - Visit unified bookings page
   - Look for bookings from that source

3. **Check PHP error log:**
   ```bash
   tail -f "/Users/ahmadharoonalizadeh/Local Sites/gotrip-1/logs/php/error.log"
   ```

---

### **If "Table doesn't exist":**

**For CHBS:**
- Make sure CHBS plugin is active
- Create at least one test booking in CHBS
- CHBS creates tables on first booking

**For JetBooking:**
- Make sure JetBooking plugin is active
- Create at least one test tour booking
- JetBooking creates tables on first booking

---

### **If "Column doesn't exist":**

✅ **This is now fixed!** The sync auto-detects available columns.

But if you still see errors:
1. Run `check-tables.php` to see actual column names
2. Check PHP error log for specific column names
3. Report back with table structure

---

## 🔄 **Real-Time Sync**

After manual sync works, real-time sync will work automatically:

### **CHBS:**
- Hook: `chbs_after_booking_sent` ✅
- Triggers: When customer creates booking
- Speed: < 1 second ⚡

### **JetBooking:**
- Hook: `jet-booking/rest-api/add-booking/set-related-order-data` ✅
- Triggers: When customer books tour
- Speed: < 1 second ⚡

### **Fallback:**
- Runs: Every 5 minutes
- Catches: Any missed bookings
- Coverage: 100%

---

## 📝 **Create Test Bookings**

### **CHBS Test Booking:**
1. Go to your CHBS booking form
2. Fill in:
   - Pickup location
   - Dropoff location
   - Date & time
   - Passengers
3. Submit booking
4. Check unified system immediately

### **JetBooking Test Booking:**
1. Go to your JetBooking tour page
2. Select:
   - Tour/Activity
   - Check-in date
   - Guests
3. Submit booking
4. Check unified system immediately

### **Manual Test Booking:**
1. Go to: `wp-admin/post-new.php?post_type=gtbm_booking`
2. Fill in booking details
3. Publish
4. Run manual sync

---

## 🎯 **Verification Checklist**

- [ ] Ran `check-tables.php` - Saw tables and columns
- [ ] Ran `manual-sync.php` - Saw sync results
- [ ] Checked unified bookings - Saw synced bookings
- [ ] Created test CHBS booking - Synced instantly
- [ ] Created test JetBooking - Synced instantly
- [ ] No errors in PHP log
- [ ] Push notifications working (if configured)

---

## 📊 **Understanding Sync Results**

### **"synced: 0, failed: 0, total: 5"**
**Meaning:** 5 bookings exist, but all were already synced before

**Action:** Check unified bookings - they should be there

---

### **"synced: 5, failed: 0, total: 5"**
**Meaning:** 5 new bookings were synced successfully

**Action:** ✅ Perfect! Check unified bookings

---

### **"synced: 3, failed: 2, total: 5"**
**Meaning:** 3 synced, 2 failed (missing data)

**Action:** Check PHP error log for specific errors

---

## 🚀 **Quick Commands**

### **Check Tables:**
```
http://localhost:10003/check-tables.php
```

### **Manual Sync:**
```
http://localhost:10003/manual-sync.php
```

### **View Bookings:**
```
http://localhost:10003/wp-admin/admin.php?page=gtub-bookings
```

### **Staff Portal:**
```
http://localhost:10003/staff-portal/
```

### **Diagnostic Test:**
```
http://localhost:10003/test-ajax.php
```

---

## 🎉 **Expected Final State**

After everything is set up:

1. ✅ **Manual sync works** - All existing bookings synced
2. ✅ **Real-time sync works** - New bookings sync instantly
3. ✅ **Fallback sync works** - Catches any missed bookings
4. ✅ **Push notifications work** - Telegram/WhatsApp/Email
5. ✅ **No errors** - Clean PHP error log
6. ✅ **All bookings visible** - In unified system

---

## 📞 **Next Steps**

1. **Run check-tables.php** to see what exists
2. **Run manual-sync.php** to sync existing bookings
3. **Create test booking** to verify real-time sync
4. **Check unified bookings** to see results
5. **Report back** with sync results!

---

**Let's sync those bookings!** 🚀💚


