<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon expires_at
 * @property string token
 * @property string name
 * @property bool is_validated
 */
class Token extends Model
{

    public $incrementing = false;
    public $fillable = ['name'];
    protected $primaryKey = 'token';
    protected $dates = ['expires_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_validated' => 'boolean',
    ];

    /**
     * Generate a new token
     * @param null $name name of device
     * @param int $expires expiration of token in minutes (default 60)
     * @return static
     */
    public static function generate($name = null, $expires = 60)
    {
        $token = new static;
        $token->token = Str::upper(Str::random(3) . '-' . Str::random(3));
        $token->expires_at = Carbon::now()->addMinute($expires);
        $token->name = $name;
        $token->save();
        return $token;
    }

    /**
     * Clear expired tokens from the database
     *
     * @return mixed
     */
    public static function clean()
    {
        return static::expired()->delete();
    }

    /**
     * The "booting" method of the model
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('expires_at', '>', Carbon::now());
        });
    }

    /**
     * Query scope for expired tokens
     *
     * @param $query
     * @return mixed
     */
    public function scopeExpired($query)
    {
        return $query->withoutGlobalScope('active')->where('expires_at', '<', Carbon::now());
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'token';
    }

    /**
     * Validate the token
     *
     * @return $this
     */
    public function validate()
    {
        $this->is_validated = true;
        $this->save();

        return $this;
    }

    /**
     * Expire the token
     *
     * @return $this
     */
    public function expire()
    {
        $this->expires_at = Carbon::now();
        $this->save();

        return $this;
    }
}
