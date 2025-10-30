# CHBS Integration - Quick Guide

## 📋 **What You're Seeing**

When you open a booking, you see:
```
CHBS Integration:
☐ Not linked to CHBS
☐ Create CHBS booking on save
```

This means the booking is **not yet connected to CHBS**.

---

## ✅ **How to Link to CHBS**

### **Method 1: Create New Booking with CHBS**

1. **Go to:** `GoTrip Manager → Add Booking`

2. **Fill in required fields:**
   - Customer name
   - Customer email ✅ (required for CHBS)
   - Customer phone
   - Pickup location ✅ (required for CHBS)
   - Pickup date ✅ (required for CHBS)
   - Pickup time
   - Dropoff location
   - Number of passengers

3. **In the Publish box (right sidebar), look for:**
   ```
   CHBS Integration:
   ☐ Not linked to CHBS
   ☐ Create CHBS booking on save
   ```

4. **Check the box:** ☑ **"Create CHBS booking on save"**

5. **Click:** `Publish`

6. **Result:**
   - ✅ CHBS booking created automatically
   - ✅ Price calculated by CHBS
   - ✅ Booking linked (you'll see CHBS booking ID)
   - ✅ "View in CHBS" button appears

---

### **Method 2: Link Existing Booking to CHBS**

1. **Go to:** `GoTrip Manager → All Bookings`

2. **Click on any booking** that shows "Not linked to CHBS"

3. **Scroll to Publish box** (right sidebar)

4. **Check the box:** ☑ **"Create CHBS booking on save"**

5. **Click:** `Update`

6. **Result:**
   - ✅ CHBS booking created
   - ✅ Price calculated
   - ✅ Status changes to "Linked to CHBS Booking #XXX"

---

## 🔍 **After Linking - What You'll See**

Once linked, the CHBS Integration box shows:
```
CHBS Integration:
✓ Linked to CHBS Booking #123

[View in CHBS →]
```

You can click **"View in CHBS"** to open the booking in CHBS admin.

---

## 📊 **What Happens When You Link**

1. **CHBS Booking Created:**
   - Entry added to CHBS database
   - CHBS booking ID assigned

2. **Price Calculated:**
   - CHBS pricing engine calculates the price
   - Price saved to your booking

3. **Data Synced:**
   - Customer info → CHBS
   - Pickup/dropoff → CHBS
   - Date/time → CHBS
   - Passengers → CHBS

4. **Bidirectional Link:**
   - Your booking links to CHBS
   - CHBS booking links back to yours

---

## ⚠️ **Required Fields for CHBS**

To create a CHBS booking, you MUST have:

✅ **Customer Email** (required)
✅ **Pickup Location** (required)
✅ **Pickup Date** (required)

If any are missing, the CHBS booking won't be created.

---

## 🔄 **Two-Way Sync**

### **Manual Booking → CHBS**
When you check "Create CHBS booking on save":
- Your booking → CHBS database
- Price calculated by CHBS
- Linked bidirectionally

### **CHBS Widget → Your System**
When a customer books via CHBS widget:
- CHBS booking → Your unified system
- Automatically creates a booking
- Source tagged as "CHBS"
- Linked automatically

---

## 🎯 **Step-by-Step Example**

### **Create a Test Booking with CHBS:**

1. **Go to:** `GoTrip Manager → Add Booking`

2. **Fill in:**
   ```
   Customer Name: John Doe
   Customer Email: john@example.com ✅
   Customer Phone: +49 123 456789
   Pickup Location: Frankfurt Airport ✅
   Pickup Date: 2025-11-15 ✅
   Pickup Time: 10:00
   Dropoff Location: Hotel Adlon, Berlin
   Passengers: 3
   ```

3. **Scroll to right sidebar → Publish box**

4. **Find "CHBS Integration" section**

5. **Check:** ☑ **"Create CHBS booking on save"**

6. **Optional:** Check ☑ "Notify driver via email"

7. **Click:** `Publish`

8. **Wait 2-3 seconds** for CHBS to process

9. **Refresh the page** (or it auto-refreshes)

10. **You'll now see:**
    ```
    CHBS Integration:
    ✓ Linked to CHBS Booking #456
    
    [View in CHBS →]
    ```

11. **Check the price field** - it should now have a calculated price!

---

## 🛠️ **Troubleshooting**

### **"Create CHBS booking" checkbox not showing?**
✅ Check if CHBS plugin is active:
```
Plugins → Installed Plugins → Chauffeur Booking System (should be active)
```

### **Checkbox checked but booking not created?**
✅ Check required fields:
- Customer email
- Pickup location
- Pickup date

✅ Check error logs:
```
wp-content/debug.log
```

### **Price not calculated?**
✅ CHBS needs vehicle pricing configured:
```
CHBS → Vehicles → Edit vehicle → Set base price
```

### **"View in CHBS" button not working?**
✅ Check CHBS admin URL:
```
Should open: /wp-admin/admin.php?page=chbs&action=edit&id=XXX
```

---

## 🏥 **Health Check**

To verify CHBS integration is working:

1. **Go to:** `GoTrip Manager → 🏥 Health Check`

2. **Look for "CHBS Integration" row:**
   - ✅ **Success**: CHBS active, X bookings linked
   - ⚠️ **Warning**: CHBS not active
   - ❌ **Error**: CHBS table not found

3. **If warning/error, follow the fix suggestions**

---

## 📝 **Summary**

| Action | Result |
|--------|--------|
| Check "Create CHBS booking" | Creates CHBS booking + calculates price |
| Leave unchecked | Booking stays in your system only |
| Customer books via CHBS widget | Auto-creates unified booking |

---

## 🚀 **Next Steps**

1. ✅ Create a test booking
2. ✅ Check "Create CHBS booking on save"
3. ✅ Click Publish
4. ✅ Verify CHBS booking ID appears
5. ✅ Check if price was calculated
6. ✅ Click "View in CHBS" to verify

---

**Your CHBS integration is fully functional - just check the box when creating/editing bookings!** 🎉


