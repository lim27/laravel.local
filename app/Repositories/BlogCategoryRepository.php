<?php

namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BlogCategoryRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }
    /** Получить модель в админке для редактирования в админке
     *
     *@param int $id
     *
     *@return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * список категорий для вывода в выпадающем списке
     * @return Collection
     */
    public function getForComboBox()
    {
        //return $this->startConditions()->all();

        $columns = implode(',', [
            'id',
            'CONCAT (id, ". ", title) AS id_title',
        ]);

       /* $result[] = $this->startConditions()->all();
        $result[] = $this
            ->startConditions()
            ->select('blog_caterogies.*',
                DB::row('CONCAT (id, ". ", title) AS id_title'))
            ->toBase()
            ->get();*/

        $result[] = $this
            ->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();

        return $result;

    }

    /**
     * Получить категории для вывода пагинатором
     *
     * @param int\null $perPage
     *
     * @return LengthAwarePaginator
     *
     */

    public function getAllWithPaginate($perPage = null)
    {
        $columns = ['id', 'title', 'parent_id'];

        $result = $this
            ->startConditions()
            ->select($columns)
            ->paginate($perPage);

        return $result;
    }

}

