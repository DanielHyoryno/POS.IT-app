<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use PDO;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Prefer a committed CA file (best for Vercel)
        $caPath = base_path('certs/aiven-ca.pem');

        // If you still keep PEM in env, normalize + write to /tmp (serverless writable)
        $pem = env('MYSQL_ATTR_SSL_CA');
        if ($pem && str_contains($pem, 'BEGIN CERTIFICATE')) {
            $pem = str_replace(["\r\n", "\r"], "\n", $pem);
            $tmp = sys_get_temp_dir() . '/aiven-ca.pem';
            file_put_contents($tmp, $pem);
            $caPath = $tmp;
        }

        if (extension_loaded('pdo_mysql') && file_exists($caPath)) {
            config([
                'database.connections.mysql.options' => array_filter([
                    PDO::MYSQL_ATTR_SSL_CA => $caPath,
                    // turn off verify if your runtime is picky
                    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
                ]),
            ]);
        }
    }

    public function boot(): void {}
}
