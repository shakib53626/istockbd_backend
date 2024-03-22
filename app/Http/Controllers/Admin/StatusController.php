<?php

namespace App\Http\Controllers\Admin;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Classes\BaseController;
use App\Http\Requests\Admin\CreateStatusRequest;
use Illuminate\Support\Facades\Log;
use App\Repositories\StatusRepository;
use App\Http\Resources\Admin\StatusResource;
use App\Http\Resources\Admin\StatusCollection;
use App\Http\Requests\Admin\UpdateStatusRequest;

class StatusController extends BaseController
{
    protected $repository;

    public function __construct(StatusRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        if (!$request->user()->hasPermission('statuses-read')) {
            return $this->sendError(__("common.unauthorized"));
        }

        try {
            $statuses = $this->repository->index($request);

            $statuses = new StatusCollection($statuses);

            return $this->sendResponse($statuses, "Status list");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->sendError(__("common.commonError"));
        }
    }

    public function store(CreateStatusRequest $request)
    {
        if (!$request->user()->hasPermission('statuses-create')) {
            return $this->sendError(__("common.unauthorized"));
        }

        try {

            $status = $this->repository->store($request);

            $status = new StatusResource($status);

            return $this->sendResponse($status, "Status Created successfully");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->sendError(__("common.commonError"));
        }
    }

    public function show(Request $request, $id)
    {
        if (!$request->user()->hasPermission('statuses-read')) {
            return $this->sendError(__("common.unauthorized"));
        }

        try {
            $status = $this->repository->show($id);
            if (!$status) {
                return $this->sendError("Status not found", 404);
            }

            $status = new StatusResource($status);

            return $this->sendResponse($status, "Status single view");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->sendError(__("common.commonError"));
        }
    }

    function update(UpdateStatusRequest $request, $id)
    {
        if (!$request->user()->hasPermission('statuses-update')) {
            return $this->sendError(__("common.unauthorized"));
        }

        try {
            $status = Status::find($id);

            if (!$status) {
                return $this->sendError("Status not found");
            }

            $status = $this->repository->update($request, $status);

            $status = new StatusResource($status);

            return $this->sendResponse($status, "Status updated successfully");
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->sendError(__("common.commonError"));
        }
    }
}
