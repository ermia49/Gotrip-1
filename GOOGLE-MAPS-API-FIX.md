# 🔧 Google Maps API - Fix Required

## ❌ **Current Issue**

Google Maps showing error: **"Oops! Something went wrong"**

This means the API key is not properly configured in CHBS.

---

## ✅ **Solution: Add API Key to CHBS Settings**

### **Step 1: Go to CHBS Settings**

1. **Navigate to:** WordPress Admin → CHBS → Settings
2. **Or direct URL:** `http://localhost:10003/wp-admin/admin.php?page=chbs_settings`

### **Step 2: Find Google Maps API Section**

Look for:
- **Google Maps API Key** field
- Usually in "General Settings" or "Google Maps" tab

### **Step 3: Enter Your API Key**

```
AIzaSyAgPQ5BlNhRHUKHlq04UInbGuzOiJcTTw0
```

### **Step 4: Enter Your Map ID**

```
9ea9dad1d4ba8c0a6c28f08e
```

### **Step 5: Save Settings**

Click **"Save Changes"** button

---

## 🔑 **Google Cloud Console Setup**

### **Required APIs to Enable:**

1. **Go to:** https://console.cloud.google.com/apis/library

2. **Enable these APIs:**
   - ✅ Maps JavaScript API
   - ✅ Places API
   - ✅ Distance Matrix API
   - ✅ Geocoding API
   - ✅ Directions API

### **API Key Restrictions:**

1. **Go to:** https://console.cloud.google.com/apis/credentials

2. **Click on your API key**

3. **Application restrictions:**
   - Select: **HTTP referrers (web sites)**
   - Add referrers:
     ```
     http://localhost:10003/*
     localhost:10003/*
     *.local/*
     http://localhost/*
     ```

4. **API restrictions:**
   - Select: **Restrict key**
   - Select these APIs:
     - Maps JavaScript API
     - Places API
     - Distance Matrix API
     - Geocoding API
     - Directions API

5. **Click "Save"**

---

## 🔧 **Alternative: Add API Key via Code**

If CHBS settings don't work, add this to your theme's `functions.php`:

```php
// Add Google Maps API key for CHBS
add_filter('chbs_google_maps_api_key', function() {
    return 'AIzaSyAgPQ5BlNhRHUKHlq04UInbGuzOiJcTTw0';
});

// Add Map ID
add_filter('chbs_google_maps_map_id', function() {
    return '9ea9dad1d4ba8c0a6c28f08e';
});
```

**File location:**
```
/wp-content/themes/gotriptoday/functions.php
```

---

## 🔍 **Check API Key Status**

### **Test in Browser Console:**

1. Open the booking page
2. Press **F12** (Developer Tools)
3. Go to **Console** tab
4. Look for errors like:
   - "Google Maps JavaScript API error: RefererNotAllowedMapError"
   - "Google Maps JavaScript API error: ApiNotActivatedMapError"
   - "Google Maps JavaScript API error: InvalidKeyMapError"

### **Common Errors:**

**Error: RefererNotAllowedMapError**
- **Fix:** Add `localhost:10003` to API key referrer restrictions

**Error: ApiNotActivatedMapError**
- **Fix:** Enable Maps JavaScript API in Google Cloud Console

**Error: InvalidKeyMapError**
- **Fix:** Check API key is correct

**Error: RequestDenied**
- **Fix:** Enable billing in Google Cloud Console

---

## 💳 **Billing Account**

Google Maps requires a billing account (even for free tier):

1. **Go to:** https://console.cloud.google.com/billing
2. **Create billing account** (if not exists)
3. **Link to your project**
4. **Free tier includes:**
   - $200 free credit per month
   - 28,000 map loads per month
   - Enough for most small businesses

---

## 🔧 **Quick Fix Steps**

### **Option 1: CHBS Settings (Recommended)**

```
1. Go to: WP Admin → CHBS → Settings
2. Find: Google Maps API Key field
3. Enter: AIzaSyAgPQ5BlNhRHUKHlq04UInbGuzOiJcTTw0
4. Enter Map ID: 9ea9dad1d4ba8c0a6c28f08e
5. Save
6. Refresh booking page
```

### **Option 2: Add to functions.php**

```php
add_filter('chbs_google_maps_api_key', function() {
    return 'AIzaSyAgPQ5BlNhRHUKHlq04UInbGuzOiJcTTw0';
});
```

### **Option 3: Check Google Cloud Console**

```
1. Enable required APIs
2. Add localhost to referrers
3. Enable billing account
4. Save and wait 5 minutes
```

---

## ✅ **Verification**

After fixing, you should see:

✅ **Map loads correctly**
✅ **Autocomplete works in location fields**
✅ **No error messages**
✅ **Distance calculation works**

---

## 📋 **Checklist**

- [ ] API key added to CHBS settings
- [ ] Map ID added to CHBS settings
- [ ] Maps JavaScript API enabled
- [ ] Places API enabled
- [ ] Distance Matrix API enabled
- [ ] Billing account linked
- [ ] Referrer restrictions set
- [ ] API restrictions set
- [ ] Saved and waited 5 minutes
- [ ] Cleared browser cache
- [ ] Tested booking page

---

## 🆘 **Still Not Working?**

### **Check CHBS Documentation:**
- Look for "Google Maps Setup" section
- Check required API key format
- Check if CHBS has specific requirements

### **Check Browser Console:**
- Press F12
- Look for specific error messages
- Share error message for further help

### **Contact Support:**
- CHBS support might have specific instructions
- Google Cloud support for API issues

---

## 💡 **Most Common Fix**

**90% of the time, the issue is:**
1. API key not added to CHBS settings
2. Billing not enabled in Google Cloud
3. Required APIs not enabled

**Try these first!**

---

## 🎯 **Next Steps**

1. **Go to CHBS Settings NOW**
2. **Add the API key**
3. **Save**
4. **Refresh booking page**
5. **Test if map loads**

**If still not working, check browser console for specific error!**


