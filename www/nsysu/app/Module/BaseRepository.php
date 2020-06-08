<?php

namespace App\Module;

use Exception;
use Illuminate\Database\QueryException;

class BaseRepository
{
    protected $model;
    protected $limit = 20;


    public function getModel()
    {
        return $this->model;
    }

    /**
     * 新增 or 更新
     * @param array $keys
     * @param array $data
     * @return bool
     */
    public function createOrUpdate(array $keys, array $data)
    {
    	try {
	    	if (!$keys || !$data) throw new Exception('keys or data not found');

            return $this->model->updateOrCreate($keys, $data);
	    } catch (QueryException $e) {
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data)
    {
    	try {
	    	if (!$id || !$data) throw new Exception('id or data not found');

            $model = $this->model->find($id);
            if (!$model) throw new Exception('model not found');
            foreach ($data as $key => $val) {
                $model->{$key} = $val;
            }
            $model->save();

	        return $model;
	    } catch (QueryException $e) {
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * 刪除
     * @param int $id
     * @param array $keys
     * @return bool
     */
    public function delete(int $id, array $keys = [])
    {
    	try {
    		if (!$id && !$keys) throw new Exception('id or keys not found');

	    	if ($id) {
	    		return $this->model->find($id)->delete();
	    	}
	    	elseif ($keys) {
	    		return $this->model->where($keys)->delete();
	    	}
	    } catch (QueryException $e) {
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * find one
     * @param int $id
     * @return
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * find all
     */
    public function all()
    {
        return $this->model->all();
    }
}
