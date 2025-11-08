<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Permission;
use App\Models\User;

class ModularPermissionSeeder extends Seeder
{
    /**
     * Sadece dashboard permission
     */
    private array $permissions = [
        'dashboard' => 'Dashboard Erişimi',
    ];

    /**
     * Sadece 2 rol: software ve normal user
     */
    private array $roles = [
        'normal user' => [
            'name' => 'normal user',
            'display_name' => 'Normal User',
            'description_tr' => 'Normal kullanıcı',
            'description_en' => 'Normal user',
            'permissions' => ['dashboard']
        ],
        'software' => [
            'name' => 'software',
            'display_name' => 'Software',
            'description_tr' => 'Yazılım',
            'description_en' => 'Software',
            'permissions' => ['dashboard']
        ]
    ];

    /**
     * Sadece 2 test kullanıcısı
     */
    private array $testUsers = [
        [
            'name' => 'Normal User',
            'username' => 'normaluser',
            'email' => 'user@test.com',
            'password' => 'password',
            'roles' => ['normal user']
        ],
        [
            'name' => 'Software User',
            'username' => 'software',
            'email' => 'software@test.com',
            'password' => 'password',
            'roles' => ['software', 'normal user'] // Software kullanıcısı tüm rollere sahip
        ]
    ];

    public function run(): void
    {
        $this->command->info('🚀 Simplified Permission Seeder başlatılıyor...');

        // 1. İzinleri oluştur
        $this->createPermissions();

        // 2. Rolleri oluştur ve izinleri ata
        $this->createRolesAndAssignPermissions();

        // 3. Test kullanıcıları oluştur
        $this->createTestUsers();

        $this->command->info('✅ Simplified Permission Seeder tamamlandı!');
    }

    /**
     * İzinleri oluştur
     */
    private function createPermissions(): void
    {
        $this->command->info('📋 İzinler oluşturuluyor...');

        foreach ($this->permissions as $name => $description) {
            Permission::updateOrCreate(
                ['name' => $name],
                [
                    'guard_name' => 'web',
                    'description_tr' => $description,
                    'description_en' => $description, // İngilizce için de aynı
                ]
            );
            $this->command->line("  └── 🔑 {$name} oluşturuldu");
        }
    }

    /**
     * Rolleri oluştur ve izinleri ata
     */
    private function createRolesAndAssignPermissions(): void
    {
        $this->command->info('👑 Roller oluşturuluyor ve izinler atanıyor...');

        foreach ($this->roles as $roleKey => $roleData) {
            // Rolü oluştur
            $role = Role::updateOrCreate(
                ['name' => $roleData['name']],
                [
                    'guard_name' => 'web',
                    'display_name' => $roleData['display_name'],
                    'description_tr' => $roleData['description_tr'],
                    'description_en' => $roleData['description_en'],
                ]
            );

            // İzinleri ata
            if (in_array('*', $roleData['permissions'])) {
                $role->syncPermissions(Permission::all());
                $this->command->line("  └── 👑 {$roleData['display_name']} rolü oluşturuldu (tüm izinler)");
            } else {
                $role->syncPermissions($roleData['permissions']);
                $this->command->line("  └── 👑 {$roleData['display_name']} rolü oluşturuldu (" . count($roleData['permissions']) . " izin)");
            }
        }
    }

    /**
     * İzin pattern'lerini çöz
     */
    private function resolvePermissions(array $permissionPatterns)
    {
        $resolvedPermissions = collect();

        foreach ($permissionPatterns as $pattern) {
            if ($pattern === '*') {
                // Tüm izinler
                $resolvedPermissions = $resolvedPermissions->merge(Permission::all());
            } elseif (str_ends_with($pattern, '*')) {
                // Wildcard pattern (örn: users.*)
                $prefix = str_replace('*', '', $pattern);
                $matchingPermissions = Permission::where('name', 'like', $prefix . '%')->get();
                $resolvedPermissions = $resolvedPermissions->merge($matchingPermissions);
            } else {
                // Exact match
                $permission = Permission::where('name', $pattern)->first();
                if ($permission) {
                    $resolvedPermissions->push($permission);
                }
            }
        }

        return $resolvedPermissions->unique('id');
    }

    /**
     * Test kullanıcıları oluştur
     */
    private function createTestUsers(): void
    {
        $this->command->info('👥 Test kullanıcıları oluşturuluyor...');

        foreach ($this->testUsers as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'username' => $userData['username'],
                    'password' => bcrypt($userData['password']),
                ]
            );

            // Rolleri ata
            $user->syncRoles($userData['roles']);

            $this->command->line("  └── 👤 {$userData['name']} ({$userData['username']}) oluşturuldu ve rolleri atandı: " . implode(', ', $userData['roles']));
        }
    }
}
