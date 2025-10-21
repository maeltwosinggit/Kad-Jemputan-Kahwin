# 💒 Wedding Invitation - Name Configuration Guide

## ✨ Quick Setup

To change the bride and groom names, edit the **`config.php`** file:

```php
// BRIDE & GROOM NAMES
$Lelaki_Long = "Amirul Masri";          // Full name of the groom
$Lelaki_Short = "Amirul";               // Short name of the groom  
$Perempuan_Long = "Pasangan Dot";       // Full name of the bride
$Perempuan_Short = "Pasangan";          // Short name of the bride
```

## 📍 Where Names Appear

### **$Lelaki_Short** (Groom Short Name):
- Browser title: "Amirul & Pasangan"
- Main overlay button: "Amirul"

### **$Lelaki_Long** (Groom Full Name):
- Main intro section: "Amirul Masri"
- Formal invitation: "Amirul Masri"

### **$Perempuan_Short** (Bride Short Name):
- Browser title: "Amirul & Pasangan"  
- Main overlay button: "Pasangan"
- Main intro section: "Pasangan"

### **$Perempuan_Long** (Bride Full Name):
- Formal invitation: "Pasangan Dot"

## 🎨 Other Customizations Available

You can also customize:
- **Wedding Date & Time**
  - `$Wedding_Date_Malay` - Day name in Malay (e.g., "Jumaat")
  - `$Wedding_Date_Full` - Full date in Malay (e.g., "12 Disember 2025")  
  - `$Wedding_Date_ISO` - Date for countdown (YYYY-MM-DD format, e.g., "2025-12-12")
  - `$Wedding_Time` - Time range (e.g., "11:00 AM - 4:00 PM")
- **Venue Address** 
- **Parents Names**

## 🔄 After Making Changes

1. Save `config.php`
2. Run `sync_changes.bat`
3. Refresh browser at `http://localhost/kad-kahwin`

## 📝 Example Configuration

```php
$Lelaki_Long = "Ahmad Faizal Bin Abdullah";
$Lelaki_Short = "Faizal";
$Perempuan_Long = "Siti Nurhaliza Binti Tarudin";
$Perempuan_Short = "Siti";
```

**Result:** 
- Title: "Faizal & Siti"
- Main intro: "Ahmad Faizal Bin Abdullah & Siti" 
- Formal: "Ahmad Faizal Bin Abdullah & Siti Nurhaliza Binti Tarudin"