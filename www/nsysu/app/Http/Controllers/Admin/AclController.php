<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Ksd\Adminer\Services\AclService;

class AclController extends BaseController
{
    protected $service;

    public function __construct(AclService $service)
    {
        $this->service = $service;
    }

    /**
     * 列表
     * @return
     */
    public function index()
    {
        $data['fields'] = collect([
            ['prop' => 'description', 'label' => trans('admin/acl.description')],
            ['prop' => 'name', 'label' => trans('admin/acl.name')],
        ])->toJson();

        $data['list'] = $this->service->all(1, PHP_INT_MAX)->map(function ($row) {
            return [
                'id'           => $row->id,
                'name'         => $row->name,
                'description'  => $row->description,
                'editUrl'      => route('acl.view.edit', ['id' => $row->id])
            ];
        })->toJson();

        return view('admin.acl.index', $data);
    }

    /**
     * 新增
     * @return
     */
    public function new()
    {
        return view('admin.acl.new');
    }

    /**
     * 新增
     * @return
     */
    public function create(Request $request)
    {
        try {
            $result = $this->service->create($request->only(['name', 'description']));

            return ($result) ? $this->apiRespSuccess() : $this->apiRespFailCode('E0002');
        } catch (\Exception $e) {
            return $this->apiRespFail('E0002' , $e->getMessage());
        }
    }

    /**
     * 編輯
     * @return
     */
    public function edit($id)
    {
        if (!$id) return redirect()->route('acl.index');

        $data['acl'] = $this->service->find($id)->toJson();

        return view('admin.acl.edit', $data);
    }

    /**
     * 編輯
     * @return
     */
    public function update(Request $request, $id)
    {
        try {
            if (!$id) return $this->apiRespFailCode('E0003');

            $result = $this->service->update($id, $request->only(['name', 'description']));

            return ($result) ? $this->apiRespSuccess() : $this->apiRespFailCode('E0003');
        } catch (\Exception $e) {
            return $this->apiRespFail('E0003' , $e->getMessage());
        }
    }
}
