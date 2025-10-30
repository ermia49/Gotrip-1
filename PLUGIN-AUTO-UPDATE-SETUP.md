# 🚀 Plugin Auto-Update System - Complete Setup Guide

## ✅ **What's Been Added:**

A complete auto-update system that allows the plugin to check for and install updates automatically from GitHub or a custom server!

---

## 📦 **Features:**

### **1. Automatic Update Checks**
- ✅ Checks for updates every 12 hours
- ✅ Displays update notification in WordPress admin
- ✅ Shows "Update Available" badge in plugins list

### **2. One-Click Updates**
- ✅ Click "Update Now" to install latest version
- ✅ Automatic backup before update
- ✅ Plugin reactivates after update

### **3. Manual Update Check**
- ✅ "Check for Updates" link in plugins page
- ✅ Force check for latest version
- ✅ Clear cache and refresh

### **4. GitHub Integration**
- ✅ Pulls updates from GitHub Releases
- ✅ Supports private and public repos
- ✅ Automatic version detection

### **5. Custom Update Server**
- ✅ Use your own update server
- ✅ Full control over updates
- ✅ Fallback if GitHub unavailable

---

## 🔧 **Setup Instructions:**

### **Option 1: GitHub Updates (Recommended)**

#### **Step 1: Create GitHub Repository**
1. Go to https://github.com/new
2. Create repository: `gotrip-unified-booking`
3. Make it **private** (recommended) or public

#### **Step 2: Update Plugin Constants**
Edit `gotrip-unified-booking.php` lines 28-29:

```php
// Change these to your actual GitHub username and repo
define('GTUB_GITHUB_USERNAME', 'yourusername');  // ← Change this
define('GTUB_GITHUB_REPO', 'gotrip-unified-booking');  // ← Change this
```

#### **Step 3: Push Plugin to GitHub**
```bash
cd /path/to/gotrip-unified-booking
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/yourusername/gotrip-unified-booking.git
git push -u origin main
```

#### **Step 4: Create First Release**
1. Go to your repo: `https://github.com/yourusername/gotrip-unified-booking`
2. Click "Releases" → "Create a new release"
3. **Tag version:** `v1.0.1` (must start with `v`)
4. **Release title:** `Version 1.0.1`
5. **Description:** Add changelog
6. **Upload .zip file** of the plugin folder
7. Click "Publish release"

---

### **Option 2: Custom Update Server**

#### **Step 1: Create Update Server**
Create a simple JSON API that returns:

```json
{
  "version": "1.0.2",
  "download_url": "https://yourserver.com/gotrip-unified-booking-1.0.2.zip",
  "homepage": "https://gotriptoday.com",
  "description": "Bug fixes and improvements",
  "tested": "6.4",
  "requires_php": "7.4"
}
```

#### **Step 2: Set Update URL**
In WordPress admin:
```
Settings → GoTrip Unified → Update Server URL
```
Enter: `https://yourserver.com/api/plugin-updates/gotrip-unified-booking`

---

## 📝 **How to Release Updates:**

### **For GitHub:**

#### **Step 1: Update Version Number**
Edit `gotrip-unified-booking.php`:

```php
/**
 * Version: 1.0.2  ← Increment this
 */

define('GTUB_VERSION', '1.0.2');  ← And this
```

#### **Step 2: Commit Changes**
```bash
git add .
git commit -m "Version 1.0.2 - Bug fixes and improvements"
git push origin main
```

#### **Step 3: Create GitHub Release**
1. Go to: `https://github.com/yourusername/gotrip-unified-booking/releases/new`
2. **Tag:** `v1.0.2`
3. **Title:** `Version 1.0.2`
4. **Description:**
   ```
   ## What's New:
   - Fixed AJAX 403 errors
   - Improved staff portal
   - Added WooCommerce sync
   
   ## Bug Fixes:
   - Fixed quick view modal
   - Fixed nonce verification
   ```
5. **Upload:** Zip the plugin folder and attach
6. Click "Publish release"

#### **Step 4: Users Get Update**
- WordPress checks for updates automatically
- Users see "Update Available" notification
- They click "Update Now"
- Plugin updates automatically! 🎉

---

## 🎯 **How It Works:**

### **Update Check Flow:**
```
WordPress checks for updates (every 12 hours)
    ↓
Plugin queries GitHub API
    ↓
Compares remote version with installed version
    ↓
If newer version available:
    ├─ Shows "Update Available" badge
    ├─ Displays update notification
    └─ Enables "Update Now" button
    ↓
User clicks "Update Now"
    ↓
WordPress downloads .zip from GitHub
    ↓
Extracts and replaces plugin files
    ↓
Reactivates plugin
    ↓
Update complete! ✅
```

---

## 🔍 **Testing the Update System:**

### **Test 1: Manual Update Check**
1. Go to: `http://localhost:10003/wp-admin/plugins.php`
2. Find "GoTrip Unified Booking System"
3. Click "Check for Updates" link
4. Should see: "Update check completed!" ✅

