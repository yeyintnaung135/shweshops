<?php

namespace App\Http\Controllers\ShopOwner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\UserRole;
use App\Http\Requests\ShopOwner\StoreCollectionRequest;
use App\Http\Requests\ShopOwner\UpdateCollectionRequest;
use App\Models\Collection;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class CollectionController extends Controller
{
    use UserRole;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            abort_if(Gate::none(['access-shop-owner-premium', 'access-shop-role-premium']), 403);
            return $next($request);
        });
    }

    public function index(): View
    {
        return view('backend.shopowner.item.collection.index');
    }

    public function show(Collection $collection): View
    {
        $collectionItems = Item::where([
            ['shop_id', $this->get_shopid()],
            ['collection_id', $collection->id],
        ])->get();

        return view('backend.shopowner.item.collection.show', [
            'collection' => $collection,
            'collectionItems' => $collectionItems,
        ]);
    }

    public function create(): View
    {
        return view('backend.shopowner.item.collection.create');
    }

    public function store(StoreCollectionRequest $request): RedirectResponse
    {
        $collection = $request->validated();

        $collection['shop_id'] = $this->get_shopid();

        return Collection::create($collection)
        ? redirect()->route('backside.shop_owner.collections.index')->with('message', 'Your collection was successfully added')
        : redirect()->back()->with('message', 'Failed to create collection');
    }

    public function edit(Collection $collection): View
    {
        return view('backend.shopowner.item.collection.edit', ['collection' => $collection]);
    }

    public function update(UpdateCollectionRequest $request, Collection $collection): RedirectResponse
    {
        return $collection->update($request->validated())
        ? redirect()->route('backside.shop_owner.collections.index')->with('message', 'Your collection was successfully updated')
        : redirect()->back()->with('message', 'Failed to update collection');
    }

    public function destroy(Collection $collection): RedirectResponse
    {
        $items = Item::where([
            ['shop_id', $this->get_shopid()],
            ['collection_id', $collection->id],
        ])->get();

        foreach ($items as $item) {
            $item->update(['collection_id' => 0]);
        }

        if ($collection->delete()) {
            Session::flash('message', 'Your item was successfully removed');
            return redirect()->route('backside.shop_owner.collections.index');
        }

        return redirect()->back()
            ->with('message', 'Failed to update collection');
    }

    public function collection_items(Collection $collection): View
    {
        $collectionItems = Item::where([
            ['shop_id', $this->get_shopid()],
            ['collection_id', 0],
        ])->get();

        return view('backend.shopowner.item.collection.item-list', [
            'collection' => $collection,
            'collectionItems' => $collectionItems,
        ]);
    }

    public function add_item(Collection $collection, Request $request): RedirectResponse
    {
        Item::where([
            ['shop_id', $this->get_shopid()],
            ['id', $request->itemID],
        ])->update(['collection_id' => $collection->id]);

        Session::flash('message', 'Your item was successfully added to ' . $collection->name . ' collection');

        return redirect()->route('backside.shop_owner.collections.show', ['collection' => $collection]);
    }

    public function remove_item(Request $request): RedirectResponse
    {
        $item = Item::where([
            ['shop_id', $this->get_shopid()],
            ['id', $request->item_id],
        ])->first();

        if ($item) {
            $collectionId = $item->collection_id; // Store the collection_id before updating the item to pass as parameter in route
            $item->update(['collection_id' => 0]);

            Session::flash('message', 'Your item was successfully removed');

            return redirect()->route('backside.shop_owner.collections.show', ['collection' => $collectionId]);
        } else {
            Session::flash('message', 'Item not found');

            return redirect()->back();
        }
    }

    public function get_collections(Request $request): JsonResponse
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $collectionsQuery = Collection::where('shop_id', $this->get_shopid())
            ->select('id', 'name')
            ->withCount('items')
            ->when($fromDate, fn($query) => $query->whereDate('created_at', '>=', $fromDate))
            ->when($toDate, fn($query) => $query->whereDate('created_at', '<=', $toDate));

        return datatables($collectionsQuery)
            ->addColumn('actions', function ($collection) {
                $urls = [
                    'edit_url' => route('backside.shop_owner.collections.edit', $collection->id),
                    'delete_url' => route('backside.shop_owner.collections.destroy', $collection->id),
                    'detail_url' => route('backside.shop_owner.collections.show', $collection->id),
                ];

                return $urls;
            })
            ->toJson();
    }

    //TODO remove this when this still not being used after October 2023
    // private function calculate_item_counts($collections): array
    // {
    //     $itemCounts = [];

    //     foreach ($collections as $collection) {
    //         $itemCount = Item::where('collection_id', $collection->id)
    //             ->count();
    //         $itemCounts[$collection->id] = $itemCount;
    //     }

    //     return $itemCounts;
    // }

    public function get_collection_items(Request $request): JsonResponse
    {
        $collectionId = $request->input('collection');
        $collectionItems = Item::where([
            ['shop_id', $this->get_shopid()],
            ['collection_id', $collectionId],
        ])->select('id', 'name', 'product_code', 'price', 'min_price', 'max_price');

        return DataTables::of($collectionItems)
            ->addColumn('formatted_price', function ($item) {
                return $item->formatted_price;
            })
            ->addColumn('check_photothumbs', function ($item) {
                return $item->check_photothumbs;
            })
            ->addColumn('action', function ($item) {
                return '<button type="button" onclick="Delete(' . $item->id . ')" class="btn btn-sm btn-danger"><span class="fa fa-trash"></span> Remove</button>';
            })
            ->rawColumns(['default_photo', 'action'])
            ->make(true);
    }

    public function get_items(Request $request): JsonResponse
    {
        $collectionId = $request->input('collection');
        $collectionItems = Item::where([
            ['shop_id', $this->get_shopid()],
            ['collection_id', 0],
        ])->select('id', 'name', 'product_code', 'price', 'min_price', 'max_price');

        return DataTables::of($collectionItems)
            ->addColumn('formatted_price', function ($item) {
                return $item->formatted_price;
            })
            ->addColumn('check_photothumbs', function ($item) {
                return $item->check_photothumbs;
            })
            ->addColumn('action', function ($item) use ($collectionId) {
                $form = '
                <form method="post" action="' . route('backside.shop_owner.collections.item.add', ['collection' => $collectionId]) . '">
                    ' . csrf_field() . '
                    <input type="hidden" name="itemID" value="' . $item->id . '" />
                    <button type="submit" class="btn btn-md btn-primary">
                        <span class="fa fa-plus-circle"></span> Add
                    </button>
                </form>';

                return $form;
            })
            ->rawColumns(['default_photo', 'action'])
            ->toJson();
    }
}
