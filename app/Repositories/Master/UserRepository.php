<?php

namespace App\Repositories\Master;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Requests\User\StoreRequest;
use App\Interfaces\Master\UserInterface;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\Master\UserResource;
use Symfony\Component\HttpFoundation\Response;

class UserRepository implements UserInterface
{
    use ResponseTrait;

    public function index(Request $request)
    {
        try {
            $collection = User::latest();
            $keyword = str($request->query("search"));
            $isNotPaginate = $request->query("not-paginate");

            if ($keyword) {
                $collection->where('username', 'LIKE', "%$keyword%");
            }

            if ($isNotPaginate) {
                $collection = $collection->get();
            } else {
                $collection = $collection
                    ->paginate($request->recordsPerPage)
                    ->appends(request()->query());
            }

            $result = UserResource::collection($collection)
                ->response()
                ->getData(true);

            return $this->wrapResponse(Response::HTTP_OK, 'Data berhasil dimuat', $result);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($resource = User::create($validatedData)) {
                $resource = (new UserResource($resource))
                    ->response()
                    ->getData(true);

                return $this->wrapResponse(Response::HTTP_CREATED, 'Data berhasil ditambah', $resource);
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $resource = User::findOrFail($id);
            $validatedData = $request->validated();

            if ($resource->update($validatedData)) {
                $resource = (new UserResource($resource))
                    ->response()
                    ->getData(true);

                return $this->wrapResponse(Response::HTTP_OK, 'Data berhasil diperbarui', $resource);
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function destroy($id)
    {
        try {
            $resource = User::findOrFail($id);

            if ($resource) {
                $resource->delete();

                return $this->wrapResponse(Response::HTTP_OK, 'Data berhasil dihapus');
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
