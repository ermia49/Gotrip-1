# 🚀 Unified Booking System - Quick Start

## ⚡ **3-Step Setup**

### **Step 1: Activate Plugin** ✅
Already done! Plugin is active.

### **Step 2: Sync Existing Bookings** 🔄
```
1. Go to: http://localhost:10003/wp-admin/admin.php?page=gtub-sync
2. Click: "Sync All Bookings Now"
3. Wait for completion
```

### **Step 3: Create Frontend Page** 🌐
```
1. Go to: WP Admin → Pages → Add New
2. Title: "My Bookings"
3. Content: [my_bookings]
4. Publish
5. Visit: http://localhost:10003/my-bookings/
```

---

## 📍 **Important URLs**

### **Admin Pages:**
- **Dashboard:** `http://localhost:10003/wp-admin/admin.php?page=gtub-dashboard`
- **All Bookings:** `http://localhost:10003/wp-admin/admin.php?page=gtub-bookings`
- **Sync Page:** `http://localhost:10003/wp-admin/admin.php?page=gtub-sync`
- **Settings:** `http://localhost:10003/wp-admin/admin.php?page=gtub-settings`

### **Frontend Pages (Create These):**
- **My Bookings:** Create page with `[my_bookings]` shortcode
- **All Bookings:** Create page with `[unified_bookings]` shortcode (admin only)

---

## 🎯 **Shortcodes**

### **Customer Bookings:**
```
[my_bookings]
```
Shows logged-in customer's bookings in beautiful cards.

### **All Bookings (Admin):**
```
[unified_bookings]
[unified_bookings limit="100"]
[unified_bookings source="chbs"]
[unified_bookings status="confirmed"]
```

---

## 🔄 **How Sync Works**

### **Automatic (No Action Needed):**
- ✅ New CHBS bookings → Auto-synced
- ✅ New JetBooking tours → Auto-synced
- ✅ WooCommerce payments → Auto-updated
- ✅ Email bookings → Auto-parsed (if enabled)

### **Manual (For Existing Bookings):**
- Go to Sync page
- Click "Sync All Bookings Now"
- Done!

---

## 🎨 **What You Get**

### **Admin Dashboard:**
- 📊 Total bookings from all sources
- 💰 Payment tracking
- 🚗 Driver assignments
- 📋 Recent bookings table
- 🔍 Filters & search

### **Frontend Pages:**
- 🎨 Beautiful card design
- 📱 Responsive (mobile-friendly)
- 🏷️ Color-coded badges
- 📍 Booking details
- 💚 Green theme (matches branding)

---

## 🏷️ **Badge Colors**

**Source:**
- 🔵 CHBS
- 🟣 JetBooking
- 🟠 Manual
- 🟢 Email

**Status:**
- 🟡 Pending
- 🔵 Confirmed
- 🟢 Assigned
- ✅ Completed
- 🔴 Cancelled

**Payment:**
- 🔴 Unpaid
- ✅ Paid
- ⚫ Refunded

---

## ✅ **Checklist**

- [x] Plugin activated
- [ ] Sync existing bookings
- [ ] Create "My Bookings" page
- [ ] Add to menu (optional)
- [ ] Test with customer login

---

## 🆘 **Need Help?**

### **Check Sync Status:**
```
WP Admin → Unified Bookings → Dashboard
```
See total bookings count.

### **View All Bookings:**
```
WP Admin → Unified Bookings → All Bookings
```
Filter by source, status, search.

### **Resync:**
```
WP Admin → Unified Bookings → Sync Bookings
```
Safe to run multiple times.

---

## 🎉 **You're All Set!**

The system is ready to:
- ✅ Capture all bookings from all sources
- ✅ Display them in a unified dashboard
- ✅ Show customers their bookings
- ✅ Track payments automatically
- ✅ Assign drivers easily

**Just sync and create the frontend pages!** 💚


