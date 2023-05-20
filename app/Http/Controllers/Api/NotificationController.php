<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SuccessResource;
use App\Models\Rit;
use App\Models\RitBranch;
use App\Models\Transaction;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function get_notification()
    {
        $notifications = [];
        $branches = Rit::where("branch_tonnage", ">", 0)->whereNotNull("sold_date")->get();
        if ($branches->isNotEmpty()) {
            array_push($notifications, ["title" => "Barang Cabang", "description" => "Ada barang cabang yang belum terjual!"]);
        }
        $otwRits = Rit::where('finance_approved', 1)
            ->whereNull('arrival_date')
            ->get();
        if ($otwRits->isNotEmpty()) {
            array_push($notifications, ["title" => "Barang Dalam Perjalanan", "description" => "Ada barang yang sedang dalam perjalanan. Pastikan sudah dimasukan jumlah tonase yang datang."]);
        }
        $unapprovedTransactions = Transaction::where('finance_approved', 0)
            ->where('owner_approved', 1)
            ->whereIn('type', ['eceran', 'kiriman'])
            ->get();
        if ($unapprovedTransactions->isNotEmpty()) {
            array_push($notifications, ["title" => "Input Pemasukan", "description" => "Ada penjualan yang sudah dikirim namun pemasukan yang didapat belum dicatat."]);
        }
        $return = [
            'api_code' => 200,
            'api_status' => true,
            'api_message' => 'Sukses',
            'api_results' => $notifications
        ];
        return SuccessResource::make($return);
    }
}
