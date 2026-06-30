<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $rows = DB::table('products')->whereNotNull('image')->get(['id', 'image', 'image_url']);

        foreach ($rows as $row) {
            $img = $row->image;

            if (filter_var($img, FILTER_VALIDATE_URL)) {
                DB::table('products')->where('id', $row->id)->update([
                    'image_url'  => $img,
                    'image'      => null,
                ]);
            }
        }
    }

    public function down(): void
    {
    }
};
