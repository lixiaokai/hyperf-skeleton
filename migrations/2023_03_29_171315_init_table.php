<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Migrations\Migration;
use Hyperf\DbConnection\Db;

/**
 * 初始化.
 */
class InitTable extends Migration
{
    public function up(): void
    {
        $filename = BASE_PATH . '/migrations/init.sql';
        $sql = file_get_contents($filename);
        Db::unprepared($sql);
    }

    public function down(): void
    {
        Schema::dropIfExists('app');
        Schema::dropIfExists('app_tenant');
        Schema::dropIfExists('app_user');
        Schema::dropIfExists('menu');
        Schema::dropIfExists('permission');
        Schema::dropIfExists('role');
        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('tenant');
        Schema::dropIfExists('tenant_role');
        Schema::dropIfExists('tenant_user');
        Schema::dropIfExists('user');
        Schema::dropIfExists('user_admin');
        Schema::dropIfExists('user_auth');
        Schema::dropIfExists('_test');
    }
}
