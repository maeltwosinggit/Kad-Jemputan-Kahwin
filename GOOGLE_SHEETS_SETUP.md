# Google Sheets Integration Setup Guide

## Step 1: Google Cloud Console Setup

1. **Go to Google Cloud Console**: https://console.cloud.google.com/
2. **Create a new project** (or select existing one):
   - Click "Select a project" → "New Project"
   - Name it: "Wedding RSVP Sync"
   - Click "Create"

3. **Enable Google Sheets API**:
   - Go to "APIs & Services" → "Library"
   - Search for "Google Sheets API"
   - Click on it and click "Enable"

4. **Create Service Account**:
   - Go to "APIs & Services" → "Credentials"
   - Click "Create Credentials" → "Service Account"
   - Service account name: `wedding-sheet-sync`
   - Click "Create and Continue"
   - Skip roles (click "Continue")
   - Click "Done"

5. **Generate Key**:
   - Click on the created service account
   - Go to "Keys" tab
   - Click "Add Key" → "Create new key"
   - Choose "JSON" format
   - Click "Create"
   - **IMPORTANT**: Download and save this JSON file securely

## Step 2: Google Sheet Setup

1. **Create Google Sheet**:
   - Go to https://sheets.google.com/
   - Create a new spreadsheet
   - Name it: "Wedding RSVP & Messages - [Couple Names]"

2. **Create Two Tabs**:
   - Rename "Sheet1" to: `RSVP Guests`
   - Add another tab named: `Ucapan Kahwin`

3. **Set Headers**:
   
   **RSVP Guests tab (A1:F1)**:
   ```
   ID | Name | Total Pax | Relationship | Status | Created At
   ```
   
   **Ucapan Kahwin tab (A1:D1)**:
   ```
   ID | Guest Name | Message | Created At
   ```

4. **Share Sheet with Service Account**:
   - Click "Share" button in your Google Sheet
   - Copy the email address from your downloaded JSON file (client_email field)
   - Paste it in the share dialog
   - Set permission to "Editor"
   - **Uncheck** "Notify people"
   - Click "Share"

5. **Get Sheet ID**:
   - From your sheet URL: `https://docs.google.com/spreadsheets/d/SHEET_ID_HERE/edit`
   - Copy the SHEET_ID_HERE part

## Step 3: Configure Your Website

1. **Upload Service Account Key**:
   - Upload your downloaded JSON file to your server
   - Place it in your project root directory
   - **SECURITY**: Make sure this file is NOT accessible via web browser
   - Consider placing it outside your web root or use .htaccess to block access

2. **Update Configuration**:
   - Edit `google_sheets_config.php`
   - Replace `'path/to/your/service-account-key.json'` with actual path
   - Replace `'YOUR_GOOGLE_SHEET_ID_HERE'` with your sheet ID

3. **Example Configuration**:
   ```php
   // Service Account JSON key file path
   $google_service_account_file = 'wedding-sheet-sync-key.json';
   
   // Your Google Sheet ID
   $google_sheet_id = '1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms';
   ```

## Step 4: Security Setup

1. **Protect JSON Key File**:
   Create `.htaccess` file in your project root:
   ```apache
   <Files "*.json">
       Order allow,deny
       Deny from all
   </Files>
   ```

2. **Or move JSON outside web directory**:
   ```php
   $google_service_account_file = '../keys/wedding-sheet-sync-key.json';
   ```

## Step 5: Testing

1. **Test RSVP Submission**:
   - Submit an RSVP through your website
   - Check if data appears in "RSVP Guests" tab

2. **Test Message Submission**:
   - Send a message through your website
   - Check if data appears in "Ucapan Kahwin" tab

3. **Check Error Logs**:
   - If sync fails, check your server error logs
   - Common issues: wrong file path, permissions, invalid sheet ID

## Troubleshooting

**If sync doesn't work**:
1. Check that JSON file path is correct
2. Verify Sheet ID is correct
3. Ensure service account email has edit access to sheet
4. Check server error logs for detailed error messages
5. Verify Google Sheets API is enabled

**Common Errors**:
- `Service account file not found`: Check file path in config
- `Insufficient permission`: Make sure service account has Editor access
- `Invalid sheet ID`: Double-check the ID from URL
- `API not enabled`: Enable Google Sheets API in Google Cloud Console

## Features

✅ **Automatic Sync**: All RSVP and message submissions automatically sync to Google Sheets
✅ **Fail-Safe**: If Google Sheets is down, your website still works normally
✅ **Real-time Data**: Data appears in sheets immediately after submission
✅ **Separate Tabs**: RSVP and messages are organized in different tabs
✅ **Timestamps**: All entries include creation timestamps

## Sheet Columns Explained

**RSVP Guests**:
- ID: Database record ID
- Name: Guest's full name
- Total Pax: Number of people attending
- Relationship: How they know the couple
- Status: "hadir" (attending) or "tidak_hadir" (not attending)
- Created At: When RSVP was submitted

**Ucapan Kahwin**:
- ID: Database record ID
- Guest Name: Name of person sending message
- Message: Their wishes/message
- Created At: When message was sent

Your client can now access real-time RSVP and message data directly in Google Sheets!