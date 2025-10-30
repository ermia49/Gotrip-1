# 🚀 Booking Form - Quick Start Guide

## 📍 **Access the Form**

**URL:** `http://localhost:10003/wp-admin/post-new.php?post_type=gtbm_booking`

---

## ⚡ **Quick Workflow (30 seconds)**

### **Step 1: Select System** (5 sec)
```
Click: [CHBS] or [DayTrip] or [Manual]
```

### **Step 2: Customer Info** (10 sec)
```
Name:  John Doe
Email: john@example.com
Phone: +49 123 456789
```

### **Step 3: Trip Details** (10 sec)
```
Trip Type:    ⦿ One Way
Pickup:       Frankfurt Airport
Drop-off:     Munich City Center
Date:         2025-11-15
Time:         10:00
```

### **Step 4: Vehicle** (5 sec)
```
Vehicle:      Mercedes S-Class
Passengers:   4
Luggage:      3
```

### **Step 5: Calculate & Confirm** (5 sec)
```
1. Click: [Calculate Price]
2. Review: €160.00
3. Click: [Confirm Booking]
```

**Done! ✅ Customer receives email automatically!**

---

## 🎯 **What Each Button Does**

### **💾 Save as Draft**
- Saves all data
- No email sent
- Can edit later
- Status: Draft

### **✅ Confirm Booking**
- Validates all fields
- Sends customer email
- Creates CHBS booking
- Status: Confirmed

### **🛒 Create WooCommerce Order**
- Creates payment order
- Links to booking
- Opens in new tab
- Ready for payment

---

## 📧 **Email Preview**

Customer receives this after confirming:

```
Subject: Booking Confirmation #123 - GoTrip Today

Dear John Doe,

Thank you for your booking! Your reservation has been confirmed.

Booking Details:
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Booking ID: #123
Pickup: Frankfurt Airport
Drop-off: Munich City Center
Date: November 15, 2025
Time: 10:00 AM
Passengers: 4
Total Price: EUR 160.00
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

A driver will be assigned shortly.

Best regards,
GoTrip Today Team
```

---

## 🎨 **Visual Layout**

```
┌─────────────────────────────────────────────────────────┐
│  Select Booking System                                  │
│  ┌─────────┐  ┌─────────┐  ┌─────────┐                │
│  │  CHBS   │  │ DayTrip │  │ Manual  │                │
│  └─────────┘  └─────────┘  └─────────┘                │
├─────────────────────────────────────────────────────────┤
│  👤 Customer Information                                │
│  Name: [________________]  Email: [________________]    │
│  Phone: [________________]                              │
├─────────────────────────────────────────────────────────┤
│  📍 Trip Details                                        │
│  Trip: ⦿ One Way  ○ Round Trip  ○ Hourly              │
│  Pickup: [________________]  Date: [__________]         │
│  Drop-off: [______________]  Time: [__________]         │
├─────────────────────────────────────────────────────────┤
│  🚗 Vehicle & Passengers                                │
│  Vehicle: [Select Vehicle ▼]                            │
│  Passengers: [4]  Luggage: [3]                          │
├─────────────────────────────────────────────────────────┤
│  💰 Price Calculation                                   │
│  ┌───────────────────────────────────────────────┐     │
│  │ Base Price              € 100.00              │     │
│  │ Distance Charge         €  50.00              │     │
│  │ Additional Fees         €  10.00              │     │
│  │ ─────────────────────────────────────────     │     │
│  │ Total Price             € 160.00              │     │
│  └───────────────────────────────────────────────┘     │
│  [🧮 Calculate Price]                                   │
├─────────────────────────────────────────────────────────┤
│  📝 Additional Information                              │
│  Special Requests: [_____________________________]      │
│  Internal Notes:   [_____________________________]      │
├─────────────────────────────────────────────────────────┤
│  [💾 Save Draft] [✅ Confirm] [🛒 Create Order]        │
└─────────────────────────────────────────────────────────┘
```

---

## ✅ **Required Fields Checklist**

Before confirming, make sure you have:

- ☑️ Customer Name
- ☑️ Customer Email
- ☑️ Customer Phone
- ☑️ Pickup Location
- ☑️ Drop-off Location
- ☑️ Pickup Date
- ☑️ Pickup Time
- ☑️ Number of Passengers
- ☑️ Price Calculated

---

## 🔄 **Common Workflows**

### **1. Standard Booking**
```
Select CHBS → Fill Info → Calculate → Confirm → Create Order
```

### **2. Quote Only**
```
Select System → Fill Info → Calculate → Save Draft
```

### **3. Manual Booking**
```
Select Manual → Fill Info → Enter Custom Price → Confirm
```

### **4. Round Trip**
```
Select Round Trip → Fill Dates (Pickup + Return) → Calculate
```

---

## 💡 **Tips & Tricks**

### **Speed Tips:**
1. **Tab Navigation** - Use Tab key to move between fields
2. **Vehicle Auto-Fill** - Select vehicle to auto-fill passengers
3. **Copy Previous** - Duplicate similar bookings

### **Pricing Tips:**
1. **Calculate First** - Always calculate before confirming
2. **Check Breakdown** - Review price details
3. **Adjust if Needed** - Can manually edit price

### **Customer Service:**
1. **Special Requests** - Note child seats, flight numbers
2. **Internal Notes** - Add context for drivers
3. **Follow Up** - Create WC order for payment

---

## 🎯 **Status Meanings**

| Status | What It Means | What Happens |
|--------|---------------|--------------|
| **Draft** | Saved but not confirmed | No email sent |
| **Confirmed** | Booking confirmed | Email sent to customer |
| **In Progress** | Driver assigned, trip started | Driver notified |
| **Completed** | Trip finished | Invoice generated |
| **Cancelled** | Booking cancelled | Refund process |

---

## 📱 **Mobile Access**

The form works on mobile too!
- All fields stack vertically
- Touch-friendly buttons
- Responsive design

---

## 🐛 **Quick Fixes**

### **Problem: Can't calculate price**
**Solution:** Fill all required fields first (marked with *)

### **Problem: Email not sending**
**Solution:** Check customer email is valid

### **Problem: Can't create WC order**
**Solution:** Calculate price first, then confirm booking

---

## ✅ **You're Ready!**

**Go to:** `http://localhost:10003/wp-admin/post-new.php?post_type=gtbm_booking`

**Start creating bookings!** 🚀💚


