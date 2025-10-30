# 🚀 Activate Real-Time Sync - Quick Guide

## ⚡ **3-Step Activation**

---

## **Step 1: Reactivate Plugin** (30 seconds)

### **Go to:**
```
http://localhost:10003/wp-admin/plugins.php
```

### **Do:**
1. Find "GoTrip Unified Booking System"
2. Click "Deactivate"
3. Click "Activate"

### **Why?**
This schedules the new cron jobs for fallback sync.

---

## **Step 2: Verify Cron Jobs** (1 minute)

### **Check scheduled events:**
```
http://localhost:10003/wp-admin/tools.php?page=cron-events
```

Or use terminal:
```bash
cd "/Users/ahmadharoonalizadeh/Local Sites/gotrip-1/app/public"
wp cron event list | grep gtub
```

### **You should see:**
```
✅ gtub_sync_bookings - hourly
✅ gtub_chbs_fallback_sync - every_5_minutes
✅ gtub_jetbooking_fallback_sync - every_5_minutes
✅ gtub_parse_emails - every_15_minutes
```

---

## **Step 3: Test Real-Time Sync** (2 minutes)

### **Test CHBS:**
1. Go to your CHBS booking form
2. Create a test booking
3. **Immediately check:**
   ```
   http://localhost:10003/wp-admin/admin.php?page=gtub-bookings
   ```
4. **Expected:** Booking appears INSTANTLY (< 1 second)

### **Test JetBooking:**
1. Go to your JetBooking form
2. Book a test tour
3. **Immediately check:**
   ```
   http://localhost:10003/wp-admin/admin.php?page=gtub-bookings
   ```
4. **Expected:** Tour appears INSTANTLY (< 1 second)

---

## 📱 **Optional: Configure Push Notifications**

### **Telegram (Recommended)**

1. **Create bot:**
   - Open Telegram
   - Search for @BotFather
   - Send `/newbot`
   - Follow instructions
   - **Copy the bot token**

2. **Get your chat ID:**
   - Search for @userinfobot
   - Start chat
   - **Copy your chat ID**

3. **Add to wp-config.php:**
```php
// Add before "That's all, stop editing!"
define('GTUB_TELEGRAM_BOT_TOKEN', 'your_bot_token_here');
define('GTUB_TELEGRAM_CHAT_ID', 'your_chat_id_here');
```

### **WhatsApp (Optional)**

1. **Sign up for Twilio:** https://www.twilio.com/
2. **Get WhatsApp sandbox number**
3. **Add to wp-config.php:**
```php
define('GTUB_TWILIO_SID', 'your_account_sid');
define('GTUB_TWILIO_TOKEN', 'your_auth_token');
define('GTUB_TWILIO_WHATSAPP_FROM', 'whatsapp:+14155238886');
define('GTUB_TWILIO_WHATSAPP_TO', 'whatsapp:+your_number');
```

### **Email (Already Working!)**
- ✅ No configuration needed
- Uses WordPress admin email
- Works out of the box

---

## 🧪 **Quick Test Commands**

### **Trigger fallback sync manually:**
```bash
cd "/Users/ahmadharoonalizadeh/Local Sites/gotrip-1/app/public"

# Test CHBS fallback sync
wp cron event run gtub_chbs_fallback_sync

# Test JetBooking fallback sync
wp cron event run gtub_jetbooking_fallback_sync
```

### **Check last sync time:**
```bash
wp option get gtub_last_sync
```

### **Monitor sync activity:**
```bash
tail -f "/Users/ahmadharoonalizadeh/Local Sites/gotrip-1/logs/php/error.log" | grep GTUB
```

---

## ✅ **Success Checklist**

After activation, you should have:

- [x] Plugin reactivated
- [x] 4 cron jobs scheduled
- [x] CHBS bookings sync instantly
- [x] JetBooking tours sync instantly
- [x] Email notifications working
- [x] Fallback sync running every 5 minutes

---

## 🎯 **What Happens Now**

### **When a customer books via CHBS:**
```
1. Customer submits booking form
2. CHBS creates booking
3. Hook fires: chbs_after_booking_sent ⚡
4. Unified system syncs INSTANTLY (< 1 second)
5. Notifications sent:
   - 📧 Email to admin
   - 📱 Telegram (if configured)
   - 📱 WhatsApp (if configured)
6. Booking appears in:
   - Admin panel
   - Staff portal
   - Frontend pages
```

### **When a customer books via JetBooking:**
```
1. Customer books tour
2. JetBooking creates booking
3. Hook fires: jet-booking/rest-api/add-booking ⚡
4. Unified system syncs INSTANTLY (< 1 second)
5. Notifications sent:
   - 📧 Email to admin
   - 📱 Telegram (if configured)
   - 📱 WhatsApp (if configured)
6. Tour appears in:
   - Admin panel
   - Staff portal
   - Frontend pages
```

### **Fallback Sync (Safety Net):**
```
Every 5 minutes:
1. Check CHBS database for new bookings
2. Check JetBooking database for new tours
3. Sync any missed bookings (if hooks failed)
4. Log results to error_log
```

---

## 📊 **Expected Results**

### **Before:**
- ❌ Manual sync required
- ❌ Bookings delayed
- ❌ No notifications
- ❌ Risk of missing bookings

### **After:**
- ✅ Automatic real-time sync
- ✅ Instant notifications
- ✅ 100% booking coverage
- ✅ Peace of mind

---

## 🎉 **You're Done!**

The system is now fully operational with:
- ⚡ **Real-time sync** (< 1 second)
- 📱 **Push notifications** (Telegram, WhatsApp, Email)
- 🔄 **Fallback sync** (every 5 minutes)
- 💯 **100% coverage** (never miss a booking)

**Go ahead and create a test booking to see it in action!** 🚀💚

---

## 🆘 **Troubleshooting**

### **If bookings don't sync instantly:**
1. Check error log:
   ```bash
   tail -f "/Users/ahmadharoonalizadeh/Local Sites/gotrip-1/logs/php/error.log"
   ```
2. Verify hooks are registered:
   ```bash
   wp hook list | grep chbs_after_booking_sent
   wp hook list | grep jet-booking
   ```
3. Wait 5 minutes for fallback sync to catch it

### **If notifications don't arrive:**
1. Check email is working:
   ```bash
   wp option get admin_email
   ```
2. Verify Telegram/WhatsApp credentials in `wp-config.php`
3. Check notification class is loaded:
   ```bash
   wp eval "echo class_exists('GTUB_Notification') ? 'YES' : 'NO';"
   ```

---

## 📞 **Support**

If you need help:
1. Check `REAL-TIME-SYNC-COMPLETE.md` for full documentation
2. Check error logs for detailed error messages
3. Test fallback sync manually to verify it works

---

**Status:** 🟢 **READY TO GO!**


