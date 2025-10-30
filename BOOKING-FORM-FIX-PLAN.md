# 🔧 Booking Form - Complete Fix Plan

## 🎯 **What Needs to Happen**

When user selects a booking system, show the appropriate form:

### **1. CHBS System (Chauffeur)**
```
Show:
- Trip type (one-way/round-trip/hourly)
- Pickup/Dropoff locations
- Date & Time
- Vehicle selection (from 'cars' CPT)
- Passengers & Luggage

Calculate:
- Use CHBS pricing engine
- Distance-based calculation
- Vehicle type pricing

Book:
- Create GTBM booking
- Create CHBS booking entry
- Link both systems
```

### **2. JetBooking System (DayTrip/Tours)**
```
Show:
- Tour/Activity selection (from JetBooking CPT)
- Check-in / Check-out dates
- Number of guests
- JetBooking-specific fields

Calculate:
- Use JetBooking pricing
- Per-night or per-person pricing
- Availability check

Book:
- Create GTBM booking
- Create JetBooking entry
- Link both systems
```

### **3. Manual System**
```
Show:
- Basic fields
- Manual price entry
- Custom notes

Calculate:
- Admin enters price manually
- No automatic calculation

Book:
- Create GTBM booking only
- No external system link
```

---

## 🔄 **How It Should Work**

### **User Flow:**

1. **Admin goes to Add New Booking**
   ```
   http://localhost:10003/wp-admin/post-new.php?post_type=gtbm_booking
   ```

2. **Sees 3 tabs:**
   ```
   [CHBS] [JetBooking] [Manual]
   ```

3. **Clicks CHBS:**
   - Form shows: Pickup/Dropoff, Vehicle, etc.
   - Calculate button uses CHBS API
   - Confirm creates both GTBM + CHBS bookings

4. **Clicks JetBooking:**
   - Form shows: Tour selection, Dates, Guests
   - Calculate button uses JetBooking API
   - Confirm creates both GTBM + JetBooking bookings

5. **Clicks Manual:**
   - Form shows: Basic fields
   - Admin enters price manually
   - Confirm creates GTBM booking only

---

## 🛠️ **Technical Implementation**

### **Frontend (JavaScript):**

```javascript
// When system tab is clicked
$('.gtbm-system-tab').on('click', function() {
    var system = $(this).data('system');
    
    // Hide all system-specific sections
    $('.gtbm-chbs-fields').hide();
    $('.gtbm-jetbooking-fields').hide();
    $('.gtbm-manual-fields').hide();
    
    // Show selected system fields
    if (system === 'chbs') {
        $('.gtbm-chbs-fields').show();
    } else if (system === 'daytrip') {
        $('.gtbm-jetbooking-fields').show();
    } else if (system === 'manual') {
        $('.gtbm-manual-fields').show();
    }
    
    // Update hidden field
    $('#booking_system').val(system);
});
```

### **Backend (PHP):**

```php
// CHBS Price Calculation
public static function ajax_calculate_chbs_price() {
    // Get CHBS pricing
    $price = GTBM_CHBS_Integration::calculate_price($data);
    wp_send_json_success($price);
}

// JetBooking Price Calculation
public static function ajax_calculate_jetbooking_price() {
    // Get JetBooking pricing
    $price = GTBM_JetBooking_Integration::calculate_price($data);
    wp_send_json_success($price);
}

// Manual Price (no calculation)
public static function ajax_calculate_manual_price() {
    // Just return what admin entered
    wp_send_json_success(array(
        'total' => $_POST['manual_price'],
        'currency' => 'EUR'
    ));
}
```

---

## 📋 **Required Files**

### **New Integration File:**
```
includes/integrations/class-jetbooking-integration.php
```

**Functions needed:**
- `is_jetbooking_active()` - Check if plugin active
- `get_available_tours()` - Get tours/activities
- `calculate_price()` - Calculate tour price
- `create_jetbooking_entry()` - Create booking
- `sync_jetbooking_to_gtbm()` - Sync existing bookings

---

## 🎨 **Form Structure**

```html
<!-- System Selector (Always Visible) -->
<div class="gtbm-system-selector">
    [CHBS] [JetBooking] [Manual]
</div>

<!-- Customer Info (Always Visible) -->
<div class="gtbm-customer-section">
    Name, Email, Phone
</div>

<!-- CHBS Fields (Show when CHBS selected) -->
<div class="gtbm-chbs-fields" style="display:none;">
    - Trip Type
    - Pickup/Dropoff
    - Date/Time
    - Vehicle
    - Passengers
</div>

<!-- JetBooking Fields (Show when JetBooking selected) -->
<div class="gtbm-jetbooking-fields" style="display:none;">
    - Tour/Activity Selection
    - Check-in Date
    - Check-out Date
    - Number of Guests
    - Special Requests
</div>

<!-- Manual Fields (Show when Manual selected) -->
<div class="gtbm-manual-fields" style="display:none;">
    - Service Description
    - Manual Price Entry
    - Custom Notes
</div>

<!-- Price Calculation (Always Visible) -->
<div class="gtbm-price-section">
    [Calculate Price] button
    Price breakdown display
</div>

<!-- Actions (Always Visible) -->
<div class="gtbm-actions">
    [Save Draft] [Confirm] [Create WC Order]
</div>
```

---

## ✅ **Implementation Steps**

### **Step 1: Create JetBooking Integration** (30 min)
- Create `class-jetbooking-integration.php`
- Add functions to interact with JetBooking
- Test price calculation
- Test booking creation

### **Step 2: Update Booking Form** (45 min)
- Add JetBooking fields section
- Add JavaScript to show/hide sections
- Update AJAX handlers
- Fix CHBS price calculation
- Add proper validation

### **Step 3: Fix Critical Issues** (30 min)
- Fix WooCommerce product creation
- Add jQuery UI CSS
- Add server-side validation
- Add error logging
- Format emails as HTML

### **Step 4: Testing** (30 min)
- Test CHBS booking flow
- Test JetBooking flow
- Test Manual flow
- Test price calculations
- Test email sending
- Test WC order creation

**Total Time: ~2.5 hours**

---

## 🚀 **Shall I Proceed?**

I will:

1. ✅ Create JetBooking integration class
2. ✅ Update booking form with all 3 systems
3. ✅ Fix all critical issues from audit
4. ✅ Add proper show/hide logic
5. ✅ Test everything

**Ready to start?** 🔧


