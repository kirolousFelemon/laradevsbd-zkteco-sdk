<?php

namespace App\Http\Controllers;

use Laradevsbd\Zkteco\Http\Library\ZKTecoLib;
use Illuminate\Http\Request;

class ZKTecoController extends Controller
{
    protected $zk;

    public function __construct()
    {
        // Initialize ZKTecoLib with device IP and port from environment variables
        $this->zk = new ZKTecoLib(env('ZKTECO_DEVICE_IP'), env('ZKTECO_DEVICE_PORT'));
    }

    public function connect()
    {
        // Attempt to connect to the ZKTeco device
        if ($this->zk->connect()) {
            return response()->json(['status' => 'Connected to ZKTeco device']);
        } else {
            return response()->json(['status' => 'Failed to connect to ZKTeco device'], 500);
        }
    }

    public function getAttendanceLogs()
    {
        // Connect and fetch attendance logs
        if ($this->zk->connect()) {
            $attendanceLogs = $this->zk->getAttendance();
            $this->zk->disconnect();

            return response()->json($attendanceLogs);
        } else {
            return response()->json(['status' => 'Could not connect to the device'], 500);
        }
    }
}
