<?php

namespace App\Controllers;

use App\Models\TaskModel;

class TaskController extends BaseController
{
    public function index() {
        $model = new TaskModel();

        $data['tasks'] = $model->where('is_archived', false)->findAll();
        return view('tasks/index', $data);
    }

    public function new() {
        return view('tasks/new');
    }

    public function create() {
        $rules = [
            'title'     => 'required|min_length[3]',
            'task_date' => 'required|valid_date'
        ];[cite: 1]

        if (!$this->validate($rules)) {
            return view('tasks/new', ['validation' => $this->validator]);
        }

        $model = new TaskModel();
        $model->save([
            'title'       => $this->request->getPost('title'),
            'task_date'   => $this->request->getPost('task_date'),
            'is_archived' => false
        ]);

        return redirect()->to('/tasks');
    }

    public function edit($id) {
        $model = new TaskModel();
        $data['task'] = $model->find($id);

        if (empty($data['task'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Task not found: ' . $id);
        }

        return view('tasks/edit', $data);
    }

    public function update($id) {
        $rules = [
            'title'     => 'required|min_length[3]',
            'task_date' => 'required|valid_date'
        ];[cite: 1]

        if (!$this->validate($rules)) {
            $model = new TaskModel();
            $data['task'] = $model->find($id);
            $data['validation'] = $this->validator;
            return view('tasks/edit', $data);
        }

        $model = new TaskModel();
        $model->update($id, [
            'title'     => $this->request->getPost('title'),
            'task_date' => $this->request->getPost('task_date')
        ]);

        return redirect()->to('/tasks');
    }

    public function delete($id) {
        $model = new TaskModel();

        $model->update($id, ['is_archived' => true]);
        return redirect()->to('/tasks');
    }
}
