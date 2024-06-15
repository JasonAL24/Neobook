<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OwenIt\Auditing\Models\Audit;

class TruncateAuditLogs extends Command
{
    protected $signature = 'audit:truncate';
    protected $description = 'Truncate audit logs';

    public function handle()
    {
        Audit::truncate();
        $this->info('Audit logs truncated successfully.');
    }
}
