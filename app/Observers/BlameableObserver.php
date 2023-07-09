<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BlameableObserver
{
    public function creating(Model $model)
    {
        if (Auth::hasUser())
        {
            $model->created_by = Auth::user()->id;
            $model->updated_by = Auth::user()->id;
        }
        else
        {
            $model->created_by = 0;
            $model->updated_by = 0;
        }
    }

    public function updating(Model $model)
    {
        if (Auth::hasUser())
        {
            $model->updated_by = Auth::user()->id;
        }
        else
        {
            $model->updated_by = 0;
        }
    }
}
