# 🎯 Unified Booking System - Integration Specification

## 📋 **Project Overview**

**Objective:** Build a centralized first-party booking management system that integrates with:
- ✅ **CHBS** (Chauffeur Booking System) - Form 25108
- ✅ **DayTrip/JetBooking** (Tours & Activities)
- ✅ **WooCommerce** (Payments & Orders)
- ✅ **Email Parser** (External booking imports)
- ✅ **Manual Bookings** (Direct admin entry)

**Goal:** One unified dashboard to manage ALL bookings from ALL sources!

---

## 🔄 **System Architecture**

```
┌─────────────────────────────────────────────────────────┐
│           UNIFIED BOOKING SYSTEM (Master)               │
│                                                         │
│  ┌───────────────────────────────────────────────┐    │
│  │         Central Booking Database              │    │
│  │  (All bookings from all sources stored here) │    │
│  └───────────────────────────────────────────────┘    │
│                         ↕                              │
│  ┌───────────────────────────────────────────────┐    │
│  │         Integration Layer                     │    │
│  │  • CHBS Sync                                  │    │
│  │  • JetBooking Sync                            │    │
│  │  • WooCommerce Sync                           │    │
│  │  • Email Parser                               │    │
│  └───────────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────────┘
                         ↕
    ┌──────────┬──────────┬──────────┬──────────┐
    │   CHBS   │ JetBook  │   WC     │  Email   │
    │  Form    │  Tours   │ Orders   │  Parser  │
    └──────────┴──────────┴──────────┴──────────┘
```

---

## 🔗 **Integration Points**

### **1. CHBS Integration (Form 25108)**

**Sync Direction:** ↔️ Two-Way

**When Customer Books via CHBS:**
```
1. Customer fills CHBS form (Form 25108)
2. CHBS creates booking in its database
3. Hook: chbs_booking_created
4. Our system captures booking data
5. Creates unified booking record
6. Links CHBS booking ID
7. Syncs status changes
```

**When Admin Creates in Unified System:**
```
1. Admin creates booking in dashboard
2. System creates CHBS booking entry
3. Links both IDs
4. Syncs changes both ways
```

**Hooks to Use:**
```php
// Capture CHBS bookings
add_action('chbs_booking_created', 'sync_chbs_to_unified', 10, 2);
add_action('chbs_booking_updated', 'sync_chbs_to_unified', 10, 2);
add_action('chbs_booking_cancelled', 'sync_chbs_cancellation', 10, 1);

// Push to CHBS
function create_chbs_booking_from_unified($booking_id);
function update_chbs_booking_from_unified($booking_id);
```

---

### **2. JetBooking Integration (DayTrip/Tours)**

**Sync Direction:** ↔️ Two-Way

**When Customer Books Tour:**
```
1. Customer books via JetBooking widget
2. JetBooking creates booking
3. Hook: jet-booking/booking/created
4. Our system captures data
5. Creates unified booking (type: tour)
6. Links JetBooking ID
```

**When Admin Creates Tour Booking:**
```
1. Admin selects "DayTrip" tab
2. Fills tour details
3. System creates JetBooking entry
4. Links both systems
```

**Hooks to Use:**
```php
// Capture JetBooking
add_action('jet-booking/booking/created', 'sync_jetbooking_to_unified', 10, 1);
add_action('jet-booking/booking/updated', 'sync_jetbooking_to_unified', 10, 1);

// Push to JetBooking
function create_jetbooking_from_unified($booking_id);
```

---

### **3. WooCommerce Integration (Payments)**

**Sync Direction:** ↔️ Two-Way

**When Payment Processed:**
```
1. Customer pays via WooCommerce
2. Order status changes
3. Hook: woocommerce_order_status_changed
4. Our system updates payment status
5. Updates booking status
6. Sends confirmation
```

**When Admin Processes Payment:**
```
1. Admin clicks "Charge" in dashboard
2. System creates WooCommerce order
3. Processes payment via Stripe
4. Links order to booking
5. Updates payment status
```

