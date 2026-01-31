# 🔒 Production Security Checklist

## ⚠️ CRITICAL - Must Do Before Going Live

### Environment Configuration (.env)
```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=[Generate with: php artisan key:generate]
APP_URL=https://yourdomain.com

# Database - Use strong credentials
DB_PASSWORD=[Strong password, min 16 characters]

# Session Security
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
```

### File Permissions
```bash
# Set correct permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Protect sensitive files
chmod 600 .env
chmod 644 composer.json composer.lock
```

### Security Headers (Already Implemented ✓)
- X-Frame-Options: SAMEORIGIN
- X-Content-Type-Options: nosniff
- X-XSS-Protection: 1; mode=block
- Content-Security-Policy: Configured
- Referrer-Policy: strict-origin-when-cross-origin

### Rate Limiting (Already Implemented ✓)
- Admin Login: 5 attempts/minute
- Contact Form: 3 submissions/minute
- Checkout: 10 orders/minute

## 🛡️ IMPORTANT - Highly Recommended

### HTTPS/SSL
```apache
# Force HTTPS in .htaccess
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### Database Security
- Create dedicated database user with minimal privileges
- Use prepared statements only (Laravel Eloquent does this ✓)
- Regular backups (daily recommended)

### File Upload Security
- Validate file types and sizes (Already implemented ✓)
- Store uploads outside public directory
- Scan uploads for malware (consider ClamAV)

### Admin Panel Protection
- Use strong passwords (min 12 characters)
- Consider IP whitelisting for admin routes
- Enable 2FA (future enhancement)
- Monitor failed login attempts

## ✅ GOOD TO HAVE

### Monitoring & Logging
```env
LOG_CHANNEL=stack
LOG_LEVEL=error
```

### Regular Maintenance
- Update Laravel and dependencies monthly
- Review security advisories
- Test backups regularly
- Monitor server logs

### Additional Headers
```php
// In SecurityHeaders middleware (already added)
Strict-Transport-Security: max-age=31536000
```

## 🚫 NEVER DO

- ❌ Commit .env file to version control
- ❌ Use default passwords
- ❌ Disable CSRF protection
- ❌ Run with APP_DEBUG=true in production
- ❌ Use root database user
- ❌ Expose phpinfo() or debug endpoints

## 📋 Pre-Launch Verification

Run these commands before going live:

```bash
# Clear and optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Verify .env settings
php artisan config:show

# Test database connection
php artisan migrate:status
```

## 🔐 Password Requirements

**Admin Accounts:**
- Minimum 12 characters
- Mix of uppercase, lowercase, numbers, symbols
- Change every 90 days
- No password reuse

**Database:**
- Minimum 16 characters
- Randomly generated
- Store securely (password manager)

## 📞 Security Incident Response

If you suspect a breach:
1. Take site offline immediately
2. Change all passwords
3. Review access logs
4. Restore from clean backup
5. Investigate root cause
6. Notify affected users if data compromised

---

**Security Status:** ✅ Basic protections implemented
**Next Steps:** Configure HTTPS, set production .env, test rate limiting
