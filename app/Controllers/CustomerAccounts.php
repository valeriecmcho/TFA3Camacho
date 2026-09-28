<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class CustomerAccounts extends BaseController
{
    public function index()
    {
        $customerModel = new CustomerModel();
        $data['customers'] = $customerModel->findAll();

        return view('customer_accounts', $data);
    }

    public function new()
    {
        return view('customer_new');
    }

    public function create()
    {
        $customerModel = new CustomerModel();

        // Check if email already exists
        $email = $this->request->getPost('email');
        $existingCustomer = $customerModel->where('email', $email)->first();
        if ($existingCustomer) {
            return redirect()->back()->withInput()->with('error', 'Email already exists');
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $email,
            'phone' => $this->request->getPost('phone'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($customerModel->insert($data)) {
            return redirect()->to('/customer-accounts')->with('success', 'Customer created successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $customerModel->errors());
        }
    }

    public function edit($id)
    {
        $customerModel = new CustomerModel();
        $data['customer'] = $customerModel->find($id);

        if (!$data['customer']) {
            return redirect()->to('/customer-accounts')->with('error', 'Customer not found');
        }

        return view('customer_edit', $data);
    }

    public function update($id)
    {
        $customerModel = new CustomerModel();

        $email = $this->request->getPost('email');

        // Check if email is unique (excluding current customer)
        $existingCustomer = $customerModel->where('email', $email)->where('id !=', $id)->first();
        if ($existingCustomer) {
            return redirect()->back()->withInput()->with('error', 'Email already exists');
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $email,
            'phone' => $this->request->getPost('phone')
        ];

        if ($customerModel->update($id, $data)) {
            return redirect()->to('/customer-accounts')->with('success', 'Customer updated successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $customerModel->errors());
        }
    }
}
