<?php

namespace App;


use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Merchandiser extends Authenticatable implements JWTSubject, Searchable
{
    use Notifiable;

    public function getSearchResult(): SearchResult
    {
        $url = route('shop.details', $this->id);

        $avg_rating = ShopReview::where('merchandiser_id', $this->id)->avg('rating');
        $data = [
            'avg_rating' =>$avg_rating,
            'campus' => $this->campus,
            'no_of_followers' => $this->followers->count()
        ];

        return new SearchResult(
            $this,
            json_encode($data),
            $url
        );
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name', 'email', 'password', 'company_description', 'campus_id', 'phone', 'avatar', 'cover_photo', 'valid_id', 'shop_type_id', 'isActive', 'payment_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function getJWTCustomClaims()
    {
        return [];
    }

    public function campus()
    {
        return $this->belongsTo('App\Campus');
    }


    public function product()
    {
        return $this->hasMany('App\Product');
    }


    public function followers()
    {
        return $this->hasMany('App\Follower');
    }



    public function shopType()
    {
        return $this->belongsTo('App\ShopType');
    }


    public function review()
    {
        return $this->hasMany('App\ShopReview');
    }


    public function sellersBillingDetail()
    {
        return $this->hasOne(BillingDetail::class);
    }

    public function addSellersBillingDetail($billing_detail)
    {
        return $this->sellersBillingDetail()->updateOrCreate($billing_detail);
    }

    public function payment()
    {
        return $this->belongsTo(MerchandiserPayment::class);
    }


    public function addPayment($payment)
    {
        $this->payment()->create($payment);
    }



}
