<?php

namespace App\EasyEat;

use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    //
    protected $fillable = array(
        "nom",
        "prenom",
        "sexe",
        "dateNaissance",
        "adresse",
        "email",
        "telephone",
        "coordonneBancaireInJson",
        "authClientId",
    );
}
