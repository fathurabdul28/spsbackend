<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankAccount;

class BankAccountWebController extends Controller
{

    public function index()
    {
        $bankAccounts = BankAccount::latest()->paginate(15);
        return view('bank-account.index', compact('bankAccounts'));
    }

    public function create()
    {
        return view('bank-account.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name'      => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_name'   => 'required|string|max:255',
            'logo'           => 'nullable|image|max:1024',
        ]);

        $data = $request->only(['bank_name', 'account_number', 'account_name']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('bank-logos', 'public');
        }

        BankAccount::create($data);

        return redirect()->route('bank-account.index')->with('status', 'Rekening bank berhasil ditambahkan.');
    }

    public function edit(BankAccount $bankAccount)
    {
        return view('bank-account.edit', compact('bankAccount'));
    }

    public function update(Request $request, BankAccount $bankAccount)
    {
        $request->validate([
            'bank_name'      => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_name'   => 'required|string|max:255',
            'logo'           => 'nullable|image|max:1024',
        ]);

        $data = $request->only(['bank_name', 'account_number', 'account_name']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('bank-logos', 'public');
        }

        $bankAccount->update($data);

        return redirect()->route('bank-account.index')->with('status', 'Rekening bank berhasil diperbarui.');
    }

    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();
        return redirect()->route('bank-account.index')->with('status', 'Rekening bank berhasil dihapus.');
    }
}
