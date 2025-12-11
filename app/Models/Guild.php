<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class Guild extends Model
{
    protected $table = 'guild';

    protected $primaryKey = 'guild_id';

    public $timestamps = false;

    public function emblem(): BelongsTo
    {
        return $this->belongsTo(GuildEmblem::class, 'guild_id', 'guild_id');
    }

    public function char(): BelongsTo
    {
        return $this->belongsTo(Char::class, 'char_id', 'char_id');
    }
    public function members(): BelongsTo
    {
        return $this->belongsTo(Char::class, 'guild_id', 'guild_id');
    }

    public function getEmblem(): string
    {
        if (!$this->emblem) {
            return '';
        }

        $image = imagecreatefromstring($this->emblem->file_data);

        if (!$image) {
            return '';
        }

        $rgb = imagecolorexact($image, 255, 0, 255);
        if ($rgb !== -1) {
            imagecolortransparent($image, $rgb);
        }

        $path = public_path("emblems/{$this->guild_id}.png");

        File::ensureDirectoryExists(public_path('emblems'));

        File::ensureDirectoryExists(public_path('emblems'));

        imagepng($image, $path);
        imagedestroy($image);

        return asset("emblems/{$this->guild_id}.png");
    }
}
