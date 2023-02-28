<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Project extends Model
{
    use HasFactory;

    // Inserire lista tabella quando nella funzione store() usiamo fill()
    protected $fillable = ['slug', 'title', 'description', 'thumb', 'creation_date', 'type_id', 'completed'];

    // definisco la relazione one to many (più projects dipendono da un singolo type)
    public function type(){
        return $this->belongsTo(Type::class);
    }

    //uso la soft deletes
    use SoftDeletes;

    //uso una funzione per visualizzare lo slug nella rotta al posto dell'id
    public function getRouteKeyName()
    {
        return 'slug';
    }

    //uso una funzione per stabilire se l'immagine è un url o un file
    public function isImageAUrl(){
        return filter_var($this->thumb, FILTER_VALIDATE_URL);
    }

}

