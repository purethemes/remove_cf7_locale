# Remove CF7 Locale Meta

A lightweight WordPress plugin to remove incorrect "_locale" meta fields from Contact Form 7 forms.

![WordPress Version](https://img.shields.io/badge/wordpress-5.0%2B-blue)
![CF7 Version](https://img.shields.io/badge/CF7-5.0%2B-green)
![License](https://img.shields.io/badge/license-GPL--2.0%2B-red)

## 🔍 The Problem

Contact Form 7 sometimes creates forms with incorrect "_locale" meta keys set to the wrong language. This can cause localization issues and problems with multi-language sites.

## ✨ The Solution

This plugin provides a simple, admin-friendly way to remove the problematic "_locale" meta fields from all Contact Form 7 forms in your WordPress installation.

## 📋 Features

- **One-Click Fix**: Remove all incorrect locale data with a single button click
- **Admin Dashboard**: Clean UI integrated into WordPress admin
- **Detailed Results**: See how many forms were processed and which ones had errors
- **Security**: Includes nonce verification to prevent CSRF attacks
- **Developer Friendly**: Can be used as a function in your theme or via WP-CLI

## 📥 Installation

### From GitHub:

1. Download the ZIP file from this repository
2. Go to your WordPress admin panel → Plugins → Add New
3. Click "Upload Plugin" and select the downloaded ZIP file
4. Click "Install Now" and then "Activate Plugin"

### Manual Installation:

1. Download and unzip the plugin
2. Upload the `remove-cf7-locale-meta` folder to your `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress

## 🚀 Usage

### Admin Interface

1. Navigate to **Tools → Remove CF7 Locale** in your WordPress admin menu
2. Click the "Remove _locale Meta Fields" button
3. Review the results summary that appears after processing



### Developer Usage

#### In functions.php:
```php
// Make sure the plugin is active first
if (function_exists('run_remove_cf7_locale_meta')) {
    $results = run_remove_cf7_locale_meta();
    // Process results as needed
    var_dump($results);
}
```

#### Via WP-CLI:
```bash
wp eval "print_r(run_remove_cf7_locale_meta());"
```

## 📊 Results Array

The function returns an array with the following information:

```php
[
    'found' => 10,    // Number of CF7 forms found
    'removed' => 8,   // Number of _locale meta fields removed
    'error' => 0,     // Number of errors encountered
    'errors' => []    // Array of error messages if any
]
```

## ⚠️ Important Notes

- Always back up your database before running this plugin
- This plugin is designed to be used once and then deactivated/removed
- Works with Contact Form 7 version 5.0 and higher
- Requires WordPress 5.0+

## 🛡️ Security

This plugin includes security measures:
- ABSPATH check to prevent direct file access
- Nonce verification for form submissions
- Required admin capabilities check

## 🔄 Compatibility

Tested with:
- WordPress 5.0 - 6.4
- Contact Form 7 5.0 - 5.8
- PHP 7.4 - 8.2

## 🧩 Extending

You can hook into the process for additional functionality:

```php
// Example: Run custom code before the process starts
add_action('before_remove_cf7_locale_meta', function() {
    // Your code here
});

// Example: Run custom code after the process completes
add_action('after_remove_cf7_locale_meta', function($results) {
    // Your code here using $results
}, 10, 1);
```

## 📝 License

GPL v2 or later. See [LICENSE](LICENSE) for details.

## 👨‍💻 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch: `git checkout -b feature/amazing-feature`
3. Commit your changes: `git commit -m 'Add some amazing feature'`
4. Push to the branch: `git push origin feature/amazing-feature`
5. Open a Pull Request

## 📚 Changelog

### 1.0.0
- Initial release
- Basic functionality to remove _locale meta fields
- Admin interface under Tools menu
