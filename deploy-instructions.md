# cPanel Node.js Deployment Instructions

## Prerequisites
- cPanel hosting with Node.js support
- Access to Terminal/SSH in cPanel
- Node.js version 14+ installed on server

## Step 1: Upload Files
1. Upload all files to your cPanel public_html directory
2. Make sure these files are included:
   - index.html
   - server.js (REMOVED)
   - puppeteer-client.js (REMOVED)
   - package.json (REMOVED)
   - .htaccess
   - All image files (MR.jpg, cheque.jpg, wbb.png, etc.)

## Step 2: Install Dependencies
1. Open Terminal in cPanel
2. Navigate to your domain directory:
   ```bash
   cd public_html
   ```
3. Install Node.js dependencies:
   ```bash
   npm install
   ```

## Step 3: Configure Node.js App
1. In cPanel, go to "Node.js Selector"
2. Create a new Node.js app:
   - App Root: public_html
   - App URL: yourdomain.com (or subdomain)
   - App Startup File: server.js
3. Set Environment Variables (if needed):
   - NODE_ENV=production
   - PORT=3001

## Step 4: Start the Application
1. In Node.js Selector, click "Start App"
2. Check if the app is running
3. Test the endpoints:
   - http://yourdomain.com/health
   - http://yourdomain.com/

## Step 5: Configure .htaccess (if needed)
If you have issues with routing, update .htaccess:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ /index.html [QSA,L]
```

## Troubleshooting
- Check Node.js logs in cPanel
- Ensure all file permissions are correct (644 for files, 755 for directories)
- Verify Puppeteer can run on the server
- Check if the server supports headless Chrome

## Alternative: Static Hosting
If Node.js deployment fails, you can use the static version:
1. ✅ Remove server.js and puppeteer-client.js - DONE
2. ✅ Use only HTML download instead of PNG generation - DONE
3. ✅ Update index.html to remove Puppeteer buttons - DONE
