<?php

namespace App\Models\Base;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BaseModel
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @method static Builder|BaseModel newModelQuery()
 * @method static Builder|BaseModel newQuery()
 * @method static Builder|BaseModel query()
 * @method static Builder|BaseModel whereCategory($value)
 * @method static Builder|BaseModel whereCreatedAt($value)
 * @method static Builder|BaseModel whereFirstReleaseDate($value)
 * @method static Builder|BaseModel whereGenres($value)
 * @method static Builder|BaseModel whereId($value)
 * @method static Builder|BaseModel whereName($value)
 * @method static Builder|BaseModel whereRating($value)
 * @method static Builder|BaseModel whereSummary($value)
 * @method static Builder|BaseModel whereUpdatedAt($value)
 * @method static Builder|BaseModel find($value)
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    use HasFactory;
}