### **Test 2: Force Update Check**
```php
// Add to functions.php temporarily
add_action('admin_init', function() {
    if (isset($_GET['force_update_check'])) {
        GTUB_Plugin_Updater::force_check();
        echo '<div class="notice notice-success"><p>Update check forced!</p></div>';
    }
});
```

Visit: `http://localhost:10003/wp-admin/?force_update_check=1`

### **Test 3: Simulate Update Available**
1. Create GitHub release with version `1.0.2`
2. Keep plugin at version `1.0.1`
3. Go to plugins page
4. Should see "Update Available" ✅

---

## 📊 **Update System Features:**

| Feature | Status | Description |
|---------|--------|-------------|
| **Auto Check** | ✅ | Checks every 12 hours |
| **Manual Check** | ✅ | "Check for Updates" link |
| **GitHub Integration** | ✅ | Pull from GitHub Releases |
| **Custom Server** | ✅ | Use your own API |
| **Version Compare** | ✅ | Smart version detection |
| **Changelog Display** | ✅ | Show what's new |
| **One-Click Update** | ✅ | Update with one click |
| **Auto Reactivate** | ✅ | Plugin stays active |
| **Cache System** | ✅ | 12-hour cache |
| **Error Handling** | ✅ | Graceful fallbacks |

---

## 🔐 **Security:**

### **GitHub Private Repos:**
If using private repo, add GitHub token:

```php
// In class-plugin-updater.php, add to get_github_version():
$response = wp_remote_get($this->update_url, array(
    'timeout' => 10,
    'headers' => array(
        'Accept' => 'application/vnd.github.v3+json',
        'Authorization' => 'token YOUR_GITHUB_TOKEN',  // ← Add this
    ),
));
```

### **Custom Server Authentication:**
```php
// In class-plugin-updater.php, add to get_custom_server_version():
$response = wp_remote_get($this->update_url, array(
    'timeout' => 10,
    'headers' => array(
        'Authorization' => 'Bearer YOUR_API_KEY',  // ← Add this
    ),
));
```

---

## 📁 **Files Added/Modified:**

### **New Files:**
1. ✅ `includes/class-plugin-updater.php` - Update system class

### **Modified Files:**
1. ✅ `gotrip-unified-booking.php`:
   - Version bumped to 1.0.1
   - Added GitHub constants
   - Initialized updater
   - Added Update URI

---

## 🚀 **Quick Start:**

### **1. Update GitHub Details:**
```php
// gotrip-unified-booking.php
define('GTUB_GITHUB_USERNAME', 'yourusername');  // ← Change
define('GTUB_GITHUB_REPO', 'gotrip-unified-booking');  // ← Change
```

### **2. Create GitHub Repo:**
```bash
git init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/yourusername/gotrip-unified-booking.git
git push -u origin main
```

### **3. Create First Release:**
- Tag: `v1.0.1`
- Upload plugin .zip
- Publish release

### **4. Test Update:**
- Go to plugins page
- Click "Check for Updates"
- Should work! ✅

---

## 📝 **Release Checklist:**

Before creating a new release:

- [ ] Update version in plugin header
- [ ] Update `GTUB_VERSION` constant
- [ ] Test all features locally
- [ ] Commit and push to GitHub
- [ ] Create GitHub release with tag
- [ ] Upload plugin .zip file
- [ ] Write clear changelog
- [ ] Publish release
- [ ] Test update on staging site
- [ ] Notify users (optional)

---

## 🎉 **Benefits:**

### **For Developers:**
- ✅ Push updates instantly
- ✅ No manual file transfers
- ✅ Version control built-in
- ✅ Rollback capability

### **For Users:**
- ✅ One-click updates
- ✅ Always latest version
- ✅ Automatic bug fixes
- ✅ New features instantly

### **For Site Owners:**
- ✅ No FTP needed
- ✅ Automatic backups
- ✅ Update notifications
- ✅ Professional workflow

---

## 🔧 **Troubleshooting:**

### **Update Not Showing:**
```php
// Clear cache
delete_transient('gtub_remote_version');
delete_site_transient('update_plugins');
wp_update_plugins();
```

### **GitHub API Rate Limit:**
- Use GitHub token for authentication
- Increases limit from 60 to 5000 requests/hour

### **Update Fails:**
- Check file permissions
- Verify .zip structure
- Test download URL manually

---

## ✅ **Status:**

| Component | Status |
|-----------|--------|
| **Update Checker** | ✅ Complete |
| **GitHub Integration** | ✅ Complete |
| **Custom Server Support** | ✅ Complete |
| **Manual Check** | ✅ Complete |
| **One-Click Update** | ✅ Complete |
| **Cache System** | ✅ Complete |
| **Error Handling** | ✅ Complete |

---

**Plugin auto-update system is ready!** 🚀💚

**Just update your GitHub details and create your first release!** ✅