**Hooks to Use:**
```php
// Capture WC payments
add_action('woocommerce_order_status_completed', 'sync_wc_payment', 10, 1);
add_action('woocommerce_order_status_refunded', 'sync_wc_refund', 10, 1);
add_action('woocommerce_payment_complete', 'update_booking_payment', 10, 1);

// Create WC orders
function create_wc_order_from_booking($booking_id);
function refund_wc_order($order_id, $amount);
```

---

### **4. Email Parser Integration**

**Sync Direction:** → One-Way (Email → System)

**When Email Received:**
```
1. Email arrives at designated inbox
2. Cron job checks for new emails
3. Parser extracts booking details
4. AI/Regex identifies:
   - Customer name, email, phone
   - Pickup/dropoff locations
   - Date & time
   - Passenger count
   - Price (if mentioned)
5. Creates unified booking (source: email)
6. Marks as "pending review"
7. Notifies admin
8. Admin reviews & confirms
```

**Email Sources:**
- Booking.com
- Airbnb
- Direct customer emails
- Partner agencies
- Other platforms

**Parser Logic:**
```php
// Email parsing cron
add_action('gotrip_parse_emails_cron', 'parse_incoming_emails');

// Parse email body
function parse_booking_email($email_body) {
    // Extract data using regex/AI
    // Create booking
    // Send admin notification
}
```

---

## 📊 **Unified Database Schema**

### **Main Table: `wp_unified_bookings`**

