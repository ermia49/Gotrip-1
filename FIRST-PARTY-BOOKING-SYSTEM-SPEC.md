# 🚀 First-Party Booking System - Complete Specification

## 📋 **Project Overview**

**Objective:** Build a complete, standalone booking system to replace GoTrip plugin and CHBS dependencies.

**Timeline:** 12 Phases (estimated 4-6 weeks)

**Tech Stack:**
- **Backend:** WordPress REST API + Custom PHP
- **Frontend:** React.js + Tailwind CSS
- **Database:** MySQL (WordPress tables)
- **Payments:** Stripe API
- **Notifications:** Email (wp_mail) + SMS (Twilio)
- **Auth:** WordPress users + custom RBAC

---

## 🎯 **Core Features**

### **1. Customer Booking Page**
- Public-facing booking form
- Real-time price calculation
- Google Maps autocomplete
- Payment processing
- Booking confirmation
- Email notification

### **2. Staff Dashboard**
- Booking management (CRUD)
- Advanced filters & search
- Driver assignment
- Payment management
- Customer communications
- Export functionality

### **3. Payment System**
- Stripe integration
- Capture/charge payments
- Refund processing
- Payment status tracking
- Receipt generation
- Webhook handling

### **4. Driver Management**
- Driver profiles
- Assignment system
- Availability tracking
- Notification system
- Performance metrics

### **5. Notifications**
- Email templates
- SMS notifications
- Delivery tracking
- Resend functionality
- Status monitoring

### **6. Audit Trail**
- Complete change history
- User tracking
- Timeline view
- System events
- Export logs

---

## 📊 **Database Schema**

