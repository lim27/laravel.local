<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Models\BlogCategory;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\CoreRepository;

use Illuminate\Http\Request;


class CategoryController extends BaseController
{

    /**
     * @var BlogCategoryRepository
     */
    private $blogCategoryRepository;

    public function __construct()
    {
        parent::__construtc();

        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$paginator = BlogCategory::paginate(15);
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(5);

        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new BlogCategory();
        $categoryList
            = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();
        if (empty($data['slug'])) {
            $data['slug'] = str_slug($data['title']);
        }

        //sozdaet obekt, no ne dobavlyaet v bd
      /*  $item = new BlogCategory($data);
        dd($item);
        $item->save();*/

      $item = (new BlogCategory())->create($data);

        if ($item) {
            return redirect()->route('blog.admin.categories.edit', [$item->id])
                ->with(['success' => 'Успешно сохранено']);
            } else {
            return back()->withErrors(['msg' =>'Ошибка сохранения'])
                -> withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id, BlogCategoryRepository $categoryRepository)
    {
        /*$item = BlogCategory::find($id);
        $categoryList = BlogCategory::all();*/

       // $item = $categoryRepository->getEdit($id);
        $item = $this->$this->blogCategoryRepository->getEdit($id);
        if(empty($item)) {
            abort(404);
        }

        $categoryList
            = $this->blogCategoryRepository->getForComboBox();


        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        //dd(__METHOD__, $request->all(), $id);
        #$id = 111;
       /* $rules = [
            'title'         => 'required|min:5|max:200',
            'slug'          => 'max:200',
            'description'   => 'string|max:500|min:3',
            'parent_id'     => 'required|integer|exists:blog_categories,id',
        ];*/

        #$validatedData = $this->validate($request, $rules);
        #$validatedData = $request->validate($rules);
        /*$validator = Validator::make{$request->all(), $rules};
        $validatedData[] = $validator->passes();
        $validatedData[] = $validator->validate();
        $validatedData[] = $validator->valid();
        $validatedData[] = $validator->failed();
        $validatedData[] = $validator->errors();
        $validatedData[] = $validator->fails();*/

       # dd($validatedData);

       // $item = BlogCategory::find($id);

        $item = $this->blogCategoryRepository->getEdit($id);

        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();

        if (empty($data['slug'])) {
            $data['slug'] = str_slug($data['title']);
        }

        $result = $item->update($data);
       /* $result = $item
            ->fill($data)
            ->save();*/

        if ($result) {
            return redirect()
                ->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        }   else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

}
