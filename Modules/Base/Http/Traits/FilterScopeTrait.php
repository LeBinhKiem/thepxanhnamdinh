<?php
/**
 * Created by PhpStorm.
 * User: Hungokata
 * Date: 6/2/19
 * Time: 18:08
 */
namespace Modules\Base\Http\Traits;
trait FilterScopeTrait
{
    public function scopeFilter($query, $filter = [])
    {
        if ($filter)
        {
            $query = $query->where(function ($q) use ($filter)
            {
                foreach ($filter as $f) {
                    list($col, $ope, $val) = $f;
                    $q->where($col, $ope, $val);
                }
            });
        }

        return $query;
    }

    public function scopeSort($query, $sorts = array())
    {
        if ($sorts)
        {
            foreach ($sorts as $sort) {
                list($col, $dir) = $sort;
                $query = $query->orderBy($col, $dir);
            }
        }
        return $query;
    }

    public function scopeFilterAndSort($query, $filters = [], $sorts = []){
        $query = $this->scopeFilter($query, $filters);
        $query = $this->scopeSort($query, $sorts);

        return $query;
    }
}