```sql
CREATE TABLE wp_unified_bookings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_number VARCHAR(50) UNIQUE NOT NULL,
    
    -- Source tracking
    source ENUM('chbs', 'jetbooking', 'manual', 'email', 'api') NOT NULL,
    source_id VARCHAR(100), -- Original booking ID from source system
    source_url VARCHAR(500), -- Link to original booking
    
    -- Customer info
    customer_id BIGINT UNSIGNED,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(50) NOT NULL,
    
    -- Booking type
    booking_type ENUM('transfer', 'tour', 'hourly', 'custom') NOT NULL,
    
    -- Transfer details (for CHBS)
    pickup_location VARCHAR(500),
    pickup_lat DECIMAL(10, 8),
    pickup_lng DECIMAL(11, 8),
    dropoff_location VARCHAR(500),
    dropoff_lat DECIMAL(10, 8),
    dropoff_lng DECIMAL(11, 8),
    
    -- Tour details (for JetBooking)
    tour_id BIGINT UNSIGNED,
    tour_name VARCHAR(255),
    checkin_date DATE,
    checkout_date DATE,
    
    -- Common details
    pickup_datetime DATETIME NOT NULL,
    return_datetime DATETIME NULL,
    
    passengers INT NOT NULL DEFAULT 1,
    luggage INT NOT NULL DEFAULT 0,
    vehicle_type VARCHAR(100),
    trip_type ENUM('one-way', 'round-trip', 'hourly', 'multi-day') DEFAULT 'one-way',
    
    distance_km DECIMAL(10, 2),
    duration_minutes INT,
    
    -- Pricing
    price DECIMAL(10, 2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'EUR',
    
    -- Status
    status ENUM('pending', 'confirmed', 'assigned', 'in-progress', 'completed', 'cancelled') DEFAULT 'pending',
    payment_status ENUM('unpaid', 'requires_action', 'paid', 'refunded', 'partial') DEFAULT 'unpaid',
    
    -- Driver assignment
    driver_id BIGINT UNSIGNED NULL,
    assigned_at DATETIME NULL,
    
    -- WooCommerce link
    wc_order_id BIGINT UNSIGNED NULL,
    
    -- CHBS link
    chbs_booking_id BIGINT UNSIGNED NULL,
    
    -- JetBooking link
    jetbooking_id BIGINT UNSIGNED NULL,
    
    -- Email parser
    parsed_from_email BOOLEAN DEFAULT FALSE,
    email_message_id VARCHAR(255),
    needs_review BOOLEAN DEFAULT FALSE,
    
    -- Notes
    notes TEXT,
    special_requests TEXT,
    internal_notes TEXT,
    
    -- Timestamps
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by BIGINT UNSIGNED,
    updated_by BIGINT UNSIGNED,
    
    -- Indexes
    INDEX idx_booking_number (booking_number),
    INDEX idx_source (source),
    INDEX idx_source_id (source_id),
    INDEX idx_customer_email (customer_email),
    INDEX idx_status (status),
    INDEX idx_payment_status (payment_status),
    INDEX idx_driver_id (driver_id),
    INDEX idx_wc_order_id (wc_order_id),
    INDEX idx_chbs_booking_id (chbs_booking_id),
    INDEX idx_jetbooking_id (jetbooking_id),
    INDEX idx_pickup_datetime (pickup_datetime),
    INDEX idx_needs_review (needs_review)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 🔄 **Sync Logic**

### **CHBS → Unified System**

```php
function sync_chbs_to_unified($chbs_booking_id, $chbs_data) {
    global $wpdb;
    
    // Check if already synced
    $existing = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM wp_unified_bookings WHERE chbs_booking_id = %d",
        $chbs_booking_id
    ));
    
    $booking_data = array(
        'source' => 'chbs',
        'source_id' => $chbs_booking_id,
        'booking_type' => 'transfer',
        'customer_name' => $chbs_data['customer_name'],
        'customer_email' => $chbs_data['customer_email'],
        'customer_phone' => $chbs_data['customer_phone'],
        'pickup_location' => $chbs_data['pickup_location'],
        'dropoff_location' => $chbs_data['dropoff_location'],
        'pickup_datetime' => $chbs_data['pickup_datetime'],
        'passengers' => $chbs_data['passengers'],
        'price' => $chbs_data['price'],
        'currency' => $chbs_data['currency'],
        'status' => map_chbs_status($chbs_data['status']),
        'chbs_booking_id' => $chbs_booking_id,
    );
    
    if ($existing) {
        // Update existing
        $wpdb->update('wp_unified_bookings', $booking_data, array('id' => $existing->id));
    } else {
        // Create new
        $booking_data['booking_number'] = generate_booking_number();
        $wpdb->insert('wp_unified_bookings', $booking_data);
    }
}
```

### **JetBooking → Unified System**

```php
function sync_jetbooking_to_unified($jetbooking_id) {
    global $wpdb;
    
    // Get JetBooking data
    $jetbooking_data = get_jetbooking_data($jetbooking_id);
    
    $booking_data = array(
        'source' => 'jetbooking',
        'source_id' => $jetbooking_id,
        'booking_type' => 'tour',
        'customer_name' => $jetbooking_data['customer_name'],
        'customer_email' => $jetbooking_data['customer_email'],
        'customer_phone' => $jetbooking_data['customer_phone'],
        'tour_id' => $jetbooking_data['apartment_id'],
        'tour_name' => get_the_title($jetbooking_data['apartment_id']),
        'checkin_date' => $jetbooking_data['checkin'],
        'checkout_date' => $jetbooking_data['checkout'],
        'pickup_datetime' => $jetbooking_data['checkin'] . ' 09:00:00',
        'passengers' => $jetbooking_data['guests'],
        'price' => $jetbooking_data['price'],
        'jetbooking_id' => $jetbooking_id,
    );
    
    $booking_data['booking_number'] = generate_booking_number();
    $wpdb->insert('wp_unified_bookings', $booking_data);
}
```

### **WooCommerce → Unified System**

```php
function sync_wc_payment($order_id) {
    $order = wc_get_order($order_id);
    
    // Find linked booking
    $booking_id = $order->get_meta('_unified_booking_id');
    
    if ($booking_id) {
        global $wpdb;
        
        // Update payment status
        $wpdb->update(
            'wp_unified_bookings',
            array(
                'payment_status' => 'paid',
                'wc_order_id' => $order_id,
            ),
            array('id' => $booking_id)
        );
        
        // Create payment record
        $wpdb->insert('wp_booking_payments', array(
            'booking_id' => $booking_id,
            'provider' => 'woocommerce',
            'transaction_id' => $order->get_transaction_id(),
            'amount' => $order->get_total(),
            'currency' => $order->get_currency(),
            'type' => 'charge',
            'status' => 'succeeded',
        ));
        
        // Send confirmation
        send_booking_confirmation($booking_id);
    }
}
```

### **Email Parser → Unified System**

```php
function parse_booking_email($email_body, $email_from, $email_subject) {
    // Extract booking details using regex/AI
    $parsed_data = extract_booking_data($email_body);
    
    if ($parsed_data) {
        global $wpdb;
        
        $booking_data = array(
            'source' => 'email',
            'booking_type' => 'transfer',
            'customer_name' => $parsed_data['customer_name'],
            'customer_email' => $parsed_data['customer_email'] ?: $email_from,
            'customer_phone' => $parsed_data['customer_phone'],
            'pickup_location' => $parsed_data['pickup'],
            'dropoff_location' => $parsed_data['dropoff'],
            'pickup_datetime' => $parsed_data['datetime'],
            'passengers' => $parsed_data['passengers'],
            'price' => $parsed_data['price'] ?: 0,
            'parsed_from_email' => true,
            'needs_review' => true, // Admin must review
            'status' => 'pending',
            'internal_notes' => "Parsed from email: $email_subject",
        );
        
        $booking_data['booking_number'] = generate_booking_number();
        $wpdb->insert('wp_unified_bookings', $booking_data);
        
        // Notify admin
        notify_admin_new_email_booking($wpdb->insert_id);
    }
}
```

---

## 🎯 **Unified Dashboard Features**

### **Booking List View**

**Filters:**
- Source (CHBS, JetBooking, Manual, Email)
- Status (Pending, Confirmed, etc.)
- Payment Status
- Date Range
- Driver
- Needs Review (for email bookings)

**Columns:**
- Booking #
- Source (with icon)
- Customer
- Type (Transfer/Tour)
- Date & Time
- Status
- Payment
- Driver
- Actions

**Quick Actions:**
- View Details
- Assign Driver
- Process Payment
- Send Notification
- Edit
- Cancel

---

### **Booking Detail View**

**Tabs:**

1. **Details**
   - All booking information
   - Edit button (syncs to source)
   - Source link (view in CHBS/JetBooking)

2. **Payments**
   - WooCommerce order link
   - Payment history
   - Charge/Refund buttons
   - Receipt download

3. **Driver**
   - Assign/unassign driver
   - Driver contact info
   - Send notification
   - View driver status

4. **Messages**
   - Email history
   - SMS history
   - Resend buttons
   - Delivery status

5. **Audit Log**
   - All changes
   - Sync events
   - User actions
   - System events

6. **Source Data**
   - Original booking data
   - Sync status
   - Last synced
   - Sync errors

---

## 🔄 **Sync Status Indicators**

**In Dashboard:**
```
✅ Synced with CHBS
✅ Synced with WooCommerce
⚠️ Sync pending
❌ Sync failed
🔄 Syncing...
```

**Sync Actions:**
- Manual sync button
- Auto-sync on save
- Sync error logs
- Retry failed syncs

---

## ✅ **Implementation Phases**

### **Phase 1: Core System** (Week 1)
- Database schema
- REST API endpoints
- Basic dashboard UI

### **Phase 2: CHBS Integration** (Week 1)
- Hook into CHBS events
- Two-way sync
- Test with Form 25108

### **Phase 3: JetBooking Integration** (Week 2)
- Hook into JetBooking
- Tour booking sync
- Test with tours

### **Phase 4: WooCommerce Integration** (Week 2)
- Payment sync
- Order creation
- Refund handling

### **Phase 5: Email Parser** (Week 3)
- IMAP connection
- Parsing logic
- Admin review interface

### **Phase 6: Dashboard Polish** (Week 3)
- Filters & search
- Bulk actions
- Export functionality

### **Phase 7: Testing & Launch** (Week 4)
- Integration testing
- Data migration
- Go live

---

## ✅ **Summary**

**This system will:**
✅ Keep CHBS for chauffeur bookings
✅ Keep JetBooking for tours
✅ Keep WooCommerce for payments
✅ Add email parser for external bookings
✅ Unify everything in one dashboard
✅ Sync all systems automatically
✅ Provide single source of truth

**Shall I start building this?** 🚀


