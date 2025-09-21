# cPanel Deployment Checklist

## Pre-Upload Preparation ✅

### Files to Upload:
- [ ] index.html (main file with all features)
- [ ] index-static.html (backup static version)
- [x] server.js (Node.js server) - REMOVED
- [x] puppeteer-client.js (Puppeteer client) - REMOVED
- [x] package.json (Node.js dependencies) - REMOVED
- [ ] .htaccess (Apache configuration)
- [ ] All image files:
  - [ ] MR.jpg (Money Receipt template)
  - [ ] cheque.jpg (Cheque template)
  - [ ] wbb.png (Transaction template)
  - [ ] bima2.png (Insurance template)
  - [ ] stamp.JPG (Stamp template)
  - [ ] idc.png (ID Card template)
  - [ ] Any other image files

## cPanel Deployment Steps

### Option 1: Full Node.js Deployment (Recommended)
1. [ ] Upload all files to public_html
2. [ ] Open cPanel Terminal
3. [ ] Run: `cd public_html && npm install`
4. [ ] Go to "Node.js Selector" in cPanel
5. [ ] Create Node.js app:
   - App Root: public_html
   - App URL: yourdomain.com
   - Startup File: server.js
6. [ ] Start the application
7. [ ] Test: http://yourdomain.com/health

### Option 2: Static Hosting (Backup)
1. [x] Upload only static files (no server.js, puppeteer-client.js) - DONE
2. [ ] Rename index-static.html to index.html
3. [ ] Test: http://yourdomain.com

## Post-Deployment Testing

### Test All Features:
- [ ] Money Receipt form works
- [ ] PNG download works
- [ ] All input fields update correctly
- [ ] Images display properly
- [ ] Responsive design works on mobile

### If Node.js Deployment Fails:
- [x] Use static version (index-static.html) - DONE
- [x] Remove Puppeteer buttons from main index.html - DONE
- [x] Test html2canvas functionality only - REPLACED WITH HTML DOWNLOAD

## Troubleshooting

### Common Issues:
- [ ] File permissions (644 for files, 755 for directories)
- [ ] Node.js version compatibility
- [ ] Puppeteer not supported on server
- [ ] Missing image files
- [ ] .htaccess configuration

### Fallback Plan:
- [ ] Use static version if Node.js fails
- [ ] Contact hosting provider for Node.js support
- [ ] Consider VPS hosting for full control

## Files Created for Deployment:
- ✅ package.json (Node.js dependencies)
- ✅ .htaccess (Apache configuration)
- ✅ index-static.html (Static backup version)
- ✅ deploy-instructions.md (Detailed instructions)
- ✅ DEPLOYMENT_CHECKLIST.md (This checklist)
