<?php

namespace App\Services;

use App\Models\Setting;

class NotificationService
{
    /**
     * Check if email notifications are enabled
     */
    public function isEmailEnabled(): bool
    {
        return (bool) Setting::get('email_notification_enabled', false);
    }

    /**
     * Get SMTP host
     */
    public function getSmtpHost(): ?string
    {
        return Setting::get('smtp_host');
    }

    /**
     * Get SMTP port
     */
    public function getSmtpPort(): int
    {
        return (int) Setting::get('smtp_port', 587);
    }

    /**
     * Get SMTP username
     */
    public function getSmtpUsername(): ?string
    {
        return Setting::get('smtp_username');
    }

    /**
     * Get SMTP password (actual value from DB)
     */
    public function getSmtpPassword(): ?string
    {
        return Setting::get('smtp_password');
    }

    /**
     * Get SMTP encryption type
     */
    public function getSmtpEncryption(): string
    {
        return Setting::get('smtp_encryption', 'tls');
    }

    /**
     * Get admin email for order notifications
     */
    public function getAdminEmail(): ?string
    {
        return Setting::get('order_notification_email');
    }

    /**
     * Get contact form email
     */
    public function getContactEmail(): ?string
    {
        return Setting::get('contact_form_email');
    }

    /**
     * Check if Zalo notifications are enabled
     */
    public function isZaloEnabled(): bool
    {
        return (bool) Setting::get('zalo_notification_enabled', false);
    }

    /**
     * Get Zalo OA ID
     */
    public function getZaloOaId(): ?string
    {
        return Setting::get('zalo_oa_id');
    }

    /**
     * Get Zalo Access Token
     */
    public function getZaloAccessToken(): ?string
    {
        return Setting::get('zalo_access_token');
    }

    /**
     * Get admin phone for Zalo notifications
     */
    public function getZaloAdminPhone(): ?string
    {
        return Setting::get('zalo_admin_phone');
    }

    /**
     * Apply SMTP settings to Laravel's mail config at runtime
     */
    public function applyMailConfig(): void
    {
        $host = $this->getSmtpHost();
        $port = $this->getSmtpPort();
        $username = $this->getSmtpUsername();
        $password = $this->getSmtpPassword();
        $encryption = $this->getSmtpEncryption();

        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => $host ?? '',
            'mail.mailers.smtp.port' => $port ?? 587,
            'mail.mailers.smtp.username' => $username ?? '',
            'mail.mailers.smtp.password' => $password ?? '',
            'mail.mailers.smtp.encryption' => $encryption ?? 'tls',
            'mail.from.address' => $username ?? '',
            'mail.from.name' => Setting::get('site_name', 'Lâm Nhiên Thảo'),
        ]);
    }

    /**
     * Check if mailer is properly configured
     */
    public function isMailerConfigured(): bool
    {
        $host = $this->getSmtpHost();
        
        // Need at least SMTP host to be configured
        if (empty($host)) {
            return false;
        }

        // Check if using log driver
        if (config('mail.default') === 'log') {
            return false;
        }

        return true;
    }

    /**
     * Get masked password for display purposes
     */
    public function getSmtpPasswordMasked(): string
    {
        $password = $this->getSmtpPassword();
        return $password ? '••••••••' : '';
    }
}
