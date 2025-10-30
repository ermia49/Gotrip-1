# 🚀 Unified Booking System - Activation Guide

## ✅ **Quick Start (3 Steps)**

### **Step 1: Activate the Plugin**

1. Go to: `http://localhost:10003/wp-admin/plugins.php`
2. Find **"GoTrip Unified Booking System"**
3. Click **"Activate"**

**What happens:**
- ✅ Creates 7 database tables automatically
- ✅ Schedules cron jobs (sync every hour, email parsing every 15 min)
- ✅ Initializes all integrations (CHBS, JetBooking, WooCommerce)
- ✅ Adds admin menu "Unified Bookings"

---

### **Step 2: Access the Dashboard**

Go to: `http://localhost:10003/wp-admin/admin.php?page=gtub-dashboard`

**You'll see:**
- 📊 Total bookings count
- 💰 Payments count
- 🚗 Driver assignments count
- 🔄 Pending sync queue count
- 📋 Recent bookings table

---

### **Step 3: Test the Integration**

#### **Test CHBS Sync:**
1. Create a booking via CHBS Form 25108:
   - Go to: `http://localhost:10003/booking-page/`
   - Fill out the form
   - Complete the booking
2. Check Unified Bookings:
   - Go to: `http://localhost:10003/wp-admin/admin.php?page=gtub-bookings`
   - You should see the booking with a **blue "CHBS" badge**

#### **Test JetBooking Sync:**
1. Create a tour booking via JetBooking
2. Check Unified Bookings
3. You should see it with a **purple "JETBOOKING" badge**

#### **Test Manual Booking:**
1. In the old GoTrip Booking Manager, create a manual booking
2. It will automatically appear in Unified Bookings

---

## 🎛️ **Admin Menu Structure**

After activation, you'll see a new menu in WordPress admin:

```
📅 Unified Bookings
   ├── Dashboard          (Stats & overview)
   ├── All Bookings       (List with filters)
   └── Settings           (Email parser config)
```

---

## 🔍 **Where to Find Things**

### **Dashboard**
`/wp-admin/admin.php?page=gtub-dashboard`
- View stats
- See recent bookings
- Quick overview

### **All Bookings**
`/wp-admin/admin.php?page=gtub-bookings`
- Filter by source (CHBS, JetBooking, Manual, Email)
- Filter by status (Pending, Confirmed, etc.)
- Search by booking #, customer name, email, phone
- Assign drivers
- View booking details

### **Settings**
`/wp-admin/admin.php?page=gtub-settings`
- Enable/disable email parser
- Configure IMAP settings
- Set email credentials

---

## 🔄 **How Sync Works**

### **Automatic Sync (No Action Needed)**

**CHBS Bookings:**
- When a customer books via CHBS Form 25108
- Automatically appears in Unified Bookings
- Source badge: **CHBS** (blue)

**JetBooking Tours:**
- When a customer books a tour
- Automatically appears in Unified Bookings
- Source badge: **JETBOOKING** (purple)

**WooCommerce Payments:**
- When payment is completed
- Automatically updates booking payment status
- Links WooCommerce order to booking

**Email Bookings:**
- When email arrives (if enabled)
- Automatically parsed and created
- Source badge: **EMAIL** (green)
- Marked as "Needs Review"

---

## 📧 **Email Parser Setup (Optional)**

If you want to import bookings from emails:

1. Go to: `/wp-admin/admin.php?page=gtub-settings`
2. Check **"Enable Email Parser"**
3. Enter IMAP server: `{imap.gmail.com:993/imap/ssl}INBOX`
4. Enter email username
5. Enter email password
6. Click **"Save Settings"**

**How it works:**
- Checks inbox every 15 minutes
- Extracts booking details (name, email, phone, date, passengers)
- Creates booking automatically
- Marks as "Needs Review"
- Sends admin notification

---

## 🎨 **Understanding the Interface**

### **Source Badges**
- 🔵 **CHBS** - From CHBS Form 25108
- 🟣 **JETBOOKING** - From JetBooking tours
- 🟠 **MANUAL** - Created manually
- 🟢 **EMAIL** - Parsed from email
- 🔴 **API** - From REST API

### **Status Badges**
- 🟡 **Pending** - Awaiting confirmation
- 🔵 **Confirmed** - Confirmed by customer
- 🟢 **Assigned** - Driver assigned
- 🔵 **In Progress** - Trip in progress
- ✅ **Completed** - Trip completed
- 🔴 **Cancelled** - Booking cancelled
- ⚫ **No Show** - Customer didn't show up

### **Payment Badges**
- 🔴 **Unpaid** - Payment not received
- 🟡 **Requires Action** - Payment needs action
- ✅ **Paid** - Payment completed
- ⚫ **Refunded** - Payment refunded
- 🔵 **Partial** - Partially paid

---

## 🔗 **Integration Status Check**

After activation, check if integrations are working:

### **CHBS Integration** ✅
- Create a test booking via CHBS Form 25108
- Check if it appears in Unified Bookings
- Source should be "CHBS"

### **JetBooking Integration** ✅
- Create a test tour booking
- Check if it appears in Unified Bookings
- Source should be "JETBOOKING"

### **WooCommerce Integration** ✅
- Complete a payment via WooCommerce
- Check if payment status updates in Unified Bookings
- Payment badge should change to "PAID"

---

## 🚨 **Troubleshooting**

### **Plugin not visible after activation**
- Refresh the page
- Clear browser cache
- Check if plugin is active: `/wp-admin/plugins.php`

### **Bookings not syncing from CHBS**
- Check if CHBS plugin is active
- Create a test booking
- Check database: `wp_gtub_bookings` table should have entries

### **Database tables not created**
- Deactivate and reactivate the plugin
- Check database for tables starting with `wp_gtub_`

### **Email parser not working**
- Check IMAP settings
- Test connection manually
- Check cron jobs are running

---

## 📊 **Database Tables Created**

After activation, these tables are created:

1. `wp_gtub_bookings` - Main bookings table
2. `wp_gtub_payments` - Payment records
3. `wp_gtub_audit_log` - Audit trail
4. `wp_gtub_driver_assignments` - Driver assignments
5. `wp_gtub_notifications` - Notification log
6. `wp_gtub_sync_queue` - Failed sync queue
7. `wp_gtub_email_log` - Email parsing log

---

## 🎯 **What You Can Do Now**

✅ **View all bookings** from all sources in one place
✅ **Filter bookings** by source, status, payment status
✅ **Search bookings** by customer name, email, phone, booking #
✅ **Assign drivers** to any booking
✅ **Track payments** from WooCommerce
✅ **View audit trail** of all changes
✅ **Parse email bookings** automatically (if enabled)
✅ **Access via REST API** for custom integrations

---

## 🚀 **Ready to Go!**

The system is **fully functional** and will automatically:
- ✅ Capture all CHBS bookings
- ✅ Capture all JetBooking tours
- ✅ Track WooCommerce payments
- ✅ Parse email bookings (if enabled)
- ✅ Provide unified dashboard
- ✅ Offer complete audit trail

**Just activate and start using!** 💚


