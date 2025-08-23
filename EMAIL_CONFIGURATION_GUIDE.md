# Email Configuration Guide for PHPMailer

This guide explains how to configure email settings for the PHPMailer integration in the RSS Health Services application.

## Environment Variables

Add these variables to your `.env` file:

```env
# Email Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="RSS Citi Health Services"
```

## Gmail Setup (Recommended for Testing)

### 1. Enable 2-Factor Authentication
- Go to your Google Account settings
- Enable 2-Factor Authentication

### 2. Generate App Password
- Go to Google Account → Security → App passwords
- Generate a new app password for "Mail"
- Use this password in `MAIL_PASSWORD`

### 3. Enable Less Secure Apps (Alternative)
- Go to Google Account → Security → Less secure app access
- Turn on access for less secure apps
- Use your regular Gmail password

## Other Email Providers

### Outlook/Hotmail
```env
MAIL_HOST=smtp-mail.outlook.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

### Yahoo Mail
```env
MAIL_HOST=smtp.mail.yahoo.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

### Custom SMTP Server
```env
MAIL_HOST=your-smtp-server.com
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

## Testing Email Configuration

1. **Set up environment variables** in your `.env` file
2. **Navigate to Admin → Pre-Employment** in the application
3. **Find a record with status "passed"**
4. **Click the envelope button** (📧) to send a test email
5. **Check the recipient's email** for the registration link

## Troubleshooting

### Common Issues:

#### 1. "Authentication failed"
- Check your username and password
- Ensure 2FA is enabled and app password is generated (for Gmail)
- Verify SMTP settings

#### 2. "Connection refused"
- Check if the port is correct (587 for TLS, 465 for SSL)
- Verify the SMTP host is correct
- Check firewall settings

#### 3. "Timeout error"
- Increase timeout in the controller
- Check network connectivity
- Verify SMTP server is accessible

### Debug Mode

To enable debug mode, uncomment this line in `AdminController.php`:

```php
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
```

This will show detailed SMTP communication in your logs.

## Security Notes

- **Never commit** your `.env` file to version control
- **Use app passwords** instead of regular passwords when possible
- **Enable 2FA** on your email accounts
- **Regularly rotate** app passwords
- **Monitor** email sending logs for suspicious activity

## Production Considerations

- Use a dedicated email service (SendGrid, Mailgun, etc.)
- Set up proper SPF, DKIM, and DMARC records
- Monitor email deliverability rates
- Implement rate limiting for email sending
- Set up email bounce handling
