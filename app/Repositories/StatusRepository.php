<?php

namespace App\Repositories;

use App\Models\Status;
use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use App\Classes\BaseHelper as BH;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StatusRepository
{
    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', null);
        $isPaginate   = $request->input('is_paginate', true);
        $paginateSize = BH::checkPaginateSize($paginateSize);
        $name         = $request->input("name", null);
        $status       = $request->input("status", null);

        try {
            $statuses = Status::with(["createdBy:id,name"])
            ->when($name, fn ($query) => $query->where("name", "like", "%$name%"))
            ->when($status, fn ($query) => $query->where("status", $status))
            ->orderBy('created_at', 'desc');

            if ($isPaginate) {
                $statuses = $statuses->paginate($paginateSize);
            } else {
                $statuses = $statuses->get();
            }

            return $statuses;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            throw $exception;
        }
    }

    public function show($id)
    {
        try {
            $status = Status::with(["createdBy:id,name"])->find($id);

            return $status;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            throw $exception;
        }
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();

            $status = new Status();
            $status->name       = $request->name;
            $status->slug       = Str::slug($request->name);
            $status->bg_color   = $request->bg_color;
            $status->text_color = $request->text_color;
            $status->status     = $request->status ?? StatusEnum::ACTIVE;
            $status->save();

            DB::commit();

            return $status;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            DB::rollback();

            throw $exception;
        }
    }

    public function update($request, Status $status)
    {
        try {
            DB::beginTransaction();

            $status->name       = $request->name;
            $status->slug       = Str::slug($request->name);
            $status->bg_color   = $request->bg_color;
            $status->text_color = $request->text_color;
            $status->status     = $request->status ?? StatusEnum::ACTIVE;
            $status->save();

            DB::commit();

            return $status;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            DB::rollback();

            throw $exception;
        }
    }
}
