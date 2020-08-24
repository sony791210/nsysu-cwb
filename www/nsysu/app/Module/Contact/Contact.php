<?php

namespace App\Module\Contact;

use App\Module\Base;

use Ksd\Adminer\Models\Role;

class Contact extends Base
{
    /**
     * setting modle's table name
     *
     * @var string
     */
    protected $table = 'contact';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'phone',
        'subject',
        'content',
        'email',
        'created_at',
        'updated_at'];



}
