<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationTestController extends Controller
{
    /**
     * Test Session Flash Messages
     */
    public function testSession()
    {
        return back()->with('success', 'Bu bir test success mesajıdır!');
    }

    /**
     * Test AJAX JSON Response
     */
    public function testAjax()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Bu bir AJAX success mesajıdır!'
        ]);
    }

    /**
     * Test Error
     */
    public function testError()
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Bu bir hata mesajıdır!'
        ]);
    }
}
