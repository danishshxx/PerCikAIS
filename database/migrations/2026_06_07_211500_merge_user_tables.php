<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        // 1. Add profile columns to the shared LMS `User` table first (so copy step won't fail)
        if (Schema::hasTable('User')) {
            Schema::table('User', function (Blueprint $table) {
                if (!Schema::hasColumn('User', 'profile_photo_path')) {
                    $table->string('profile_photo_path')->nullable();
                }
                if (!Schema::hasColumn('User', 'nis')) {
                    $table->string('nis')->nullable();
                }
                if (!Schema::hasColumn('User', 'phone')) {
                    $table->string('phone')->nullable();
                }
                if (!Schema::hasColumn('User', 'gender')) {
                    $table->string('gender')->nullable();
                }
                if (!Schema::hasColumn('User', 'birth_place')) {
                    $table->string('birth_place')->nullable();
                }
                if (!Schema::hasColumn('User', 'birth_date')) {
                    $table->date('birth_date')->nullable();
                }
                if (!Schema::hasColumn('User', 'address')) {
                    $table->text('address')->nullable();
                }
                if (!Schema::hasColumn('User', 'remember_token')) {
                    $table->string('remember_token', 100)->nullable();
                }
            });
        }

        // 2. Copy passwords and profile fields from `users` to `User`
        if (Schema::hasTable('users') && Schema::hasTable('User')) {
            $laravelUsers = DB::table('users')->get();
            foreach ($laravelUsers as $u) {
                $email = strtolower(trim($u->email));
                $exists = DB::table('User')->where('email', $email)->first();
                if ($exists) {
                    // Update password and profile fields on User
                    DB::table('User')->where('id', $exists->id)->update([
                        'password' => $u->password,
                        'nis' => $u->nis ?? $exists->nis ?? null,
                        'phone' => $u->phone ?? $exists->phone ?? null,
                        'gender' => $u->gender ?? $exists->gender ?? null,
                        'birth_place' => $u->birth_place ?? $exists->birth_place ?? null,
                        'birth_date' => $u->birth_date ?? $exists->birth_date ?? null,
                        'address' => $u->address ?? $exists->address ?? null,
                        'profile_photo_path' => $u->profile_photo_path ?? $exists->profile_photo_path ?? null,
                    ]);
                } else {
                    // Insert into User
                    $id = $u->rust_user_id ?: 'c' . substr(str_replace('-', '', Illuminate\Support\Str::uuid()->toString()), 0, 24);
                    DB::table('User')->insert([
                        'id' => $id,
                        'name' => $u->name,
                        'email' => $email,
                        'password' => $u->password,
                        'role' => strtoupper($u->role),
                        'nis' => $u->nis,
                        'phone' => $u->phone,
                        'gender' => $u->gender,
                        'birth_place' => $u->birth_place,
                        'birth_date' => $u->birth_date,
                        'address' => $u->address,
                        'profile_photo_path' => $u->profile_photo_path,
                        'createdAt' => $u->created_at ?: now(),
                        'updatedAt' => $u->updated_at ?: now(),
                    ]);
                }
            }
        }

        // 3. Drop foreign keys on attendances and invoices if they exist
        if (Schema::hasTable('attendances')) {
            $hasKey = collect(DB::select("
                SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'attendances'
                  AND CONSTRAINT_NAME = 'attendances_user_id_foreign'
            "))->isNotEmpty();

            if ($hasKey) {
                Schema::table('attendances', function (Blueprint $table) {
                    $table->dropForeign('attendances_user_id_foreign');
                });
            }
        }

        if (Schema::hasTable('invoices')) {
            $hasInvoiceKey = collect(DB::select("
                SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'invoices'
                  AND CONSTRAINT_NAME = 'invoices_user_id_foreign'
            "))->isNotEmpty();

            if ($hasInvoiceKey) {
                Schema::table('invoices', function (Blueprint $table) {
                    $table->dropForeign('invoices_user_id_foreign');
                });
            }
        }

        // 4. Alter columns to string/varchar(191) to match CUID type
        if (Schema::hasTable('attendances')) {
            Schema::table('attendances', function (Blueprint $table) {
                $table->string('user_id', 191)->change();
            });
        }

        if (Schema::hasTable('invoices')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->string('user_id', 191)->change();
            });
        }

        if (Schema::hasTable('sessions')) {
            Schema::table('sessions', function (Blueprint $table) {
                $table->string('user_id', 191)->nullable()->change();
            });
        }

        // 5. Drop the redundant Laravel `users` table
        Schema::dropIfExists('users');

        // 6. Re-create foreign keys pointing to `User` table
        if (Schema::hasTable('attendances') && Schema::hasTable('User')) {
            Schema::table('attendances', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('User')->cascadeOnDelete();
            });
        }

        if (Schema::hasTable('invoices') && Schema::hasTable('User')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('User')->cascadeOnDelete();
            });
        }

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-creating the users table is not needed as it is fully replaced by User table
    }
};
