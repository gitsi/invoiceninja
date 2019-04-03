<?php

namespace App\Http\Controllers;

use App\Factory\ProductFactory;
use App\Filters\ProductFilters;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\EditProductRequest;
use App\Http\Requests\Product\ShowProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Transformers\ProductTransformer;
use App\Utils\Traits\MakesHash;
use Illuminate\Http\Request;

class ProductController extends BaseController
{

    use MakesHash;

    protected $entity_type = Product::class;

    protected $entity_transformer = ProductTransformer::class;

    protected $product_repo;

   /**
     * ProductController constructor.
     */
    public function __construct(ProductRepository $product_repo)
    {

        parent::__construct();

        $this->product_repo = $product_repo;
    }

    /**
     */
    public function index(ProductFilters $filters)
    {
        
        $products = Product::filter($filters);
        
        return $this->listResponse($products);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateProductRequest $request)
    {
        $product = ProductFactory::create(auth()->user()->company()->id, auth()->user()->id);

        return $this->itemResponse($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->product_repo->save($request, ProductFactory::create(auth()->user()->company()->id, auth()->user()->id));

        return $this->itemResponse($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShowProductRequest $request, Product $product)
    {
        return $this->itemResponse($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EditProductRequest $request, Product $product)
    {
        return $this->itemResponse($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
