<?php

namespace App\EasyEat;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $fillable = array(
        "nom",
        "prenom",
        "sexe",
        "dateNaissance",
        "telephone",
        "lieuDeResidence",
        "socialAccountInJson",
        "authClientId"
    );
}
