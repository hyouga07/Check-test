<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $contacts = Contact::with('category')
            ->name($request->name)
            ->gender($request->gender)
            ->category($request->detail)
            ->date($request->date)
            ->paginate(7);
        $categories = Category::all();
        return view('admin', compact('contacts'));
    }
    public function export(Request $request)
        {
        $contacts = Contact::with('category')
            ->name($request->name)
            ->gender($request->gender)
            ->category($request->detail)
            ->date($request->date)
            ->get();

        $csvHeader = [
            'お名前',
            '性別',
            'メールアドレス',
            'お問い合わせの種類',
            '電話番号',
            '住所',
            '建物名',
            '作成日'
        ];

        $csvData = [];
        foreach ($contacts as $contact) {
            $csvData[] = [
                $contact->last_name . ' ' . $contact->first_name,
                $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他'),
                $contact->email,
                $contact->detail,
                $contact->tel,
                $contact->address,
                $contact->building,
                $contact->created_at->format('Y-m-d'),
            ];
        }

        $fileName = 'contacts_' . date('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($csvHeader, $csvData) {
            $stream = fopen('php://output', 'w');
            fprintf($stream, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($stream, $csvHeader);
            foreach ($csvData as $row) {
                fputcsv($stream, $row);
            }
            fclose($stream);
        }, $fileName);
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return response()->json($contact);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        Contact::findOrFail($id)->delete();
        return redirect()
            ->route('admin.index')
            ->with('success', '削除しました。');
    }
}
