<?php

namespace App\Models;

use App\Http\Requests\StoreContactRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Builder;

class Contact extends Model
{
    protected $fillable = ['user_id', 'school_id', 'subject', 'message', 'readed', 'isAdmin'];

    /**
     * @param Admin $user
     * @param StoreContactRequest $request
     * @return mixed
     */
    public static function store(Admin $user, $data)
    {
        $data['user_id'] = $user->id;
        $data['school_id'] = $user->getSchool()->id;


        return self::create($data);
    }

    public static function reply($id, $message)
    {
        try {
            $contact = self::findOrFail($id);
            $email = $contact->sender->email;
            $data = [
                'text' => $message
            ];
            Mail::send('mail.reply', $data, function ($m) use ($email) {
                $m->to($email)
                    ->subject('Thanks for Contacting Us!');
            });
            return true;
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
    }

    public function attachments()
    {
        return $this->hasMany(ContactsAttachment::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function sender() {
        if ($this->isAdmin) {
            return $this->admin();
        }
        else {
            return $this->user();
        }
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'id', 'user_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderByDesc('id');
        });
    }
}
