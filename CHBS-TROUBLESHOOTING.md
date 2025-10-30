# CHBS Integration Not Linking - Troubleshooting

## 🔍 **What I Just Fixed**

I've added **detailed error messages** to show you exactly why CHBS isn't linking. Now when you try to create a CHBS booking, you'll see one of these messages:

### **Success Message:**
```
✅ CHBS Integration Success! CHBS Booking #123 created with price: €50.00
```

### **Error Messages:**
```
❌ CHBS Integration Error: CHBS plugin is not active
❌ CHBS Integration Error: Missing required fields: Pickup Location, Customer Email
❌ CHBS Integration Error: Failed to create CHBS booking. Check if CHBS database table exists.
```

---

## 🎯 **Step-by-Step Test**

### **1. Create a Test Booking:**

1. Go to: `GoTrip Manager → Add Booking`

2. Fill in **ALL required fields:**
   ```
   Customer Name: Test Customer
   Customer Email: test@example.com ✅ REQUIRED
   Customer Phone: +49 123 456789
   Pickup Location: Frankfurt Airport ✅ REQUIRED
   Pickup Date: 2025-12-01 ✅ REQUIRED
   Pickup Time: 10:00
   Dropoff Location: Berlin Hotel
   Passengers: 2
   ```

3. **Scroll to right sidebar** → Find "CHBS Integration" box

4. **Check the box:** ☑ **"Create CHBS booking on save"**

5. **Click:** `Publish`

6. **Look for the message at the top of the page:**
   - ✅ Success? Great! It worked!
   - ❌ Error? Read the message - it tells you what's wrong

---

## 🔧 **Common Issues & Fixes**

### **Issue 1: "CHBS plugin is not active"**

**Fix:**
```
1. Go to: Plugins → Installed Plugins
2. Find: "Chauffeur Booking System" or "CHBS"
3. Click: "Activate"
4. Try again
```

### **Issue 2: "Missing required fields"**

**Fix:**
The error message will tell you exactly which fields are missing. Example:
```
Missing required fields: Customer Email, Pickup Date
```

Go back and fill in those specific fields, then try again.

### **Issue 3: "Failed to create CHBS booking"**

This means the CHBS database table doesn't exist.

**Fix:**
```
1. Go to: Plugins → Installed Plugins
2. Find: "Chauffeur Booking System"
3. Deactivate it
4. Activate it again
5. This will recreate the database tables
6. Try creating a booking again
```

### **Issue 4: Checkbox not showing**

If you don't see the "CHBS Integration" box at all:

**Fix:**
```
1. Check if CHBS plugin is installed and active
2. Go to: GoTrip Manager → Health Check
3. Look for "CHBS Integration" row
4. Follow the fix suggestions
```

---

## 🏥 **Run Health Check**

```
GoTrip Manager → 🏥 Health Check
```

Look for the **"CHBS Integration"** row:

| Status | What It Means | Fix |
|--------|---------------|-----|
| ✅ Success | CHBS active, X bookings linked | All good! |
| ⚠️ Warning | CHBS not active | Activate CHBS plugin |
| ❌ Error | CHBS table not found | Reinstall CHBS |

---

## 📊 **Check CHBS Database Table**

To verify the CHBS table exists, you can check in phpMyAdmin or run this SQL:

```sql
SHOW TABLES LIKE 'wp_chbs_booking';
```

If the table doesn't exist, CHBS plugin needs to be reinstalled.

---

## 🎯 **Quick Diagnostic**

Try this exact test:

1. **Create a new booking with these exact values:**
   - Customer Email: `test@test.com`
   - Pickup Location: `Test Location`
   - Pickup Date: `2025-12-15`

2. **Check the "Create CHBS booking" box**

3. **Click Publish**

4. **What message do you see?**
   - If **success**: System is working!
   - If **error**: Tell me the exact error message

---

## 🔍 **Debug Mode**

If you still don't see any messages, enable WordPress debug mode:

1. Open: `wp-config.php`

2. Find this line:
   ```php
   define('WP_DEBUG', false);
   ```

3. Change to:
   ```php
   define('WP_DEBUG', true);
   define('WP_DEBUG_LOG', true);
   define('WP_DEBUG_DISPLAY', false);
   ```

4. Try creating a booking again

5. Check the log file:
   ```
   wp-content/debug.log
   ```

---

## 📝 **What to Tell Me**

If it's still not working, tell me:

1. **What error message do you see?** (exact text)
2. **Is CHBS plugin active?** (check Plugins page)
3. **Did you fill in all required fields?**
   - Customer Email
   - Pickup Location
   - Pickup Date

---

## 🚀 **Expected Behavior**

When it works correctly:

1. You check the box
2. You click Publish/Update
3. You see: **"✅ CHBS Integration Success! CHBS Booking #123 created"**
4. The page refreshes
5. The "CHBS Integration" box now shows:
   ```
   ✓ Linked to CHBS Booking #123
   [View in CHBS →]
   ```

---

**Now try creating a booking and tell me what message you see!** 🔍


