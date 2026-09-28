<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserAccounts extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();

        return view('user_accounts', $data);
    }

    public function new()
    {
        return view('user_new');
    }

    public function create()
    {
        $userModel = new UserModel();

        $data = [
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($userModel->insert($data)) {
            return redirect()->to('/user-accounts')->with('success', 'User created successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }
    }

    public function edit($id)
    {
        $userModel = new UserModel();
        $data['user'] = $userModel->find($id);

        if (!$data['user']) {
            return redirect()->to('/user-accounts')->with('error', 'User not found');
        }

        return view('user_edit', $data);
    }

    public function update($id)
    {
        $userModel = new UserModel();

        $username = $this->request->getPost('username');
        $fullName = $this->request->getPost('full_name');

        // Check if username is unique (excluding current user)
        $existingUser = $userModel->where('username', $username)->where('id !=', $id)->first();
        if ($existingUser) {
            return redirect()->back()->withInput()->with('error', 'Username already exists');
        }

        $data = [
            'username' => $username,
            'full_name' => $fullName
        ];

        // Handle avatar removal
        if ($this->request->getPost('remove_avatar')) {
            // Get current user data
            $currentUser = $userModel->find($id);
            if ($currentUser && !empty($currentUser['avatar'])) {
                // Delete avatar files
                $avatarPath = ROOTPATH . 'public/uploads/' . $currentUser['avatar'];
                $thumbPath = ROOTPATH . 'public/uploads/thumb_' . $currentUser['avatar'];

                if (file_exists($avatarPath)) {
                    unlink($avatarPath);
                }
                if (file_exists($thumbPath)) {
                    unlink($thumbPath);
                }

                $data['avatar'] = null;
            }
        }

        // Handle avatar upload
        $avatarFile = $this->request->getFile('avatar');
        if ($avatarFile && $avatarFile->isValid() && !$avatarFile->hasMoved()) {
            // Validate file type and size
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            $maxSize = 2 * 1024 * 1024; // 2MB

            if (!in_array($avatarFile->getClientMimeType(), $allowedTypes)) {
                return redirect()->back()->withInput()->with('error', 'Invalid file type. Only JPG and PNG files are allowed.');
            }

            if ($avatarFile->getSize() > $maxSize) {
                return redirect()->back()->withInput()->with('error', 'File size exceeds 2MB limit.');
            }

            // Generate unique filename
            $newName = $avatarFile->getRandomName();

            // Move file to uploads directory
            $avatarFile->move(ROOTPATH . 'public/uploads', $newName);

            // Create thumbnail/display-ready version
            $this->createThumbnail(ROOTPATH . 'public/uploads/' . $newName, ROOTPATH . 'public/uploads/thumb_' . $newName, 150, 150);

            // Delete old avatar files if they exist
            $currentUser = $userModel->find($id);
            if ($currentUser && !empty($currentUser['avatar'])) {
                $oldAvatarPath = ROOTPATH . 'public/uploads/' . $currentUser['avatar'];
                $oldThumbPath = ROOTPATH . 'public/uploads/thumb_' . $currentUser['avatar'];

                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
                if (file_exists($oldThumbPath)) {
                    unlink($oldThumbPath);
                }
            }

            $data['avatar'] = $newName;
        }

        if ($userModel->update($id, $data)) {
            return redirect()->to('/user-accounts')->with('success', 'User updated successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }
    }

    private function createThumbnail($sourcePath, $destPath, $width, $height)
    {
        try {
            $image = \Config\Services::image();

            // Read the image
            $image->withFile($sourcePath);

            // Fit the image to the specified dimensions while maintaining aspect ratio
            $image->fit($width, $height, 'center');

            // Save the thumbnail
            $image->save($destPath);

            return true;
        } catch (\Exception $e) {
            // If image processing fails, just copy the original file
            if (file_exists($sourcePath)) {
                copy($sourcePath, $destPath);
                return true;
            }
            return false;
        }
    }
}
