<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Banner",
 *     description="Banner model with name, image, and description",
 *     @OA\Xml(
 *         name="Banner"
 *     )
 * )
 */
class Banner extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *     title="Name",
     *     description="Name of the banner",
     *     example="Summer Sale Banner"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *     title="Image",
     *     description="URL of the banner image",
     *     example="https://example.com/banners/summer-sale.png"
     * )
     *
     * @var string
     */
    public $image;

    /**
     * @OA\Property(
     *     title="Description",
     *     description="Description of the banner",
     *     example="This banner is for the summer sale promotion."
     * )
     *
     * @var string
     */
    public $description;
    
    protected $fillable = [
        'name',
        'image',
        'description'
    ];
}