### **Table: `wp_bookings`**
```sql
CREATE TABLE wp_bookings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_number VARCHAR(50) UNIQUE NOT NULL,
    customer_id BIGINT UNSIGNED,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(50) NOT NULL,
    
    pickup_location VARCHAR(500) NOT NULL,
    pickup_lat DECIMAL(10, 8),
    pickup_lng DECIMAL(11, 8),
    dropoff_location VARCHAR(500) NOT NULL,
    dropoff_lat DECIMAL(10, 8),
    dropoff_lng DECIMAL(11, 8),
    
    pickup_datetime DATETIME NOT NULL,
    return_datetime DATETIME NULL,
    
    passengers INT NOT NULL DEFAULT 1,
    luggage INT NOT NULL DEFAULT 0,
    vehicle_type VARCHAR(100),
    trip_type ENUM('one-way', 'round-trip', 'hourly') DEFAULT 'one-way',
    
    distance_km DECIMAL(10, 2),
    duration_minutes INT,
    
    price DECIMAL(10, 2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'EUR',
    
    status ENUM('pending', 'confirmed', 'assigned', 'in-progress', 'completed', 'cancelled') DEFAULT 'pending',
    payment_status ENUM('unpaid', 'requires_action', 'paid', 'refunded', 'partial') DEFAULT 'unpaid',
    
    driver_id BIGINT UNSIGNED NULL,
    assigned_at DATETIME NULL,
    
    notes TEXT,
    special_requests TEXT,
    internal_notes TEXT,
    
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by BIGINT UNSIGNED,
    updated_by BIGINT UNSIGNED,
    
    INDEX idx_booking_number (booking_number),
    INDEX idx_customer_email (customer_email),
    INDEX idx_status (status),
    INDEX idx_payment_status (payment_status),
    INDEX idx_driver_id (driver_id),
    INDEX idx_pickup_datetime (pickup_datetime),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### **Table: `wp_booking_payments`**
```sql
CREATE TABLE wp_booking_payments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_id BIGINT UNSIGNED NOT NULL,
    
    provider ENUM('stripe', 'paypal', 'manual', 'cash') DEFAULT 'stripe',
    transaction_id VARCHAR(255),
    intent_id VARCHAR(255),
    
    amount DECIMAL(10, 2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'EUR',
    
    type ENUM('charge', 'refund', 'partial_refund') DEFAULT 'charge',
    status ENUM('pending', 'processing', 'succeeded', 'failed', 'cancelled') DEFAULT 'pending',
    
    receipt_url VARCHAR(500),
    failure_reason TEXT,
    
    metadata JSON,
    
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    processed_at DATETIME NULL,
    created_by BIGINT UNSIGNED,
    
    FOREIGN KEY (booking_id) REFERENCES wp_bookings(id) ON DELETE CASCADE,
    INDEX idx_booking_id (booking_id),
    INDEX idx_transaction_id (transaction_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### **Table: `wp_booking_drivers`**
```sql
CREATE TABLE wp_booking_drivers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED UNIQUE,
    
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    
    license_number VARCHAR(100),
    license_expiry DATE,
    
    vehicle_make VARCHAR(100),
    vehicle_model VARCHAR(100),
    vehicle_year INT,
    vehicle_plate VARCHAR(50),
    
    rating DECIMAL(3, 2) DEFAULT 5.00,
    total_trips INT DEFAULT 0,
    total_earnings DECIMAL(10, 2) DEFAULT 0.00,
    
    status ENUM('active', 'inactive', 'on-leave', 'suspended') DEFAULT 'active',
    
    notes TEXT,
    
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### **Table: `wp_booking_notifications`**
```sql
CREATE TABLE wp_booking_notifications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_id BIGINT UNSIGNED NOT NULL,
    
    type ENUM('customer_confirmation', 'customer_update', 'driver_assignment', 'driver_update', 'payment_receipt', 'cancellation') NOT NULL,
    channel ENUM('email', 'sms', 'push') NOT NULL,
    
    recipient_name VARCHAR(255),
    recipient_email VARCHAR(255),
    recipient_phone VARCHAR(50),
    
    subject VARCHAR(500),
    message TEXT,
    
    status ENUM('pending', 'sent', 'delivered', 'failed', 'bounced') DEFAULT 'pending',
    provider_id VARCHAR(255),
    provider_response TEXT,
    
    sent_at DATETIME NULL,
    delivered_at DATETIME NULL,
    
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by BIGINT UNSIGNED,
    
    FOREIGN KEY (booking_id) REFERENCES wp_bookings(id) ON DELETE CASCADE,
    INDEX idx_booking_id (booking_id),
    INDEX idx_type (type),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### **Table: `wp_booking_audit_log`**
```sql
CREATE TABLE wp_booking_audit_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_id BIGINT UNSIGNED NOT NULL,
    
    actor_id BIGINT UNSIGNED,
    actor_role VARCHAR(50),
    actor_name VARCHAR(255),
    
    action VARCHAR(100) NOT NULL,
    entity_type VARCHAR(50) NOT NULL,
    entity_id BIGINT UNSIGNED,
    
    before_value JSON,
    after_value JSON,
    
    ip_address VARCHAR(45),
    user_agent TEXT,
    
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (booking_id) REFERENCES wp_bookings(id) ON DELETE CASCADE,
    INDEX idx_booking_id (booking_id),
    INDEX idx_actor_id (actor_id),
    INDEX idx_action (action),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 🔌 **REST API Endpoints**

### **Bookings**
```
POST   /wp-json/gotrip/v1/bookings              Create booking
GET    /wp-json/gotrip/v1/bookings              List bookings (with filters)
GET    /wp-json/gotrip/v1/bookings/:id          Get booking details
PATCH  /wp-json/gotrip/v1/bookings/:id          Update booking
DELETE /wp-json/gotrip/v1/bookings/:id          Cancel booking
POST   /wp-json/gotrip/v1/bookings/:id/duplicate Duplicate booking
```

### **Payments**
```
POST   /wp-json/gotrip/v1/bookings/:id/payments/capture  Capture payment
POST   /wp-json/gotrip/v1/bookings/:id/payments/refund   Refund payment
POST   /wp-json/gotrip/v1/payments/webhook                Stripe webhook
GET    /wp-json/gotrip/v1/bookings/:id/payments          List payments
```

### **Drivers**
```
POST   /wp-json/gotrip/v1/bookings/:id/assign-driver    Assign driver
DELETE /wp-json/gotrip/v1/bookings/:id/unassign-driver  Unassign driver
GET    /wp-json/gotrip/v1/drivers                        List drivers
GET    /wp-json/gotrip/v1/drivers/:id                    Get driver
PATCH  /wp-json/gotrip/v1/drivers/:id                    Update driver
```

### **Notifications**
```
POST   /wp-json/gotrip/v1/bookings/:id/notify           Send notification
POST   /wp-json/gotrip/v1/bookings/:id/resend           Resend confirmation
GET    /wp-json/gotrip/v1/bookings/:id/notifications    List notifications
```

### **Audit**
```
GET    /wp-json/gotrip/v1/bookings/:id/audit            Get audit log
GET    /wp-json/gotrip/v1/audit                         Global audit log
```

### **Export**
```
GET    /wp-json/gotrip/v1/export/bookings.csv          Export bookings CSV
GET    /wp-json/gotrip/v1/export/payments.csv          Export payments CSV
```

---

## 🎨 **UI Components**

### **Customer Booking Page**
- **URL:** `/booking/`
- **Layout:** Full-width, minimal header/footer
- **Components:**
  - Booking form (multi-step or single page)
  - Google Maps integration
  - Price calculator
  - Payment form (Stripe Elements)
  - Confirmation screen
  - Booking reference display

### **Staff Dashboard**
- **URL:** `/wp-admin/admin.php?page=gotrip-bookings`
- **Layout:** WordPress admin theme
- **Components:**
  - Bookings table with filters
  - Quick actions (Assign, Charge, Resend)
  - Detail modal/drawer
  - Tabs: Details, Payments, Driver, Messages, Audit
  - Export button
  - Create booking button

---

## 🔐 **RBAC (Role-Based Access Control)**

### **Roles:**

**Administrator:**
- Full access to everything
- Can delete bookings
- Can manage drivers
- Can view all audit logs

**Staff:**
- Create/edit/cancel bookings
- Assign drivers
- Process payments
- Send notifications
- View audit logs

**Driver:**
- View assigned bookings
- Update booking status
- View customer contact info
- Cannot edit pricing

**Customer:**
- View own bookings only
- Cannot edit after confirmation
- Can request cancellation

---

## 📧 **Notification Templates**

### **Customer Confirmation Email**
```
Subject: Booking Confirmation #{booking_number} - GoTrip Today

Dear {customer_name},

Your booking has been confirmed!

Booking Details:
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Booking Number: {booking_number}
Pickup: {pickup_location}
Drop-off: {dropoff_location}
Date & Time: {pickup_datetime}
Passengers: {passengers}
Total Price: {currency} {price}
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

A driver will be assigned shortly.

View Booking: {booking_url}

Best regards,
GoTrip Today Team
```

### **Driver Assignment Email**
```
Subject: New Booking Assignment #{booking_number}

Hello {driver_name},

You have been assigned to a new booking.

Booking Details:
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Booking: #{booking_number}
Customer: {customer_name}
Phone: {customer_phone}
Pickup: {pickup_location}
Drop-off: {dropoff_location}
Date & Time: {pickup_datetime}
Passengers: {passengers}
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

View Details: {booking_url}

Please confirm receipt.

GoTrip Today
```

---

## 🔄 **Migration Plan**

### **Phase 1: Preparation**
1. Backup database
2. Export existing bookings
3. Document current data structure
4. Create migration scripts

### **Phase 2: Parallel Run**
1. Deploy new system
2. Run both systems in parallel
3. Sync data between systems
4. Monitor for issues

### **Phase 3: Cutover**
1. Migrate all data to new system
2. Redirect old URLs to new system
3. Disable old plugins
4. Monitor closely

### **Phase 4: Cleanup**
1. Archive old data
2. Remove old plugin code
3. Clean up database tables
4. Update documentation

---

## ✅ **Acceptance Criteria**

- [ ] Customer can create booking and receive confirmation
- [ ] Staff can view all bookings with filters
- [ ] Staff can edit booking details
- [ ] Staff can assign driver and driver receives notification
- [ ] Staff can capture payment via Stripe
- [ ] Staff can refund payment
- [ ] Staff can resend confirmation emails
- [ ] All actions logged in audit trail
- [ ] RBAC enforced on all endpoints
- [ ] Responsive UI on all devices
- [ ] All tests passing
- [ ] GoTrip plugin removed
- [ ] Data migrated successfully

---

## 📅 **Timeline Estimate**

**Phase 1-3 (Database & API):** 1 week
**Phase 4-5 (Dashboard & Payments):** 1 week
**Phase 6-7 (Notifications & Drivers):** 1 week
**Phase 8-9 (Audit & RBAC):** 3 days
**Phase 10-11 (Migration & Testing):** 1 week
**Phase 12 (Decommission):** 2 days

**Total:** 4-5 weeks

---

## 🚀 **Ready to Start?**

This is a comprehensive project. Shall I:

1. **Start with Phase 1** (Database Schema)?
2. **Create a simplified MVP** first?
3. **Focus on specific features** you need most urgently?

**Let me know how you'd like to proceed!** 🎯


