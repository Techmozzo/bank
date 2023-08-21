<?php


namespace App\Http\View\Composers;


use App\Traits\HashId;
use Illuminate\View\View;

class AdminData
{
    use HashId;

    public function compose(View $view)
    {
        $hashIds = $this->key();
        return $view->with(['hashIds' => $hashIds]);
    }
}
