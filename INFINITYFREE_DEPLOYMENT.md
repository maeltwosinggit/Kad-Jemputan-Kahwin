# InfinityFree Deployment Instructions

## Step 4: Upload Files to InfinityFree

### 4.1 Upload via File Manager or FTP

**Upload these files to your `htdocs` folder:**

1. **Main Project Files** (as usual):
   - `index.php`
   - `config.php`
   - `insert_message.php`
   - `process_rsvp.php`
   - All CSS, JS, images, etc.

2. **New Google Sheets Files**:
   - `google_sheets_config.php`
   - `google_sheets_helper.php`
   - `kad-jemputan-kahwin-477616-192dec6a27bc.json` ⚠️ **IMPORTANT**
   - `.htaccess` (for security)
   - `test_google_sheets.php` (temporary testing)

### 4.2 Security Note for InfinityFree

⚠️ **CRITICAL**: InfinityFree doesn't support placing files outside the web directory, so the `.htaccess` file is essential to protect your JSON key.

## Step 5: Testing on InfinityFree

### 5.1 Test File Upload
1. Go to: `https://yourdomain.infinityfreeapp.com/test_google_sheets.php`
2. Check that all files show "✅ EXISTS"
3. Look for "✅ Google Sheets connection initialized"

### 5.2 Test Integration
1. **Uncomment the test code** in `test_google_sheets.php`:
   - Remove the `/*` and `*/` around the test message code
   - Save and upload the file
   - Visit the test page again
   - Check your Google Sheet for the test message
   - **Re-comment the test code** after successful test

### 5.3 Test Real Submissions
1. Submit an RSVP through your website
2. Submit a message through your website
3. Check your Google Sheet tabs for the data

### 5.4 Clean Up
**Delete `test_google_sheets.php` after testing** for security.

## Step 6: Verify Google Sheet Structure

Make sure your Google Sheet has these exact tab names and headers:

### Tab 1: "RSVP Guests"
```
A1: ID
B1: Name  
C1: Total Pax
D1: Relationship
E1: Status
F1: Created At
```

### Tab 2: "Ucapan Kahwin"
```
A1: ID
B1: Guest Name
C1: Message
D1: Created At
```

## Step 7: Monitor and Troubleshoot

### Check InfinityFree Error Logs
1. Go to your InfinityFree control panel
2. Navigate to "Error Logs"
3. Look for any Google Sheets related errors

### Common InfinityFree Issues:

1. **cURL not enabled**: 
   - InfinityFree supports cURL, but if you get cURL errors, contact their support

2. **SSL Certificate errors**:
   - Add this to your `google_sheets_helper.php` if you get SSL errors:
   ```php
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
   ```

3. **File permissions**:
   - Make sure your JSON file has proper read permissions
   - InfinityFree usually handles this automatically

4. **Timeout issues**:
   - If requests timeout, the sync will fail silently
   - Your website will still work, just without Google Sheets sync

## Step 8: Production Monitoring

### Success Indicators:
- ✅ Website RSVP/messages work normally
- ✅ Data appears in Google Sheets within seconds
- ✅ No errors in InfinityFree error logs

### If Sync Fails:
- 🔧 Website continues working normally (fail-safe design)
- 🔧 Check error logs for specific issues
- 🔧 Verify JSON key file wasn't corrupted during upload
- 🔧 Confirm Google Sheet permissions are correct

## Step 9: Share with Client

Once everything is working:

1. **Share the Google Sheet** with your client:
   - Give them "Viewer" or "Editor" access
   - They can now see real-time RSVP and message data

2. **Show them the features**:
   - Real-time updates
   - Separate tabs for RSVP vs Messages
   - Export capabilities
   - Filtering and sorting options

## Security Reminders:

⚠️ **Never share your JSON key file**
⚠️ **Don't commit JSON key to GitHub**
⚠️ **Keep `.htaccess` file to protect JSON**
⚠️ **Delete test files after use**

Your Google Sheets integration is now ready for production! 🎉