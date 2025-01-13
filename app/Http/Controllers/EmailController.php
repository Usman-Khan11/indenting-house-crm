<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use App\Mail\InquiryEmail;
use App\Mail\TestMail;
use App\Models\EmailHistory;
use App\Models\Inquiry;
use App\Models\Supplier;
use App\Models\SupplierProducts;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class EmailController extends Controller
{
    public function emailSetting()
    {
        $data['page_title'] = 'Email Configuration';
        $data['general_setting'] = GeneralSetting::first(['mail_config']);

        return view('email.email_setting', $data);
    }

    public function emailSettingUpdate(Request $request)
    {
        $request->validate([
            'email_method' => 'required|in:php,smtp,sendgrid,mailjet',
            'host' => 'required_if:email_method,smtp',
            'port' => 'required_if:email_method,smtp',
            'mail_name' => 'required_if:email_method,smtp',
            'username' => 'required_if:email_method,smtp',
            'password' => 'required_if:email_method,smtp',
            'appkey' => 'required_if:email_method,sendgrid',
            'public_key' => 'required_if:email_method,mailjet',
            'secret_key' => 'required_if:email_method,mailjet',
        ], [
            'host.required_if' => ':attribute is required for SMTP configuration',
            'port.required_if' => ':attribute is required for SMTP configuration',
            'mail_name.required_if' => ':attribute is required for SMTP configuration',
            'username.required_if' => ':attribute is required for SMTP configuration',
            'password.required_if' => ':attribute is required for SMTP configuration',
            'enc.required_if' => ':attribute is required for SMTP configuration',
            'appkey.required_if' => ':attribute is required for SendGrid configuration',
            'public_key.required_if' => ':attribute is required for Mailjet configuration',
            'secret_key.required_if' => ':attribute is required for Mailjet configuration',
        ]);

        if ($request->email_method == 'php') {
            $data['name'] = 'php';
        } else if ($request->email_method == 'smtp') {
            $request->merge(['name' => 'smtp']);
            $data = $request->only('name', 'host', 'port', 'mail_name', 'enc', 'username', 'password', 'driver');
            updateEnv(
                [
                    "MAIL_MAILER" => "smtp",
                    "MAIL_HOST" => $request->host,
                    "MAIL_PORT" => $request->port,
                    "MAIL_USERNAME" => $request->username,
                    "MAIL_PASSWORD" => $request->password,
                    "MAIL_ENCRYPTION" => $request->enc,
                    "MAIL_FROM_ADDRESS" => $request->username,
                    "MAIL_FROM_NAME" => $request->mail_name,
                ]
            );
        } else if ($request->email_method == 'sendgrid') {
            $request->merge(['name' => 'sendgrid']);
            $data = $request->only('name', 'appkey');
        } else if ($request->email_method == 'mailjet') {
            $request->merge(['name' => 'mailjet']);
            $data = $request->only('name', 'public_key', 'secret_key');
        }

        $general_setting = GeneralSetting::first();
        $general_setting->mail_config = $data;
        $general_setting->save();

        return redirect()->route('email.setting')->withSuccess('Email configuration has been updated.');
    }

    public function emailHistory(Request $request)
    {
        $data['page_title'] = 'Email History';

        if ($request->ajax()) {
            $query = EmailHistory::Query();
            $query = $query->with('user');
            $query = $query->latest()->get();
            return DataTables::of($query)->addIndexColumn()->make(true);
        }

        return view('email.email_history', $data);
    }

    public function emailHistoryView($id)
    {
        $data['page_title'] = 'Email History View';
        $data['email_history'] = EmailHistory::where('id', $id)->first();

        return view('email.email_history_view', $data);
    }

    public function sendTestMail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $data['name'] = 'Testing Mail';
        $data['message'] = "This is a test email, please ignore if you are not meant to be get this email.";

        try {
            Mail::to($request->email)->queue(new TestMail($data));
        } catch (\Exception $exp) {
            return back()->withError('Invalid Credential');
        }

        return back()->withSuccess('You should receive a test mail at ' . $request->email . ' shortly.');
    }

    public function emailInquiry(Request $request)
    {
        $id = $request->inquiry_id;
        $data['inquiry'] = Inquiry::where('id', $id)->with('items', 'supplier', 'items.suppliers')->first();
        $item_ids = $data['inquiry']->items->pluck('item_id')->toArray();
        $supplier_ids = $request->supplier ?? [];
        $suppliers = Supplier::whereIn('id', $supplier_ids)->get();

        if (count($suppliers) == 0) {
            return back()->withError('No supplier found.');
        }

        try {
            $data['subject'] = "Inquiry " . $data['inquiry']->inq_no . " Details";
            foreach ($suppliers as $supplier) {
                $a = SupplierProducts::whereIn('product_id', $item_ids)
                    ->where('supplier_id', $supplier->id)
                    ->pluck('product_id')
                    ->toArray();

                $data['inquiry_items'] = $data["inquiry"]->items->whereIn('item_id', $a);
                $data['supplier'] = $supplier;

                $recipients = array_filter([
                    $supplier->email ?? null,
                    $supplier->email_2 ?? null,
                    $supplier->email_3 ?? null,
                ]);

                Mail::to($recipients)->queue(new InquiryEmail($data));
            }

            $email_history = new EmailHistory();
            $email_history->user_id = auth()->user()->id;
            $email_history->content = view('email.templates.inquiry', ['data' => $data]);
            $email_history->save();
        } catch (\Exception $exp) {
            return back()->withError('Email not sent.');
        }

        return back()->withSuccess('Email sent successfully!');
    }
}
